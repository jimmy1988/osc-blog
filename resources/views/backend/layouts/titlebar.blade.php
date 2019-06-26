{{-- {{ Title Bar }} --}}

@if(isset($page_title) && !empty($page_title))
  <div class="content-wrapper content-padding">
    <div class="row">
      <div class="col-12">
        <h3 class="page-title">
          {{-- {{ Display the page title }} --}}
          {{$page_title}}
          {{-- {{ Display the post status }} --}}
          @if (isset($postArray->post_status) && !empty($postArray->post_status))
            {{-- {{ Draft Status }} --}}
            @if ($postArray->post_status == "1")
              <span class="post-status post-status-draft">Draft</span>
            @elseif($postArray->post_status == "2")
              {{-- {{ Public status }} --}}
              <span class="post-status post-status-public">Public</span>
            @endif
          @endif
        </h3>
      </div>
    </div>
  </div>
@endif
