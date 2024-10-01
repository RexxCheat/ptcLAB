@extends($activeTemplate.'layouts.master')
@section('content')
<section class="cmn-section">
    <div class="container">
        <div class="text-end mb-3">
            <a href="{{ route('user.ptc.ads') }}" class="btn btn--base btn-sm">@lang('My Advertisements')</a>
        </div>
        <div class="card">
            <div class="card-body">
                <form role="form" method="POST" action="{{ route("user.ptc.update",$ptc->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                       <div class="form-group col-md-6">
                            <label>@lang('Title of the Ad')</label>
                            <input type="text" name="title" class="form-control" value="{{ $ptc->title }}" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label>@lang('Duration')</label>
                            <div class="input-group">
                                <input type="number" name="duration" class="form-control" value="{{ $ptc->duration }}" required>
                                <div class="input-group-text">@lang('SECONDS')</div>
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="ads_type">@lang('Advertisement Type')</label>
                            <input type="hidden" name="ads_type" value="{{$ptc->ads_type}}">
                            <div class="pt-3">
                                @php echo $ptc->typeBadge @endphp
                            </div>
                        </div>
                        @if($ptc->ads_type == 1)

                        <div class="form-group col-md-8">
                            <label>@lang('Link') <span class="text-danger">*</span></label>
                            <input type="text" name="website_link" class="form-control" value="{{ $ptc->ads_body }}" placeholder="@lang('http://example.com')">
                        </div>
                        @elseif($ptc->ads_type == 2)

                        <div class="form-group col-md-4 ">
                            <label>@lang('Banner')</label>
                            <input type="file" class="form-control"  name="banner_image">
                        </div>
                            <div class="form-group col-md-4 ">
                            <label>@lang('Current Banner') <span class="text-danger">*</span></label>
                            <img src="{{ getImage(getFilePath('ptc').'/'.$ptc->ads_body) }}" class="w-100">
                        </div>

                        @elseif($ptc->ads_type == 3)

                        <div class="form-group col-md-8">
                            <label>@lang('Script') <span class="text-danger">*</span></label>
                            <textarea  name="script" class="form-control">{{ $ptc->ads_body }}</textarea>
                        </div>

                        @else
                            <div class="form-group col-md-8">
                                <label>@lang('Youtube Embaded Link') <span class="text-danger">*</span></label>
                                <input type="text" name="youtube" class="form-control" value="{{ $ptc->ads_body }}">
                            </div>
                        @endif
                    </div>
                    <div class="form-group col-md-12">
                        <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
