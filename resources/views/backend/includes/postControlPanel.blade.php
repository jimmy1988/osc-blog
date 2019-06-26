<?php
  //set default add media button flag based on whether we have the flag or not
  if(!isset($addMediaButton) || empty($addMediaButton)){
    $addMediaButton = "true";
  }else{
    $addMediaButton = $addMediaButton;
  }

  //set the create post button flag based on whether we have the flag or not
  if(!isset($createPostButton) || empty($createPostButton)){
    $createPostButton = "true";
  }else{
    $createPostButton = $createPostButton;
  }
?>

<div class="content-wrapper content-padding" id="control-panel-container">
  <div class="row">
    {{-- {{ If we have the flag and it is true, then we display the button }} --}}
    @if ($addMediaButton == "true")
      <div class="col-sm-6 text-left">
        <a href="/admin/media" target="_blank" class="btn btn-success bg-green" id="addMediaButton"><i class="fas fa-image"></i>&nbsp;<span>Add Media</span></a>
      </div>
    @endif

    {{-- {{ If we have the flag and it is true, tehn we display the button }} --}}
    @if ($createPostButton == "true")
      <div class="col-sm-6 @if ($addMediaButton == "true" && $createPostButton == "true") text-right @else text-left @endif">
        <a href="/admin/post/create" class="btn btn-success bg-pink" id="createPostButton"><i class="fas fa-plus"></i>&nbsp;<span>Create Post</span></a>
      </div>
    @endif
  </div>
</div>
