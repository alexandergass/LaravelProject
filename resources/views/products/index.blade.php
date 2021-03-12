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
			<h1>Product List</h1>
		</div>
		{{-- <div class="col-md-2">
			<a href="{{ route('categories.create') }}" class="btn btn-lg btn-block btn-primary btn-h1-spacing">Add Category</a>
		</div> --}}
		<div class="col-md-12">
			<hr />
		</div>
	</div>

	<div class="row">
		<div class="col-md-2 col-md-offset-2">
			<table class="table">
				<thead>
					<th>Category</th>
				</thead>
				<tbody>

                @foreach ($categories as $category)
                    <tr>
                        <td><a href=" {{ route('index2', $category->id) }}">{{ $category->name }}</a></td>
                    </tr>

                @endforeach
                
				</tbody>
			</table>
        </div>
        
        <div class="col-md-2">
			<table class="table">
				<thead>
					<th>Image</th>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Stock&nbsp</th>
                    <th></th>

                    
				</thead>
				<tbody>

                    @foreach ($items as $items)
                    
                        <?php
                            $db_host = "localhost";
                            $db_user = "homestead";
                            $db_password = "secret";
                            $conn = mysqli_connect($db_host, $db_user, $db_password, "homestead");
                            // $sql = "SELECT * FROM items
                            //         WHERE category_id = $category->id";
                            // $result = $conn-> query($sql);
                            
                            // if (mysqli_num_rows($result) > 0) {
                            //     while($row = mysqli_fetch_assoc($result)) {
                            //         if ($category->id == $row["category_id"]){
                            //             // echo "<td> $item->title </td>";
                            //             echo "<tr><td>$category->id</td>";
                            //         }
                            //     }
                            // }
                            // else {
                            //     echo "<tr><td>$category->id is Empty</td></tr>";		
                            // }

                            $sql = "SELECT * FROM categories
                                    WHERE id = $items->category_id";
                            $result = $conn-> query($sql);

                            if (mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    if ($items->category_id == $row["id"]){
                                        ?>
                                        <tr><td><a href="{{ route('products.show', $items->id) }}" class=""><img src="{{ Storage::url('images/items/'.'tn_'.$items->picture) }}" ></a></td>
                                        <td><a href="{{ route('products.show', $items->id) }}" class="">{{ $items->title }}</a></td>
                                        <?php
                                        echo "<td> $$items->price </td>";
                                        if ($items->quantity > 0) {
                                            echo "<td> $items->quantity </td>";
                                        }
                                        else {
                                            echo "<td><b>Out of stock</b></td>";
                                        }
                                        // echo "$items->id";
                                        ?>
                                        <td><a href="{{ route('products.addToCart', $items->id) }}" id="addToCartBtn" class="btn btn-success btn-sm">Add To Cart</a><td></tr>
                                        <?php    		
                                    }
                                }
                            }
                        ?>
                    
                    @endforeach
                
				</tbody>
			</table>
        </div>
        
    </div>
@endsection