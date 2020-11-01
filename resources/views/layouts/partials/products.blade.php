
<div class="row">
  @foreach ($products as $product)
  <div class="col-md-4">
    <div class="card mb-4 shadow-sm">
      <img class="bd-placeholder-img card-img-top" width="100%" height="225" src="{{ asset('storage/images/'.$product->thumbnail) }}" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Thumbnail"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/>
      <div class="card-body">
        <p class="card-title"><b>{{ $product->title }}</b></p>
        <p class="card-text">{!! $product->description !!}</p>
        <div class="d-flex justify-content-between align-items-center">
          <div class="btn-group">
            <a type="button" class="btn btn-sm btn-outline-secondary" href="{{ route('products.single', $product) }}">View Product</a>&nbsp;&nbsp;&nbsp;
            <a type="button" class="btn btn-sm btn-outline-secondary" href="{{ route('products.addToCart', $product) }}">Add to Cart</a>
          </div>
          <small class="text-muted">9 mins</small>
        </div>
      </div>
    </div>
  </div>
  @endforeach
</div>
