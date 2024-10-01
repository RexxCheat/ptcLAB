@php
    $testimonialCaption = getContent('testimonial.content',true);
    $testimonials = getContent('testimonial.element');
@endphp


    <!-- testimonial section start -->
    <section class="pt-150 pb-150">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="section-header text-center">
              <h2 class="section-title">{{ __($testimonialCaption->data_values->heading) }}</h2>
              <p>{{ __($testimonialCaption->data_values->subheading) }}</p>
            </div>
          </div>
        </div><!-- row end -->
        <div class="row">
          <div class="col-lg-12">
            <div class="testimonial-slider">
                @foreach($testimonials as $testimonial)
              <div class="single-slide">
                <div class="testimonial-card">
                  <div class="thumb"><img src="{{ getImage('assets/images/frontend/testimonial/'.$testimonial->data_values->image) }}" alt="image"></div>
                  <h5 class="name">{{ __($testimonial->data_values->name) }}</h5>
                  <span class="designation">{{ __($testimonial->data_values->designation) }}</span>
                  <p>{{ __($testimonial->data_values->comment) }}</p>
                </div>
              </div>
              @endforeach
            </div><!-- testimonial-slider end -->
          </div>
        </div>
      </div>
    </section>
    <!-- testimonial section end -->
