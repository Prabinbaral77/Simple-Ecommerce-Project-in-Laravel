@extends('admin.app')
@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item active" aria-current="page">Users</li>
@endsection
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h2 class="h2">Users List</h2>
  <div class="btn-toolbar mb-2 mb-md-0">
    <a href="{{ route('admin.profile.create') }}" class="btn btn-sm btn-outline-secondary">
      Add Users
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
        <th>Name</th>
        <th>Email</th>
        <th>Slug</th>
        <th>role</th>
        <th>Address</th>
        <th>Thumbnail</th>
        <th>Created At</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @if (isset($users) && $users->count()>0)
      @foreach ($users as $user)
        <tr>
        <td>{{ @$user->id }}</td>
        <td>{{ @$user->profile->name }}</td>
        <td>{{ @$user->email }}</td>
        <td>{{ @$user->profile->slug }}</td>
        <td>{{ @$user->role->name}}</td>
        <td>{{ @$user->profile->address }},{{ @$user->getCity()}},{{ @$user->getState()}},{{ @$user->getCounry()}}</td>
        <td><img src="{{ asset('storage/'.@$user->profile->thumbnail) }}" alt="{{ @$user->profile->name }}" class="image-responsive"
          height="50"></td>
        @if ($user->trashed())
            <td>{{ $user->deleted_at }}</td>
            <td><a href="{{ route('admin.profile.recover',$user->id) }}" class="btn btn-warning btn-sm">Restore</a>|
              <a href="javascript:;" onclick="confirmDelete('{{ $user->id }}')" class="btn btn-danger btn-sm">Delete</a>
                <form id="delete-profile-{{ $user->id }}" action="{{ route('admin.profile.destroy',$user->profile->id) }}" method="POST" class=" none">
                  @method('DELETE')
                  @csrf
                </form>
              </td>
          @else
            <td>{{ $user->created_at }}</td>
            <td><a href="{{ route('admin.profile.edit',$user->profile->slug) }}" class="btn btn-info btn-sm">Edit</a>|
                <a href="{{ route('admin.profile.remove',$user->profile->slug) }}" class="btn btn-warning btn-sm ">Trash</a>|
                <a href="javascript:;" onclick="confirmDelete('{{ $user->id }}')" class="btn btn-danger btn-sm">Delete</a>
                <form id="delete-user-{{ $user->id }}" action="{{ route('admin.profile.destroy',$user->profile->slug) }}" method="POST" class=" none">
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
          <td colspan="9">No Users Found</td>
        </div>
      </tr>
      @endif
    </tbody>
  </table>
</div>
<div class="row">
  <div class="col-md-12">
    {{ $users->links() }}
  </div>
</div>
@endsection

@section('scripts')
  <script type="text/javascript">
    function confirmDelete(id){
      let choice = confirm("Are You Sure ,Want to Delete this User?")
      if(choice){
        document.getElementById('delete-user-'+id).submit();
      }
    }
  </script>
@endsection