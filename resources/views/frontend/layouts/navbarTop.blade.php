{{-- {{ Frontend top navbar }} --}}

<div class="topmenu mobilehide">
    <!--Display a tel link with the office phone number-->
    <a class="totel" href="tel:{{ TEL_NUMBER }}">Call us: {{ TEL_NUMBER_HUMAN }}</a>

    {{-- {{ Start of menu }} --}}
    <ul class="">
        <li>
          <a href="/">
            <i class="ico-home-pink"></i>
            <i class="ico-home"></i>
            Blog Home
          </a>
        </li>
        <li>
          <a href="https://www.openstudycollege.com" target="_blank">
            <i class="ico-return-pink"></i>
            <i class="ico-return"></i>
            Main Website
          </a>
        </li>
        <li>
          <a href="#" data-toggle="modal" data-target="#searchModal">
            <i class="ico-search-pink"></i>
            <i class="ico-search"></i>
            Search
          </a>
        </li>
        {{-- <li><a href="https://www.openstudycollege.com/checkout" target="_blank">
            <i class="ico-basket-pink"></i>
            <i class="ico-basket"></i>
            Your Basket</a></li> --}}
    </ul>
    {{-- {{ End of menu }} --}}
</div>
