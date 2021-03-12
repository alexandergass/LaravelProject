@extends('common') 

@section('pagetitle')
Laravel Shopping Cart
@endsection

@section('pagename')
Laravel Project
@endsection

@section('scripts')
{!! Html::script('/bower_components/parsleyjs/dist/parsley.min.js') !!}
@endsection

@section('css')
{!! Html::style('/css/parsley.css') !!}
@endsection

@section('content')
    {{-- @if(Session::has('cart'))
        @foreach(Session::get('cart') as $item)
            {{$item['qty']}}
            {{$item['price']}}
            {{$item['item']}}
        @endforeach
    @endif --}}
    
    @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
    @endif

    @if(Session::has('cart'))

        <div class="row">
            <div class="col-md-6 col-md-offset-3">
            <table class="table">
                <tr>
                    <th>Quantity</th>
                    <th>Item</th>
                    <th>Price</th>
                    <th></th>
                    <th></th>
                </tr>
                    @foreach($products as $product)
                    
                    <tr>
                    
                    {{-- <td ><div style='float:left;'>{{ Session::has('cart') ? Session::get('cart')->totalQty : '' }}</div></td> --}}

                    {{-- @php dd( Session::get('quantity') ) @endphp --}}

                    {{-- @php dd(session()->all()) @endphp --}}

                    {{-- {{ $product['qty'] }} --}}

                    {{-- {{ $product['item']['id'] }} --}}

                    {{-- {{ dd(shopping_cart::find($id)) }} --}}

                    {{-- {{ $value = Session::get('quantity') }} --}}
                    {{-- {{ $value = session('key') }} --}}
                    {{-- {{ $data = Session::all() }} --}}
                    {{-- @php dd( Session::get('cart') ) @endphp --}}
                    {{-- @php dd( $product['item']['id'] ) @endphp --}}
                    {{-- @php dd( $product ) @endphp --}}
                    {{-- @php dd(Session::get('id')) @endphp --}}


                    <td><div style='float:left;'>{{ $product['qty'] }}</div></td>

                    {{-- <td><div style='float:left;'> {{ Session::get('quantity') }} </div></td> --}}
                        
                    <td><div style='float:left; margin-left: 5px; min-width: 80px;'>{{ $product['item']['title'] }}</div></td>
                    
                    <td><div class="label label-success" style="width: 40px; height: 20px; float: left; margin-left: 5px; line-height: 1.5;">{{ $product['price'] }}</div></td>

                    {{-- <a href="{{ route('products.updateCart', ['id' => $product['item']['id']]) }}" class="btn btn-primary btn-xs" >Update</a></button> --}}
                    <td>
                        <div>
                            {!! Form::model($product, ['route' => ['products.updateCart'], 'method'=>'PUT', 'data-parsley-validate' => '']) !!}
                            
                                {{ Form::text('quantity', null, ['class'=>'', 'style'=>'color: black; width: 30px; height: 20px;', 
                                                            'data-parsley-required'=>'']) }}
                            
                                {{ Form::hidden('cart_id', $product['item']['id'] ) }}
                            
                                {{ Form::submit('Update', ['class'=>'btn btn-primary btn-xs', 'style'=>'']) }}
                            
                            {!! Form::close() !!}
                        </div>
                    </td>

                    <td>
                        <div style='float:left;'>
                            <a href="{{ route('products.reduceByOne', ['id' => $product['item']['id']]) }}" class="btn btn-danger btn-xs" style="margin-left: 5px;" >Remove 1</a></button>
                        </div>
                    </td>

                    <br />
                    <br />
                </tr>
            @endforeach
            </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <strong>Total: {{ $totalPrice }}</strong>
                <hr>
            </div>
        </div>
        {{-- <hr> --}}
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                {{-- <button type="button" class="btn btn-success">Checkout</button> --}}
                {!! Form::open(['route' => ['products.check_order'], 'data-parsley-validate' => '', 'files' => true]) !!}
                <h1>Customer Information</h1>
                <hr/>

                {{ Form::label('firstName', 'First Name:') }}
                {{ Form::text('firstName', null, ['class'=>'form-control', 'style'=>'width: 200px; margin-right: 10px;', 
                                                'data-parsley-required'=>'', 
                                                'data-parsley-maxlength'=>'255',
                                                // 'data-parsley-errors-container'=>"#element"
                                                ]) }}

                {{ Form::label('lastName', 'Last Name:') }}
                {{ Form::text('lastName', null, ['class'=>'form-control', 'style'=>'width: 200px;', 
                                                'data-parsley-required'=>'', 
                                                'data-parsley-maxlength'=>'255']) }}

                {{ Form::label('phoneNumber', 'Phone Number:') }}
                {{ Form::text('phoneNumber', null, ['class'=>'form-control', 'style'=>'width: 200px;', 
                                                'data-parsley-required'=>'required', 
                                                // 'data-parsley-required-message'=>'oops',
                                                'data-parsley-maxlength'=>'255']) }}

                {{ Form::label('emailAddress', 'Email:') }}
                {{ Form::text('emailAddress', null, ['class'=>'form-control', 'style'=>'width: 200px;', 
                                              'data-parsley-required'=>'',
                                            //   'placeholder'=>'_ _ _ - _ _ _ _',
                                              'data-parsley-maxlength'=>'255']) }}

                {{-- {{ Form::hidden('cart_id', $product['item']['id'] ) }} --}}
                
				{{ Form::submit('Submit Order', ['class'=>'btn btn-success', 'style'=>'margin-top:10px']) }}
                {!! Form::close() !!}
            </div>
        </div>

        <script>
            window.ParsleyConfig = {
                errorsWrapper: '<div></div>',
                errorTemplate: '<div class="alert alert-danger parsley" style="width:200px;" role="alert"></div>',
                errorClass: 'has-error',
                successClass: 'has-success'
            };
        </script>

    @else
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <h2>No Items in Cart!
                </h2>
            </div>
        </div>

    @endif
@endsection