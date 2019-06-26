{{-- {{ Main Menu at the top of the frontend }} --}}

<div class="mainmenu">
    <a href="/" class="logo">
        <img src="/all/images/osc-blog-logo.svg" />
    </a>

    <ul class="desktophide icons-mobile">
        {{-- {{ Search button }} --}}
        <li>
            <a href="#" data-toggle="modal" data-target="#exampleModalLong">
            <i class="ico-search"></i>
            </a>
        </li>
        {{-- <li>
            <a href="https://www.openstudycollege.com/checkout">
            <i class="ico-basket"></i>
            </a>
        </li> --}}
    </ul>

    <nav>
        <ul>
            {{-- <li class="desktophide"><a href="#">Blog Home</a></li>
            <li class="desktophide"><a href="#">Main Website</a></li> --}}

            {{-- {{ if we have post categories }} --}}
            @if(isset($post_categories) && !empty($post_categories))
              @for ($i=0; $i < count($post_categories); $i++)
                @if (isset($post_categories[$i]['category_id']) && !empty($post_categories[$i]['category_id']) && isset($post_categories[$i]['category']) && !empty($post_categories[$i]['category']))
                  <li><a href="{{ "/category/" . $post_categories[$i]['category_id']}}">{{$post_categories[$i]['category']}}</a></li>
                @endif
              @endfor
            @endif
            <li><a href="https://www.openstudycollege.com/contact">Contact Us</a></li>
        </ul>
    </nav>
</div>
