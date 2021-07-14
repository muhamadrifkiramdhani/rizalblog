<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scle=1.0">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/logreg.css')}}">
    <title>Weblog - Login</title>
</head>
<body>
<div class="container">
<form method="post">
    @csrf
    <div class="mb-3">
        <label for="frm-title" class="form-label">Name</label>
        <input type="text" class="form-control" id="frm-name" name="frm-name" placeholder="Article Title">
    </div>

    <div class="mb-3">
        <label for="frm-title" class="form-label">Email</label>
        <input type="text" class="form-control" id="frm-email" name="frm-email" placeholder="Article Author"></input>
    </div>
    
    <div>
    <a href="{{url('/register')}}">register here</a>
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-primary form-control">Login</button>
    </div>
 </form>`
</div>

</body>
</html>