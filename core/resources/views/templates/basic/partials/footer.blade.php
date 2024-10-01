<!-- footer section start -->
<footer class="footer-section">
    <div class="footer-bottom">
      <div class="container">
        <hr>
        <div class="row">
          <div class="col-lg-8 col-md-6 text-md-start text-center">
            <p>@lang('Copyright') &copy; {{ date('Y') }} {{ $general->sitename }}. @lang('All Rights Reserved.')</p>
          </div>
          <div class="col-lg-4 col-md-6 mt-md-0 mt-3">
            @php
              $links = getContent('policy_pages.element');
            @endphp
            <ul class="link-list justify-content-md-end justify-content-center">
              @foreach($links as $link)
              <li><a href="{{ route('policy.pages',[slug($link->data_values->title),$link->id]) }}">{{ __($link->data_values->title) }}</a></li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
</footer>
  <!-- footer section end -->
