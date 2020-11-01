@extends('layouts.app')
@section('sidebar')
@parent
    <p>Categories</p>
@endsection
@section('content')
@if (isset($cart) && $cart->getContents())
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-10 col-md-offset-1">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th class="text-center">Price</th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart->getContents() as $slug => $product)
                            <tr>
                            <td class="col-sm-8 col-md-6">
                            <div class="media">
                                <a class="thumbnail pull-left" href="#"> <img class="media-object" src="{{ asset('storage/images/'.$product['product']->thumbnail) }}" style="width: 72px; height: 72px;"> </a>
                                <div class="media-body">
                                    <h4 class="media-heading"><a href="#">{{ $product['product']->title }}</a></h4>
                                    <h5 class="media-heading"> Size: <a href="#">Brand name</a></h5>
                                    <span>Status: </span><span class="text-success"><strong>In Stock</strong></span>
                                </div>
                            </div></td>
                            <td class="col-sm-1 col-md-1" style="text-align: center">
                                <form action="{{ route('cart.update',$slug) }}" method="POST">
                                    @csrf
                                    <input type="number" class="form-control" name="qty" id="exampleInputEmail1" value="{{ $product['qty'] }}">&nbsp;
                                    <button class="btn btn-info">Update</button>
                                </form>
                            </td>
                            <td class="col-sm-1 col-md-1 text-center"><strong>${{ $product['price'] }}</strong>
                                <small class="text-muted">(USD{{$product['product']->price}} each)</small></td>
                            <td class="col-sm-1 col-md-1">
                                <form action="{{ route('cart.remove', $slug) }}" method="POST" accept-charset="utf-8">
                                    @csrf
                                    <a type="button" class="btn btn-danger" href="{{ route('cart.remove', $product) }}">
                                        <span class="glyphicon glyphicon-remove"></span> Remove
                                    </a>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td><h5>Total Price:</h5></td>
                        <td class="text-right"><h5><strong>${{ $cart->getTotalPrice() }}</strong></h5></td>
                    </tr>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td><h5>Total Quantity:</h5></td>
                        <td class="text-right"><h5><strong>{{ $cart->getTotalQty() }}</strong></h5></td>
                    </tr>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td><h3>Total</h3></td>
                        <td class="text-right"><h3><strong>${{ $cart->getTotalPrice() }}</strong></h3></td>
                    </tr>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>
                        <button type="button" class="btn btn-default">
                            <span class="glyphicon glyphicon-shopping-cart"></span> Continue Shopping
                        </button></td>
                        <td>
                        <a type="button" class="btn btn-success" href="{{ route('checkout.index') }}">
                            Checkout <span class="glyphicon glyphicon-play"></span>
                        </a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@else
 <h1>Sorry,No Item in the Cart!</h1>
@endif
@endsection