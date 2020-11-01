@extends('admin.app')
@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item active" aria-current="page">Product</li>
@endsection
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h2 class="h2">Product List</h2>
  <div class="btn-toolbar mb-2 mb-md-0">
    <a href="{{ route('admin.product.create') }}" class="btn btn-sm btn-outline-secondary">
      Add Product
    </a>
  </div>
</div> 
<div class="row">
  <div class="col-md-12">
    @if (session()->has('message'))
      <div class="alert alert-danger">
        {{ session('message') }}
      </div>
    @endif
  </div>
</div>

<div class="table-responsive">
  <table class="table table-striped table-sm">
    <thead>
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Description</th>
        <th>Slug</th>
        <th>Categories</th>
        <th>Price</th>
        <th>Thumbnail</th>
        <th>Created At</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @if ($products->count()>0)
      @foreach ($products as $product)
        <tr>
          <td>{{ $product->id }}</td>
        <td>{{ $product->title }}</td>
        <td>{!!  $product->description !!}</td>
        <td>{{ $product->slug }}</td>
        <td>
          @if ($product->categories()->count()>0)
           @foreach ($product->categories as $children)
             {{ $children->title }},
           @endforeach
          @else
           <strong>{{ "Product" }}</strong>
          @endif
        </td>
        <td>{{ $product->price }}</td>
        <td><img src="{{ asset('storage/images/'.$product->thumbnail) }}" alt="{{ $product->title }}" class="image-responsive"
          height="50"></td>
        @if ($product->trashed())
            <td>{{ $product->deleted_at }}</td>
            <td><a href="{{ route('admin.product.recover',$product->id) }}" class="btn btn-warning btn-sm">Restore</a>|
              <a href="javascript:;" onclick="confirmDelete('{{ $product->id }}')" class="btn btn-danger btn-sm">Delete</a>
                <form id="delete-product-{{ $product->id }}" action="{{ route('admin.product.destroy',$product->id) }}" method="POST" class=" none">
                  @method('DELETE')
                  @csrf
                </form>
              </td>
          @else
            <td>{{ $product->created_at }}</td>
            <td><a href="{{ route('admin.product.edit',$product->slug) }}" class="btn btn-info btn-sm">Edit</a>|
                <a href="{{ route('admin.product.remove',$product->slug) }}" class="btn btn-warning btn-sm ">Trash</a>|
                <a href="javascript:;" onclick="confirmDelete('{{ $product->id }}')" class="btn btn-danger btn-sm">Delete</a>
                <form id="delete-product-{{ $product->id }}" action="{{ route('admin.product.destroy',$product->slug) }}" method="POST" class=" none">
                  @method('DELETE')
                  @csrf
                </form>
              </td>
        @endif
      </tr>
      @endforeach
      @else
      <tr>
        <div class="col-md-12">
          <td colspan="9">No Product Found</td>
        </div>
      </tr>
      @endif
    </tbody>
  </table>
</div>
<div class="row">
  <div class="col-md-12">
    {{ $products->links() }}
  </div>
</div>
@endsection

@section('scripts')
  <script type="text/javascript">
    function confirmDelete(id){
      let choice = confirm("Are You Sure ,Want to Delete this Product?")
      if(choice){
        document.getElementById('delete-product-'+id).submit();
      }
    }
  </script>
@endsection