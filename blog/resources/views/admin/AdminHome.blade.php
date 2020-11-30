<!DOCTYPE html>
<html lang="en">
<head>
  <title>{{ $title }}</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">WebSiteName</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="{{ route('AdminHome') }}">Home</a></li>
      @foreach($leagues as $league)
        <li><a href="{{ route('AdminShowNewsWithLeague', ['id'=>$league->id]) }}">{{ $league->leagues }}</a></li>
      @endforeach
      <li><a href="{{ route('AddLeague') }}">სიახლის დამატება</a></li>
      @if ($amount == 0)
      <li><a href="{{ route('AdminShow') }}">პოსტის დადასტურება <i class="fas fa-bell">{{ $amount }}</i></a></li>
      @else
      <li><a href="{{ route('AdminShow') }}">პოსტის დადასტურება <i class="fas fa-bell" style="color:red">{{ $amount }}</i></a></li>
      @endif
      <li><a href="{{ route('AdminProfile') }}">პირადი პროფილი</a></li>
      <li><a href="{{ route('logout') }}">გასვლა</a></li>
    </ul>
  </div>
</nav>
  
<div class="container">
  <!-- <h3>Inverted Navbar</h3>
  <p>An inverted navbar is black instead of gray.</p> -->
</div>
@include('messages.alerts')
@yield("content")
</body>
</html>
