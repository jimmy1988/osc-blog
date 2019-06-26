{{-- {{ Single post pages }} --}}

{{-- {{ Get main content }} --}}
@extends("frontend.templates.post")

{{-- {{ Start of page content }} --}}
@section('section')

  <div id="belowheader">
    <section id="blogcontent" class="">
        <article>
          @isset($postPreview)
            {{-- {{ if we have a preview post to view then display its content }} --}}
            {!! $postPreview['post_content'] !!}

          @elseif(isset($post['post_content']) && !empty($post['post_content']))
            {{-- {{ if we have a real post to view then display its content }} --}}
            {!! $post['post_content'] !!}

          @endisset
        </article>
        <!-- /Article -->

    </section>
  </div>
  <div class="clearfix"></div>

@endsection
{{-- {{ End Page Content }} --}}
