<!DOCTYPE html>
<html lang="en">
  @include('components.head')
  <body>
    <div class="wrapper">
      @include('components.sideBar')

      @yield('content')
      
    </div>
    @include('components.script')

  </body>
</html>
