{{-- {{ Basic search results page }} --}}

{{-- {{ Get the main template }} --}}
@extends("frontend.templates.pages")
{{-- {{ start of page content }} --}}
@section('section')
  <div id="belowheader">
    <div class="search">

      <section class="feed-recent-stories blogfeed" id="recent-stories">
        <div id="results_container" class="results">

          <div class="results__body" id="results__body">
            {{-- {{ if we have the search results then we can display them }} --}}
            @if(isset($searchResults) && !empty($searchResults) && count($searchResults)>0)

              {{-- {{ Get the search results container }} --}}
              <h6 class="results__title" id="results__title">Search results:  <span>{{count($searchResults)}}</span> articles found</h6>

              {{-- {{ Produc the search results }} --}}
              @for($i=0; $i < count($searchResults);$i++)

                <div class="search--result">
                  <a href="  @if (isset($searchResults[$i]->post_slug) && !empty($searchResults[$i]->post_slug)){{ "/post/" . $searchResults[$i]->post_slug }} @else {{ "#" }} @endif">
                    <div class="result_inner">
                      <h5>@if (isset($searchResults[$i]['post_created']) && !empty($searchResults[$i]['post_created'])) {{ date("d/m/y", strtotime($searchResults[$i]['post_created'])) }} @endif</h5>
                      <h2>@if (isset($searchResults[$i]['post_title']) && !empty($searchResults[$i]['post_title'])) {{ $searchResults[$i]['post_title'] }} @endif</h2>
                    </div>
                  </a>
                </div>

              @endfor

            @else

              {{-- {{ if we do not have any search results then display a message }} --}}
              <div class="search--result">
                <a href="#">
                  <div class="result_inner">
                    <h2>No search results found with that criteria</h2>
                  </div>
                </a>
              </div>

            @endif

          </div><!-- /.results__body -->
        </div><!-- /.results -->

      </section>
    </div>
  </div>
@endsection
{{-- {{ End of page content }} --}}
