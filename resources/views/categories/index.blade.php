@extends('common') 

@section('pagetitle')
Categories
@endsection

@section('pagename')
Laravel Project
@endsection

@section('content')
	
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h1>Category List</h1>
		</div>
		<div class="col-md-2">
			<a href="{{ route('categories.create') }}" class="btn btn-lg btn-block btn-primary btn-h1-spacing">Add Category</a>
		</div>
		<div class="col-md-12">
			<hr />
		</div>
	</div>

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<table class="table">
				<thead>
					<th>#</th>
					<th>Name</th>
					<th>Created At</th>
					<th>Last Modified</th>
					<th></th>
				</thead>
				<tbody>
					@foreach ($categories as $category)
						<tr>
							<th>{{ $category->id }}</th>
							<td>{{ $category->name }}</td>
							<td style='width:100px;'>{{ date('M j, Y', strtotime($category->created_at)) }}</td>
							<td style='width:100px;'>{{ date('M j, Y', strtotime($category->updated_at)) }}</td>
							<td style='width:150px;'><div style='float:left; margin-right:5px;'><a href="{{ route('categories.edit', $category->id) }}" class="btn btn-success btn-sm">Edit</a></div><div style='float:left;'></div>
							{{-- <a href="delete/{{$category->id}}" id="delete_button" class="btn btn-danger btn-sm">Delete</a> --}}
							{{-- <style>
								#delete_button {
									display: none;
								}
							</style> --}}
							<?php
								// $count = \DB::table('items')->count();
								// $result = mysqli_query("SELECT category_id FROM items");
								$db_host = "localhost";
								$db_user = "homestead";
								$db_password = "secret";
								$conn = mysqli_connect($db_host, $db_user, $db_password, "homestead");
								$sql = "SELECT * FROM items
										WHERE category_id = $category->id";
								$result = $conn-> query($sql);
								
								if (mysqli_num_rows($result) > 0) {
									while($row = mysqli_fetch_assoc($result)) {
										// echo "<br /><br />";
										// echo "this category id: ". $category->id;
										// echo "<br />";
										// echo("category_id :". $row["category_id"]);
										// echo "<br />num rows: ". mysqli_num_rows($result);
										// echo "<br /><br />";
										if ($category->id == $row["category_id"]){
											echo '<br /><br />Contains item(s)';
											break;
										}
										// else {
										// 	echo '<a href="delete/'.$category->id.'" id="delete_button" class="btn btn-danger btn-sm">Delete</a>';
										// 	break;
										// }
									}
								}
								else {
									echo '<a href="delete/'.$category->id.'" id="delete_button" class="btn btn-danger btn-sm">Delete</a>';		
								}
							?>
							
							{{-- @if($x == 1)
								<style>
									#delete_button {
										display: none;
									}
								</style>
							@endif --}}
								{{-- {!! Form::open(['route'=>['categories.destroy', $category->id], 'method'=>'delete']) !!}
								{!! Form::submit('Delete', ['class'=>'btn btn-sm btn-danger']) !!}
								{!! Form::close() !!} --}}
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div> <!-- end of .col-md-8 -->
	</div>

@endsection

{{-- @section('jsScript')

    <!-- jQuery 3 -->
	<script src="{{asset('admin/bower_components/jquery/dist/jquery.min.js')}}"></script>
	
	<script>
			$("delete_button").hide();
	</script>
@endsection --}}
