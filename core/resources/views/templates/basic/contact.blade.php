@extends($activeTemplate.'layouts.frontend')
@section('content')
@php
$infos = getContent('contact.element');
$contact = getContent('contact.content',true);
@endphp
<section class="pt-150 pb-150">
    <div class="container">
      <div class="row mb-none-40">
        @foreach($infos as $info)
        <div class="col-lg-4 col-md-6 mb-40">
          <div class="contact-item">
            <div class="icon">
              @php echo $info->data_values->icon @endphp
            </div>
            <div class="content">
              <h3 class="title">{{ __($info->data_values->title) }}</h3>
              <p>{{ __($info->data_values->content) }}</p>
            </div>
          </div><!-- contact-item end -->
        </div>
        @endforeach
      </div>
      <div class="row justify-content-center mt-100">
        <div class="col-lg-12">
          <div class="contact-form-wrapper pl-5">
            <h3 class="title">{{ __($contact->data_values->heading) }}</h3>
            <p>{{ __($contact->data_values->subheading) }}</p>
            <form action="" class="contact-form verify-gcaptcha mt-50" id="contact_form_submit" method="post">
              @csrf
              <div class="row">
                <div class="form-group col-lg-6">
                  <input type="text" name="name" class="form-control" id="contact-name" placeholder="@lang('Name')">
                </div>
                <div class="form-group col-lg-6">
                  <input type="email" name="email" class="form-control" id="contact-email" placeholder="@lang('Email')">
                </div>
                <div class="form-group col-lg-12">
                  <input type="text" name="subject" class="form-control" id="contact-email" placeholder="@lang('Subject')">
                </div>
                <div class="form-group col-lg-12">
                  <textarea name="message" id="contact-message" class="form-control" placeholder="@lang('Write message')"></textarea>
                </div>
                <x-captcha></x-captcha>
                <div class="col-lg-12">
                  <button type="submit" class="btn btn--base w-100">@lang('send message')</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</section>
@endsection
