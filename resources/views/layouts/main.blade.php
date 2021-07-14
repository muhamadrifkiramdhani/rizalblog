<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scle=1.0">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>Weblog - @yield('title', 'Main')</title>
</head>
<body>
<?php
session_start();
if(session()->has('author')){
  $author = session()->get('author');
}
?>
<nav class="navbar navbar-expand-lg navbar-light bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Weblog</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
           <a class="nav-link" aria-current="page" href="{{url('/')}}">Home</a>
        </li>

        <?php
        if(session()->has('author')){
          echo "<li class='nav-item'>";
          echo "<a class='nav-link' href='/articles/new'>New Article</a>";
          echo "</li>";
        } else{
        }
      ?>
      </ul>
      <div class='d-flex'>
      
      
      <?php
      if(session()->has('author')){
        echo "<a class='btn btn-primary' type='button' href='$author'>$author</a>";
        echo "<a class='btn btn-primary' type='button' href='/logout'>Logout</a>";
      } else{
        
        echo "<a class='btn btn-primary' type='button' href='/login'>Login</a>";
        
      }
      ?>
      </div>
    </div>
  </div>
</nav>

<div class="container">
@yield('content')
</div>

@section('page-script')
    <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
@show
</body>
</html>