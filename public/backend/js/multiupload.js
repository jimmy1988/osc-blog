function multiUploader(config){

	this.config = config;
	this.items = "";
	this.all = []
	var self = this;
	var field = "";
	var inputFields = "";

	multiUploader.prototype._init = function(){
		if (window.File &&
			window.FileReader &&
			window.FileList &&
			window.Blob) {
			 var inputId = $("#"+this.config.form).find("input[type='file']").eq(0).attr("id");
			 document.getElementById(inputId).addEventListener("change", this._read, false);
			 document.getElementById(this.config.dragArea).addEventListener("dragover", function(e){ e.stopPropagation(); e.preventDefault(); }, false);
			 document.getElementById(this.config.dragArea).addEventListener("drop", this._dropFiles, false);
			 document.getElementById(this.config.form).addEventListener("submit", this._submit, false);
		} else{
			console.log("Browser supports failed");
		}

	}

	multiUploader.prototype._submit = function(e){
		e.stopPropagation(); e.preventDefault();
		self._startUpload();
	}

	multiUploader.prototype._preview = function(data){
		this.items = data;
		var input = $("#multiUpload");
		if(this.items.length > 0){

 			for(var i = 0; i<this.items.length; i++){
				var html = "";
				var uId = "";
				var sampleIcon = '<img src="/backend/images/image.png" />';
				var errorClass = "";

				if(typeof this.items[i] != undefined){
					if(self._validate(this.items[i].type) <= 0) {
						var error = "";
						error = "<p><strong>File name: " + this.items[i].name + " is not of a correct format, supported formats are '" + this.config.support + "'</strong></p>";

						$("#" + this.config.errorContainer).prepend(error);
						$("#" + this.config.errorContainer).show();
						$("#multiUpload").val("");
					}else{
						if(this.items[i].size >= this.config.minFileSizeBytes && this.items[i].size <= this.config.maxFileSizeBytes){
							uId = this.items[i].name._unique();
							uId = encodeURI(uId);
							html += '<div id=\"' + uId + '\" class="dfiles'+errorClass+'" rel="'+uId+'"><h5>'+sampleIcon+this.items[i].name+'</h5><div class="cleafix"></div><div id="'+uId+'" class="progress" style="display:none;"><img src="/backend/images/ajax-loader.gif" /></div></div>';

							$("#dragAndDropFiles").append(html);
						}else{
							var error = "";
							error = "<p><strong>File name: " + this.items[i].name + " is too big, Maximum size allowed is  " + this.config.maxFileSizeBytes/(1024 * 1024) + "Mbs</strong></p>";

							$("#" + this.config.errorContainer).prepend(error);
							$("#" + this.config.errorContainer).show();
							$("#multiUpload").val("");
						}
					}
				}else{
					var error = "";
					error = "<p><strong>File name: " + file[f].name + " cannot be read</strong></p>";

					$("#" + this.config.errorContainer).prepend(error);
					$("#" + this.config.errorContainer).show();
					$("#multiUpload").val("");
				}
			}
		}
	}

	multiUploader.prototype._read = function(evt){
		if(evt.target.files){
			self._preview(evt.target.files);
			self.all.push(evt.target.files);
		} else{
			var error = "";
			error = "<p><strong>Cannot read the files</strong></p>";

			$("#" + this.config.errorContainer).prepend(error);
		}
	}

	multiUploader.prototype._validate = function(format){
		var arr = this.config.support.split(",");
		return arr.indexOf(format);
	}

	multiUploader.prototype._dropFiles = function(e){
		e.stopPropagation(); e.preventDefault();
		self._preview(e.dataTransfer.files);
		self.all.push(e.dataTransfer.files);
	}

	multiUploader.prototype._uploader = function(file,f){

		$("#" + this.config.errorContainer).hide();
		$("#" + this.config.errorContainer).html("");

		if(typeof file[f] != undefined && self._validate(file[f].type) > 0){
			var data = new FormData();
			var ids = file[f].name._unique();
			ids = encodeURI(ids);
			data.append('file',file[f]);
			data.append('index',ids);
			$(".dfiles[rel='"+ids+"']").find(".progress").show();
			$.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('input[name="_token"]').val()
                  }
              });
			$.ajax({
				type:"POST",
				url:this.config.uploadUrl,
				data:data,
				cache: false,
				contentType: false,
				processData: false,
				success:function(rponse){
					$("#"+ $.escapeSelector("#" + ids)).hide();
					var jsonResponse = JSON.parse(rponse);
					var rponseID = jsonResponse.index;
					var obj = $(".dfiles").get();
					inputFields = "";
					for (field in jsonResponse) {
  					inputFields = inputFields + "<input type=\"hidden\" class=\"inputMediaFieldHidden\" name=\"" + field + "\" id=\"" + field + "\" value=\"" + jsonResponse[field] + "\">";
					}

					$.each(obj,function(k,fle){
						if($(fle).attr("rel") == rponseID){
							$(fle).slideUp("normal", function(){ $(this).remove(); });
							$("#allImagesContainer").prepend(html1 + jsonResponse.media_id + html2 + jsonResponse.media_id + html3 + inputFields + html4 + jsonResponse.media_id + html5 + jsonResponse.media_alt_text + html6 + encodeURI(jsonResponse.media_file_name) + html7).slideDown(500);
						}
					});
					if (f+1 < file.length) {
						self._uploader(file,f+1);
					}
				}
			});
		} else{

			var error = "";
			error = "<p><strong>File name: " + file[f].name + " is not of a correct format, supported formats are '" + this.config.support + "'</strong></p>";

			$("#" + this.config.errorContainer).prepend(error);
			$("#" + this.config.errorContainer).show();
		}
	}

	multiUploader.prototype._startUpload = function(){
		if(this.all.length > 0){
			for(var k=0; k<this.all.length; k++){
				var file = this.all[k];
				this._uploader(file,0);
			}
		}
	}

	String.prototype._unique = function(){
		return this.replace(/[a-zA-Z]/g, function(c){
     	   return String.fromCharCode((c <= "Z" ? 90 : 122) >= (c = c.charCodeAt(0) + 13) ? c : c - 26);
    	});
	}

	this._init();
}

function initMultiUploader(){
	new multiUploader(config);
}
