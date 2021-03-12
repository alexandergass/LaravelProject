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
			<h1>Completed Orders</h1>
		</div>

		<div class="col-md-12">
			<hr />
		</div>
	</div>

	<div class="row">
		<div class="col-md-2 col-md-offset-2">

			<table class="table">
				<thead>
                    <th>Order ID</th>
				</thead>
				<tbody>

                    @foreach ($orders as $item)
                    
                        <tr>
                            <td><a href="{{ route('products.customerReceipt', $item->id) }}"> {{ $item['order_id'] }}</td>
                        </tr>

                    @endforeach
                
				</tbody>
            </table>
        </div>
    </div>

@endsection