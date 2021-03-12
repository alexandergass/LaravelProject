@extends('common') 

@section('pagetitle')
Product List
@endsection

@section('pagename')
Laravel Project
@endsection

@section('content')
	
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h1>Details</h1>
		</div>

		<div class="col-md-12">
			<hr />
		</div>
	</div>

	<div class="row">
        <div class="col-md-2 col-md-offset-2">
			<table class="table">
				<tbody>
                    
                    <b>{{ $item->title }}</b> <br />
                    <img src="{{ Storage::url('images/items/'.$item->picture) }}" style='max-width:500px;' ><br />
                    <b>Product ID:</b> {{ $item->id }} <br />
                    <b>Description</b> {!! $item->description !!}
                    <b>Price:</b> ${{ $item->price }} <br />
                    <b>Quantity:</b> {{ $item->quantity }} <br />
                    <b>SKU:</b> {{ $item->sku }} <br />

                
				</tbody>
			</table>
        </div>
        
    </div>
@endsection