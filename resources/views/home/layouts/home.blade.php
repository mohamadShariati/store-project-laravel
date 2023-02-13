
<!DOCTYPE html>
<html lang="en" class="no-js" >

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>shariati.ir - @yield('title')</title>

  <!-- Custom styles for this template-->
  <link href="{{asset('css/home.css')}}" rel="stylesheet">

</head>

<body>


    <div class="wrapper">

       @include('home.sections.header')

        @include('home.sections.mobile_off_canvas')

    @yield('content')


        @include('home.sections.footer')


      </div>


      <!--  core JavaScript-->
  <script src="{{asset('/js/home/jquery-1.12.4.min.js')}}"></script>
  <script src="{{asset('/js/home/plugins.js')}}"></script>
  <script src="{{asset('/js/home.js')}}"></script>

  @include('sweetalert::alert')
  @yield('script')

</body>

</html>
