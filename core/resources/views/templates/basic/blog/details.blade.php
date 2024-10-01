@extends($activeTemplate .'layouts.frontend')
@section('content')

<section class="blog-details-section pt-150 pb-150">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-8">
          <div class="blog-details-wrapper">
            <div class="blog-details__thumb">
              <img src="{{ getImage('assets/images/frontend/blog/'.$blog->data_values->image) }}" alt="image">
              <div class="post__date">
                <span class="date">{{ $blog->created_at->format('d') }}</span>
                <span class="month">{{ $blog->created_at->format('M') }}</span>
              </div>
            </div><!-- blog-details__thumb end -->
            <div class="blog-details__content">
              <h4 class="blog-details__title">{{ __($blog->data_values->title) }}</h4>
              <p>@php echo $blog->data_values->description @endphp</p>
            </div><!-- blog-details__content end -->
            <div class="blog-details__footer">
              <h4 class="caption">@lang('Share This Post')</h4>
              <ul class="social__links">
                <li><a href="https://www.facebook.com/sharer/sharer.php?u={{urlencode(url()->current()) }}"><i class="fab fa-facebook-f"></i></a></li>
                <li><a href="https://twitter.com/intent/tweet?text=my share text&amp;url={{urlencode(url()->current()) }}"><i class="fab fa-twitter"></i></a></li>
                <li><a href="https://pinterest.com/pin/create/bookmarklet/?media={{ asset('assets/images/frontend/blog').'/'.$blog->data_values->image }}&url={{urlencode(url()->current()) }}&is_video=[is_video]&description={{$blog->data_values->title}}"><i class="fab fa-pinterest-p"></i></a></li>
                <li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{urlencode(url()->current()) }}"><i class="fab fa-linkedin-in"></i></a></li>
              </ul>
            </div><!-- blog-details__footer end -->
          </div><!-- blog-details-wrapper end -->
          <div class="comment-form-area">
                <div class="fb-comments" data-href="{{ route('blogDetail',$blog->id) }}" data-width="" data-numposts="5"></div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4">
          <div class="sidebar">
            <div class="widget">
              <h5 class="widget__title">@lang('Recent Posts')</h5>
              <ul class="small-post-list">
              	@foreach($latests as $recent)
              <li class="small-post">
                  <div class="small-post__thumb"><img src="{{ getImage('assets/images/frontend/blog/thumb_'.$recent->data_values->image) }}" alt="image"></div>
                  <div class="small-post__content">
                    <h5 class="post__title"><a href="{{ route('blogDetail',$recent->id) }}">{{ __($recent->data_values->title) }}</a></h5>
                  </div>
                </li>
                @endforeach
              </ul><!-- small-post-list end -->
            </div><!-- widget end -->
            <div class="widget">
              <h5 class="widget__title">@lang('Most Views')</h5>
              <ul class="small-post-list">
              	@foreach($popular as $view)
              <li class="small-post">
                  <div class="small-post__thumb"><img src="{{ getImage('assets/images/frontend/blog/thumb_'.$view->data_values->image) }}" alt="image"></div>
                  <div class="small-post__content">
                    <h5 class="post__title"><a href="{{ route('blogDetail',$view->id) }}">{{ __($view->data_values->title) }}</a></h5>
                  </div>
                </li>
                @endforeach
              </ul><!-- small-post-list end -->
            </div><!-- widget end -->
          </div><!-- sidebar end -->
        </div>
      </div>
    </div>
  </section>
@endsection

@push('fbComment')
    @php echo loadExtension('fb-comment') @endphp
@endpush
