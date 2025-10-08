@extends("front.$version.layout")

@section('pagename')
 -
 {{__('Login')}}
@endsection


@section('meta-keywords', "$be->login_meta_keywords")
@section('meta-description', "$be->login_meta_description")

@section('breadcrumb-subtitle', __('Sign In'))
@section('breadcrumb-link', __('Sign In'))


@section('content')


<!--   hero area start    -->
<div class="login-area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                @if($bex->product_guest_checkout == 1 && !empty(request()->input('redirected')) && request()->input('redirected') == 'checkout' && !containsDigitalItemsInCart())
                    <a aria-label="{{__('Checkout as Guest')}}" href="{{route('front.checkout.index', ['type' => 'guest'])}}" class="btn btn-block btn-primary mb-4 base-bg py-3 border-0">{{__('Checkout as Guest')}}</a>

                    <div class="mt-4 mb-3 text-center">
                        <h3 class="mb-0"><strong>{{__('OR')}},</strong></h3>
                    </div>
                @elseif($bex->package_guest_checkout == 1 && !empty(request()->input('redirected')) && request()->input('redirected') == 'package-checkout')
                    <a aria-label="{{__('Checkout as Guest')}}" href="{{session()->get('link') . '?type=guest'}}" class="btn btn-block btn-primary mb-4 base-bg py-3 border-0">{{__('Checkout as Guest')}}</a>

                    <div class="mt-4 mb-3 text-center">
                        <h3 class="mb-0"><strong>{{__('OR')}},</strong></h3>
                    </div>
                @endif
                <div class="login-content">
                    <div class="login-title">
                        <h3 class="title">{{__('Login')}}</h3>
                    </div>
                    @if ($bex->is_facebook_login == 1 || $bex->is_google_login == 1)
                    <div class="social-logins mt-4 mb-4">
                        <div class="btn-group btn-group-toggle d-flex">
                            @if ($bex->is_facebook_login == 1)
                                <a aria-label="{{__('Login via Facebook')}}" class="btn btn-primary text-white py-2 facebook-login-btn" href="{{route('front.facebook.login')}}"><i class="fab fa-facebook-f mr-2"></i> {{__('Login via Facebook')}}</a>
                            @endif
                            @if ($bex->is_google_login == 1)
                                <a aria-label="{{__('Login via Google')}}" class="btn btn-danger text-white py-2 google-login-btn" href="{{route('front.google.login')}}"><i class="fab fa-google mr-2"></i> {{__('Login via Google')}}</a>
                            @endif
                        </div>
                    </div>
                    @endif
                    <form id="loginForm" action="{{route('user.login')}}" method="POST">
                        @csrf
                        <div class="input-box">
                            <span>{{__('Email')}} *</span>
                            <input aria-label="{{__('Email')}}" type="email" name="email" value="{{Request::old('email')}}">
                            @if(Session::has('err'))
                                <p class="text-danger mb-2 mt-2">{{Session::get('err')}}</p>
                            @endif
                            @error('email')
                            <p class="text-danger mb-2 mt-2">{{ convertUtf8($message) }}</p>
                            @enderror
                        </div>
                        <div class="input-box mb-4">
                            <span>{{__('Password')}} *</span>
                            <input aria-label="{{__('Password')}}" type="password" name="password" value="{{Request::old('password')}}">
                            @error('password')
                            <p class="text-danger mb-2 mt-2">{{ convertUtf8($message) }}</p>
                            @enderror
                        </div>

                        @if ($bs->is_recaptcha == 1)
                        <div class="d-block mb-4">
                            {!! NoCaptcha::renderJs() !!}
                            {!! NoCaptcha::display() !!}
                            @if ($errors->has('g-recaptcha-response'))
                            @php
                                $errmsg = $errors->first('g-recaptcha-response');
                            @endphp
                            <p class="text-danger mb-0 mt-2">{{__("$errmsg")}}</p>
                            @endif
                        </div>
                    @endif

                        <div class="input-btn">
                            <button aria-label="{{__('LOG IN')}}" type="submit">{{__('LOG IN')}}</button><br>
                            <p class="float-lg-right float-left">{{__("Don't have an account ?")}} <a aria-label="{{__('Click Here')}}" href="{{route('user-register')}}">{{__('Click Here')}}</a> {{__('to create one.')}}</p>
                            <a aria-label="{{__('Lost your password?')}}" class="mr-3" href="{{route('user-forgot')}}">{{__('Lost your password?')}}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--   hero area end    -->
@endsection
