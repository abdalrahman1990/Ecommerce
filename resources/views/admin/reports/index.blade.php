@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col s12">
            <div class="card-panel">
                <h4 class="center">Generate Reports</h4>
                <br>
                <h5>Choose a report type:</h5>
                <form action="{{route('admin.reports.index')}}" id="report-options">
                    <div class="input-field">
                        <select name="type" id="type">
                            <option value="orders" {{(request()->type == "orders") ? 'selected' : '' }}>Orders Report</option>
                            <option value="customers" {{(request()->type == "customers") ? 'selected' : ''}}>Customers Report</option>
                            <option value="products" {{(request()->type == "products") ? 'selected' : ''}}>Products Report</option>
                            <option value="addresses" {{(request()->type == "addresses") ? 'selected' : ''}}>Addresses Report</option>
                        </select>
                    </div>
                </form>
                <br>
                <h5>Choose filters:</h5>
                <form action="{{route('admin.reports.index')}}">
                    <div class="row">
                        <div class="input-field col s12 m6 l4">
                            <input type="text" class="datepicker" id="date-from" name="date_from" value="{{request('date_from')}}">
                            <label for="date-from">Date From</label>
                            @if($errors->has('date_from'))
                                <span class="helper-text red-text">
                                    {{$errors->first('date_from')}}
                                </span>
                            @endif
                        </div>
                        <div class="input-field col s12 m6 l4">
                            <input type="text" class="datepicker" id="date-to" name="date_to" value="{{request('date_to')}}">
                            <label for="date-to">Date To</label>
                            @if($errors->has('date_to'))
                                <span class="helper-text red-text">
                                    {{$errors->first('date_to')}}
                                </span>
                            @endif
                        </div>
                        <input type="hidden" name="type" value="{{request()->type}}">
                        <br>
                        <button type="submit" class="btn col s10 offset-s1 m4 offset-m4 l3 waves-effect waves-light">Filter</button>
                    </div>
                </form>
                <br>
                @if(request()->type == "customers")
                    @component('admin.reports.components.customers',[
                        'users' => $items
                    ])
                    @endcomponent
                @elseif(request()->type == "products")
                    @component('admin.reports.components.products',[
                        'products' => $items
                    ])
                    @endcomponent
                @elseif(request()->type == "addresses")
                    @component('admin.reports.components.addresses',[
                        'addresses' => $items
                    ])
                    @endcomponent
                @else
                    @component('admin.reports.components.orders',[
                        'orders' => $items
                    ])
                    @endcomponent
                @endif
                <br>
                <div class="center-align">
                <h5 class="center">Download Report</h5>
                    <br>
                    <div class="row">
                        <div class="col s6 m4 row">
                            <a href="#" onclick="this.preventDefault;document.querySelector('#pdf-form').submit()" class="btn waves-effect waves-light col s12">
                                <i class="material-icons left">file_download</i>
                                PDF
                            </a>
                        </div>
                        <div class="col s6 m4 row">
                            <a href="#" onclick="this.preventDefault;document.querySelector('#excel-form').submit()" class="btn waves-effect waves-light col s12">
                                <i class="material-icons left">file_download</i>
                                Excel
                            </a>
                        </div>
                        <div class="col s6 offset-s3 m4 row">
                            <a href="#" onclick="this.preventDefault;document.querySelector('#csv-form').submit()" class="btn waves-effect waves-light col s12">
                                <i class="material-icons left">file_download</i>
                                CSV
                            </a>
                        </div>
                    </div>
                    @component('admin.reports.components.report-form',[
                        'route' => 'pdf',
                        'form'  => 'pdf-form'
                    ])
                    @endcomponent
                    @component('admin.reports.components.report-form',[
                        'route' => 'excel',
                        'form'  => 'excel-form'
                    ])
                    @endcomponent
                    @component('admin.reports.components.report-form',[
                        'route' => 'csv',
                        'form'  => 'csv-form'
                    ])
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('#type').on('property change',function(){
                $('#report-options').submit();
            })
        });
    </script>
@endsection