
@extends('layouts.app')
@section('content')
<h1>Single Product Section</h1><br><br>
<div class="row">
    <div class="col-md-12">
      <div class=" mb-4 ">
          <div class="row">
              <div class="col-md-4">
                <img class="bd-placeholder-img " width="100%" height="325" src="{{ asset('storage/images/'.$product->thumbnail) }}" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Thumbnail"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/>
              </div>
              <div class="col-md-8">
                    <p class="card-title"><b>{{ $product->title }}</b></p>
                    <p class="card-text">{!! $product->description !!}</p>
                    <div class="d-block justify-content-between align-items-center">
                      <div class="btn-group">
                        <a type="button" class="btn btn-sm btn-outline-secondary">Add to Cart</a>
                      </div>
                      <p class="text-muted">9 mins</p>
                    </div>
              </div>
          </div>
      </div>
    </div>
  </div>
  
@endsection