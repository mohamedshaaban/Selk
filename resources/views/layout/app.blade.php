<!DOCTYPE html>
<html lang="{{ $lang}}">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <link rel="stylesheet" href="{{ asset('css/bootstrap.css')}}" />
  <link rel="stylesheet" href="{{ asset('css/slick.css')}}" />
  <link rel="stylesheet" href="{{ asset('css/jquery-ui.css')}}" />
  <link rel="stylesheet" href="{{ asset('css/intell.css')}}" />
  <link rel="stylesheet" href="{{ asset('css/dd.css')}}" />
  <link rel="stylesheet" href="{{ asset('css/flags.css')}}" />
  <link rel="stylesheet" href="{{ asset('css/style.css')}}" />
  <link rel="stylesheet" href="{{ asset('css/developer.css')}}" />

  <title>Selectis</title>

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
  <div id="app">
    <div class="loading-holder">
      <div id="loading"></div>
    </div>
  @include('includes.header')
  @yield('content')

  @include('includes.footer')
</div>
  <!-- modellll -->
  <script src="{{ asset('js/jquery.js')}}"></script>

  <script src="{{ asset('js/popper.js')}}"></script>
  <script src="{{ asset('js/jquery-ui.js')}}"></script>
  <script src="{{ asset('js/bootstrap.min.js')}}"></script>
  <script src="{{ asset('js/slick.js')}}"></script>
  <script src="{{ asset('js/dd.js')}}"></script>
  <script src="{{ asset('js/app.js')}}"></script>
  <script src="{{ asset('js/custom.js')}}"></script>

  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.7/js/intlTelInput.js"></script>
<script>
  $(".country-phone").intlTelInput({
  utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/js/utils.js"
});
</script>
  <script>
    window.auth_user  = {!! json_encode(Auth::check()); !!};
    window.currency_exchange_rate = '600';
    window.currency_name = 'SAS';
  </script>
  @include('includes.js') @yield('lower_javascript')


  <!--Start of Tawk.to Script-->
  <script type="text/javascript">
      var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
      (function(){
          var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
          s1.async=true;
          s1.src='https://embed.tawk.to/5c8f3764101df77a8be313b0/default';
          s1.charset='UTF-8';
          s1.setAttribute('crossorigin','*');
          s0.parentNode.insertBefore(s1,s0);
      })();
  </script>
  <!--End of Tawk.to Script-->
<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> -->

</body>

</html>
