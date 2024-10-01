@php
    $faqCaption = getContent('faq.content',true);
    $faqs = getContent('faq.element');
@endphp


    <section class="pt-150 pb-150 section--bg">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="section-header text-center">
              <h2 class="section-title">{{ __($faqCaption->data_values->heading) }}</h2>
              <p>{{ __($faqCaption->data_values->subheading) }}</p>
            </div>
          </div>
        </div><!-- row end -->
        <div class="row">
          <div class="col-lg-12">
            <div class="accordion cmn-accordion" id="accordionExample">
              @foreach($faqs as $key => $faql)
              <div class="card">
                <div class="card-header" id="heading{{ $key }}">
                  <button class="btn btn-link btn-block text-left collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $key }}" aria-expanded="false" aria-controls="collapse{{ $key }}">
                    <i class="las la-question-circle"></i>
                    <span>{{ __($faql->data_values->question) }}</span>
                  </button>
                </div>

                <div id="collapse{{ $key }}" class="collapse @if($loop->first) show @endif" aria-labelledby="heading{{ $key }}" data-bs-parent="#accordionExample">
                  <div class="card-body">
                    <p>{{ __($faql->data_values->answer) }}</p>
                  </div>
                </div>
              </div><!-- card end -->
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </section>
