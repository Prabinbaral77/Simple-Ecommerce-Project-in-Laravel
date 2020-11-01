@extends('admin.app')
@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item active" aria-current="page">Categories</li>
@endsection
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h2 class="h2">Categories List</h2>
  <div class="btn-toolbar mb-2 mb-md-0">
    <a href="{{ route('admin.category.create') }}" class="btn btn-sm btn-outline-secondary">
      Add Category
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
        <th>Category</th>
        <th>Created At</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @if ($categories)
      @foreach ($categories as $category)
        <tr>
          <td>{{ $category->id }}</td>
        <td>{{ $category->title }}</td>
        <td>{!!  $category->description !!}</td>
        <td>{{ $category->slug }}</td>
        <td>
          @if ($category->childrens->count()>0)
           @foreach ($category->childrens as $children)
             {{ $children->title }},
           @endforeach
          @else
           <strong>{{ "Parent Category" }}</strong>
          @endif
        </td>
        @if ($category->trashed())
        <td>{{ $category->deleted_at }}</td>

        <td><a href="{{ route('admin.category.recover',$category->id) }}" class="btn btn-warning btn-sm">Restore</a>|
            <a href="javascript:;" onclick="confirmDelete('{{ $category->id }}')" class="btn btn-danger btn-sm">Delete</a>
            <form id="delete-category-{{ $category->id }}" action="{{ route('admin.category.destroy',$category->id) }}" method="POST" class="d-none">
              @method('DELETE')
              @csrf
            </form>
          </td>
          @else
            <td>{{ $category->created_at }}</td>

        <td><a href="{{ route('admin.category.edit',$category->id) }}" class="btn btn-info btn-sm">Edit</a>|
            <a href="{{ route('admin.category.remove',$category->id) }}" class="btn btn-warning btn-sm ">Trash</a>|
            <a href="javascript:;" onclick="confirmDelete('{{ $category->id }}')" class="btn btn-danger btn-sm">Delete</a>
            <form id="delete-category-{{ $category->id }}" action="{{ route('admin.category.destroy',$category->id) }}" method="POST" class="d-none">
              @method('DELETE')
              @csrf
            </form>
          </td>
        @endif
      </tr>
      @endforeach
      @else
      <tr>
        <td colspan="5">No Categories Found</td>
      </tr>
      @endif
    </tbody>
  </table>
</div>
<div class="row">
  <div class="col-md-12">
    {{ $categories->links() }}
  </div>
</div>
@endsection

@section('scripts')
  <script type="text/javascript">
    function confirmDelete(id){
      let choice = confirm("Are You Sure ,Want to Delete this record?")
      if(choice){
        document.getElementById('delete-category-'+id).submit();
      }
    }
  </script>
@endsection