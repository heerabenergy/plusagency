@extends("front.$version.layout")

@section('pagename')
 - {{__('Service')}} - {{convertUtf8($service->title)}}
@endsection

@section('meta-keywords', "$service->meta_keywords")
@section('meta-description', "$service->meta_description")

@section('breadcrumb-title', convertUtf8($bs->service_details_title))
@section('breadcrumb-subtitle', convertUtf8($service->title))
@section('breadcrumb-link', __('Service Form'))

@section('content')


  <!--   quote area start   -->
  <div class="quote-area pt-115 pb-115">
    <div class="container">
      <div class="row">

        <div class="col-lg-12">
          <form action="{{route('front.sendservice', $service->slug)}}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="row">
                @include('front.partials.form-input', ['inputs' => $inputs])
            </div>

            @if ($bs->is_recaptcha == 1)
              <div class="row mb-4">
                <div class="col-lg-12">
                  {!! NoCaptcha::renderJs() !!}
                  {!! NoCaptcha::display() !!}
                  @if ($errors->has('g-recaptcha-response'))
                    @php
                        $errmsg = $errors->first('g-recaptcha-response');
                    @endphp
                    <p class="text-danger mb-0">{{__("$errmsg")}}</p>
                  @endif
                </div>
              </div>
            @endif

            <div class="row">
              <div class="col-lg-12 text-center">
                <button aria-label="{{__('Submit')}}" type="submit" name="button">{{__('Submit')}}</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!--   quote area end   -->
@endsection
