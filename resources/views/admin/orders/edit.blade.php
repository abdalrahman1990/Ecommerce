@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <div class="card-panel">
                    <h4 class="center grey-text text-darken-2">Update Order</h4>
                    <form action="{{route('admin.orders.update',$order->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="input-field col s12 login-field">
                                <input type="number" name="total" id="total" value="{{old('total') ? : $order->total}}">
                                <label for="total">Total Amount</label>
                                @if($errors->has('total'))
                                    <span class="helper-text red-text">
                                        {{$errors->first('total')}}
                                    </span>
                                @endif
                            </div>
                            <div class="input-field col s12 login-field">
                                <select name="address" id="address">
                                    @foreach($addresses as $address)
                                        <option value="{{$address->id}}" {{($address->id === $order->address_id) ? 'selected' : ''}}>{{$address->address_1}}</option>
                                    @endforeach
                                </select>
                                <label>Address Line</label>
                                @if($errors->has('address'))
                                    <span class="helper-text red-text">
                                        {{$errors->first('address')}}
                                    </span>
                                @else
                                    <span class="helper-text"><span class="red-text">Note!</span> You can create a new address in the address tab from side menu.</span>
                                @endif
                            </div>
                            <div class="input-field col s12 login-field">
                                <select name="paid" id="paid">
                                    <option value="0" >Failed</option>
                                    <option value="1" {{($order->paid ? 'selected' : '')}}>Paid</option>
                                </select>
                                <label>Status</label>
                                @if($errors->has('paid'))
                                    <span class="helper-text red-text">
                                        {{$errors->first('paid')}}
                                    </span>
                                @endif
                            </div>
                            <div class="row"></div>
                            <button type="submit" class="btn col s8 offset-s2 m4 offset-m4 bg2">Update</button>
                        </div>
                    </form>
                    <br>
                    <a href="{{route('admin.orders.show',$order->id)}}" class="btn-flat waves-effect blue-text">Go Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection