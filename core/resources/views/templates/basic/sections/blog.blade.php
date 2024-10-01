@php
    $blogCaption = getContent('blog.content',true);
    $blogs = getContent('blog.element',false,3);
@endphp

    <section class="pb-150">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="section-header text-center">
              <h2 class="section-title">{{__($blogCaption->data_values->heading)}}</h2>
              <p>{{__($blogCaption->data_values->subheading)}}</p>
            </div>
          </div>
        </div><!-- row end -->
        <div class="row mb-none-30 justify-content-center">
            @foreach($blogs as $blog)
          <div class="col-lg-4 col-md-6 mb-30 wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
            <div class="blog-post hover--effect-1 has-link">
              <a href="{{ route('blogDetail',$blog->id) }}" class="item-link"></a>
              <div class="blog-post__thumb">
                <img src="{{ getImage('assets/images/frontend/blog/'.$blog->data_values->image) }}" alt="image" class="w-100">
              </div>
              <div class="blog-post__content">
                <h4 class="blog-post__title">{{ __($blog->data_values->title) }}</h4>
                <p>{{ strLimit(strip_tags($blog->data_values->description),80) }}</p>
                <i class="blog-post__icon las la-arrow-right"></i>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </section>
