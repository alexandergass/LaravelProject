@extends('common') 

@section('pagetitle')
Product List
@endsection

@section('pagename')
Laravel Project
@endsection

@section('content')

    @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
    @endif
	
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h1>Your Receipt</h1>
		</div>

		<div class="col-md-12">
			<hr />
		</div>
	</div>

	<div class="row">
		<div class="col-md-2 col-md-offset-2">

			<table class="table">
				<thead>
                    {{-- <th>Image</th> --}}
                    <th>Quantity&nbsp</th>
                    <th>Item</th>
                    <th>Price</th>
                    <th></th>
                    
				</thead>
				<tbody>

                    @foreach ($items as $item)
                    
                        <tr>
                            <td><div style='float:left;'>{{ $item['qty'] }}</div></td>

                            {{-- <td><div style='float:left;'> {{ Session::get('quantity') }} </div></td> --}}
                                
                            <td><div style='float:left; margin-left: 5px; min-width: 80px;'>{{ $item['item']['title'] }}</div></td>
                            
                            <td><div class="label label-success" style="width: 40px; height: 20px; float: left; margin-left: 5px; line-height: 1.5;">{{ $item['price'] }}</div></td>
                            {{-- <td>{{ $items->title }}</td>
                            <td>{{ $items->price }}</td>
                            <td>{{ $items_sold->quantity }}</td> --}}

                            {{-- <td>{{ $items->quantity }}</td> --}}

                    @endforeach

                    {{-- @foreach ($items_sold as $items)
                        <td>{{ $items_sold->quantity }}</td>
                    @endforeach --}}
                
				</tbody>
            </table>
            
            <strong>Total: {{ $totalPrice }}</strong>
            {{-- <hr> --}}
            <strong>Customer Info</strong>
            <div>{{ $order_info->firstName }}</div>
            <div>{{ $order_info->lastName }}</div>
            <div>{{ $order_info->emailAddress }}</div>
            <div>{{ $order_info->phoneNumber }}</div>

        </div>
        
    </div>

@endsection