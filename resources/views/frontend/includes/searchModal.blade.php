{{-- {{ Search pop up for the live search }} --}}

<!-- Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">

      <div class="search">
        {{-- {{ Search form }} --}}
    		<form action="?" method="get">
    			<label for="q" class="hidden">Search</label>

    			<input id="search_input" type="search" class="search__field" name="q" placeholder="Search our blog" autofocus />
          <a href="#" class="btn-close" data-dismiss="modal">
              <i class="ico-cross"></i>
          </a>
    		</form>

        {{-- {{ How many articles found }} --}}
        <h6 class="results__title title-hidden" id="results__title">Search results:  <span></span> articles found</h6>

        <div class="modal-body">
              <div id="results_container" class="results results-hidden">
                {{-- {{ Search results }} --}}
  							<div class="results__body" id="results__body">


  							</div><!-- /.results__body -->
  						</div><!-- /.results -->


           </div>
        </div><!-- /.search -->

        <div class="bg-animation-container">
  					<span class="bg-animation"></span>
  			</div><!-- /.bg-animation-container -->
    </div>
  </div>
</div>
