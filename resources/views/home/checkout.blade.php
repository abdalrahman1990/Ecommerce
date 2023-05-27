@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col s12 m12 l8 xl8">
            <div class="card-panel">
                <br>
                <h5 class="center grey-text text-darken-1" >Shipping Address</h5>
                <br>
                <form action="{{route('checkout')}}" method="post" id="checkout-form">
                    <div class="row">
                        @csrf
                        <div class="input-field col s12 login-field">
                            <textarea name="address_1" id="address_1" class="materialize-textarea">{{old('address_1')}}</textarea>
                            <label for="address_1">Address line 1</label>
                            @if($errors->has('address_1'))
                                <span class="helper-text red-text">
                                    {{$errors->first('address_1')}}
                                </span>
                            @endif
                        </div>
                        <div class="input-field col s12 login-field">
                            <textarea name="address_2" id="address_2" class="materialize-textarea">{{old('address_2')}}</textarea>
                            <label for="address_2">Address Line 2</label>
                            @if($errors->has('address_2'))
                                <span class="helper-text red-text">
                                    {{$errors->first('address_2')}}
                                </span>
                            @endif
                        </div>
                        <div class="input-field col s12 m6 login-field">
                            <select name="city" id="city">
                                <option value="">Select a city</option>
                                @foreach($cities as $city)
                                    <option value="{{$city->id}}" {{(old('city') == $city->id) ? 'selected' : '' }}>{{$city->name}}</option>
                                @endforeach
                            </select>
                            <label for="city">City</label>
                            @if($errors->has('city'))
                                <span class="helper-text red-text">
                                    {{$errors->first('city')}}
                                </span>
                            @endif
                        </div>
                        <div class="input-field col s12 m6 login-field">
                            <input type="text" name="postal_code" id="postal_code" value="{{old('postal_code')}}">
                            <label for="postal_code">Postal code</label>
                            @if($errors->has('postal_code'))
                                <span class="helper-text red-text">
                                    {{$errors->first('postal_code')}}
                                </span>
                            @endif
                        </div>
                        <div class="input-field col s12">
                            <div id="dropin-container"></div>
                            <br>
                            <div class="row">
                                <button id="check-out-btn" class="btn center col s8 offset-s2 m4 offset-m4 bg2 waves-effect waves-light">Checkout</button>
                            </div>
                        </div>
                        <input type="hidden" name="nonce" id="nonce">
                    </div>
                </form>
            </div>
        </div>
        <div class="col s12 m12 l4 xl4">
            <div class="card-panel">
                @component('components.cart-summary')
                @endcomponent
                <br>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="https://js.braintreegateway.com/web/dropin/1.11.0/js/dropin.min.js"></script>

    <script>
        var button = document.querySelector('#check-out-btn');
        // Get the braintree token from server
        // and init the dropin-ui 
        $(document).ready(function(){
            $.ajax({
                url: '/braintree/token',
                type:'GET',
                dataType:'json',
                success: function(data){
                    braintree.dropin.create({
                    authorization: data.token,
                    container: '#dropin-container'
                    }, function (createErr, instance) {
                    button.addEventListener('click', function (e) {
                        e.preventDefault();
                        instance.requestPaymentMethod(function (requestPaymentMethodErr, payload) {
                        // Submit payload.nonce to your server
                        $('#nonce').val(payload.nonce);
                        document.querySelector('#checkout-form').submit();
                        });
                    });
                    });
                }
            });
        });
    </script>
@endsection