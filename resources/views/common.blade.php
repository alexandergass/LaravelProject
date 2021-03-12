<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('pagetitle')</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">

    {!! Html::style('/css/styles.css') !!}
    @yield('css')

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
     <nav class="navbar navbar-default">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <div class="navbar-brand" href="/">@yield('pagename')</div>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li class="{{ Request::is('/home') ? "active" : "" }}"><a href="/home">Home</a></li>
            <li class="{{ Request::is('categories/*') || Request::is('categories') ? "active" : "" }}"><a href="/categories">Categories</a></li>
            <li class="{{ Request::is('items/*') || Request::is('items') ? "active" : "" }}"><a href="/items">Items</a></li>
            <li class="{{ Request::is('products/*') || Request::is('products') ? "active" : "" }}"><a href="/products">Product List</a></li>
            <li class="{{ Request::is('viewOrders/*') || Request::is('viewOrders') ? "active" : "" }}"><a href="/viewOrders">Orders</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            {{-- <li class="{{ Request::is('cart/*') || Request::is('cart') ? "active" : "" }}"><a href="#"><i class="fa fa-shopping-cart"></i></i> Cart</a></li> --}}
            <li>
            <a href="{{ route('products.shoppingCart') }}">
                <i class="fa fa-shopping-cart"></i> Cart
                <span class="badge">{{ Session::has('cart') ? Session::get('cart')->totalQty : '' }}</span>
              </a>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav> 
    <div class="row" id='main'>
      <div class="container">
          @include('partials._messages')
          @yield('content')
      </div> <!-- .container -->
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/bower_components/jquery/dist/jquery.min.js"></script> 

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    @yield('scripts')
  </body>
</html>