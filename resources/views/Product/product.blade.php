<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
    <a href="{{route('product.index')}}">Products</a>
    <h1>Name : {{$product[0]->name}}</h1>
    <h1>Price : {{$product[0]->price}}</h1>
@foreach($images as $img)
<div class="card" style="width: 18rem;">
  <img src="{{asset('public/productimages/'.$img->name)}}" style="width:100px;heigth:100px" class="card-img-top" alt="...">
  
</div>
@endforeach
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</html>