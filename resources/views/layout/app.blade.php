<!DOCTYPE html>
<html lang="en">
  @include('components.head')
  <head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
  </head>
  <body>
    <div class="wrapper">
      @include('components.sideBar')

      @yield('content')
      
    </div>
    @include('components.script')

  </body>
</html>
