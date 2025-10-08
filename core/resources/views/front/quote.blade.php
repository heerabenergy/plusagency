@extends("front.$version.layout")

@section('pagename')
 - {{__('Request A Quote')}}
@endsection

@section('meta-keywords', "$be->quote_meta_keywords")
@section('meta-description', "$be->quote_meta_description")

@section('breadcrumb-title', $bs->quote_title)
@section('breadcrumb-subtitle', $bs->quote_subtitle)
@section('breadcrumb-link', __('Quote Page'))

@section('content')


  <!--   quote area start   -->
  <div class="quote-area pt-115 pb-115">
    <div class="container">
      <div class="row">

        <div class="col-lg-12">
          <form action="{{route('front.sendquote')}}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-element mb-4">
                        <label for="name">{{__('Name')}} <span>**</span></label>
                        <input name="name" id="name" type="text" value="{{old("name")}}" placeholder="{{__('Enter Name')}}">

                        @if ($errors->has("name"))
                        <p class="text-danger mb-0">{{$errors->first("name")}}</p>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-element mb-4">
                        <label for="email">{{__('Email')}} <span>**</span></label>
                        <input name="email" id="email" type="text" value="{{old("email")}}" placeholder="{{__('Enter Email Address')}}">

                        @if ($errors->has("email"))
                        <p class="text-danger mb-0">{{$errors->first("email")}}</p>
                        @endif
                    </div>
                </div>

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
