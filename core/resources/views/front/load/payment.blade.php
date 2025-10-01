@php
  
  if ($payment != 'offline') {
      $pay_data = $gateway->convertAutoData();
  }
  
@endphp


@if ($payment == 'paypal')
  <input aria-label="{{__('Method')}}" type="hidden" name="method" value="{{ $gateway->name }}">
@endif

@if ($payment == 'stripe')
  <input aria-label="{{__('Method')}}" type="hidden" name="method" value="{{ $gateway->name }}">

  
@endif

@if ($payment == 'payumoney')

  <input aria-label="{{__('Method')}}" type="hidden" name="method" value="{{ $gateway->name }}">

  <div class="row">

    <div class="col-lg-6 mb-4">
      <div class="form-element">
        <input aria-label="{{__('First Name')}}" class="input-field" name="payumoney_first_name" type="text" placeholder="{{ __('First Name') }}" />
      </div>
      @if ($errors->has('payumoney_first_name'))
        <p class="text-danger mb-0">{{ $errors->first('payumoney_first_name') }}</p>
      @endif
    </div>

    <div class="col-lg-6 mb-4">
      <div class="form-element">
        <input aria-label="{{__('Last Name')}}" class="input-field" name="payumoney_last_name" type="text" placeholder="{{ __('Last Name') }}" />
      </div>
      @if ($errors->has('payumoney_last_name'))
        <p class="text-danger mb-0">{{ $errors->first('payumoney_last_name') }}</p>
      @endif
    </div>

    <div class="col-lg-6 mb-4">
      <div class="form-element">
        <input aria-label="{{__('Phone')}}" class="input-field" name="payumoney_phone" type="text" placeholder="{{ __('Phone') }}" />
      </div>
      @if ($errors->has('payumoney_phone'))
        <p class="text-danger mb-0">{{ $errors->first('payumoney_phone') }}</p>
      @endif
    </div>

  </div>

@endif

@if ($payment == 'instamojo')
  <input aria-label="{{__('Method')}}" type="hidden" name="method" value="{{ $gateway->name }}">
@endif

@if ($payment == 'razorpay')

  <input aria-label="{{__('Method')}}" type="hidden" name="method" value="{{ $gateway->name }}">
  <div class="row">
    <div class="col-lg-6 mb-4">
      <div class="form-element">
        <input aria-label="{{__('Phone')}}" class="input-field card-elements" name="razorpay_phone" type="text"
          placeholder="{{ __('Phone') }}" />
      </div>
      @if ($errors->has('razorpay_phone'))
        <p class="text-danger mb-0">{{ $errors->first('razorpay_phone') }}</p>
      @endif
    </div>
    <div class="col-lg-6 mb-4">
      <div class="form-element">
        <input aria-label="{{__('Address')}}" class="input-field card-elements" name="razorpay_address" type="text"
          placeholder="{{ __('Address') }}" />
      </div>
      @if ($errors->has('razorpay_address'))
        <p class="text-danger mb-0">{{ $errors->first('razorpay_address') }}</p>
      @endif
    </div>
  </div>
@endif

@if ($payment == 'flutterwave')
  <input aria-label="{{__('Method')}}" type="hidden" name="method" value="{{ $gateway->name }}">
@endif


@if ($payment == 'paystack')
  <input aria-label="{{__('TXN ID')}}" type="hidden" name="txnid" id="ref_id" value="">
  <input aria-label="{{__('Sub')}}" type="hidden" name="sub" id="sub" value="0">
  <input aria-label="{{__('Method')}}" type="hidden" name="method" value="{{ $gateway->name }}">
@endif

@if ($payment == 'mollie')
  <input aria-label="{{__('Method')}}" type="hidden" name="method" value="{{ $gateway->name }}">
@endif

@if ($payment == 'mercadopago')
  <input aria-label="{{__('Method')}}" type="hidden" name="method" value="{{ $gateway->name }}">
@endif


@if ($payment == 'offline')

  <div>
    <p class="gateway-desc">{{ $gateway->short_description }}</p>
  </div>

  <div class="gateway-instruction">
    <p>{!! replaceBaseUrl($gateway->instructions) !!}</p>
  </div>

  @if ($gateway->is_receipt == 1)
    <div class="mb-4 form-element">
      <label for="" class="d-block mb-2">{{ __('Receipt') }} **</label>
      <input aria-label="{{__('Receipt')}}" type="file" name="receipt">
      <p class="mb-0 text-warning">** {{ __('Receipt image must be .jpg / .jpeg / .png') }}</p>
    </div>
  @endif

@endif
