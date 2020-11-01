@extends('admin.app')
@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item"><a href="{{ route('admin.category.index') }}">categories</a></li>
<li class="breadcrumb-item active" aria-current="page">Add / Edit Category</li>
@endsection
@section('extra-css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
<form method="POST" action="@if(isset($category)) {{ route('admin.category.update', $category->id) }} @else{{ route('admin.category.store') }} @endif">
  @csrf
  @if (isset($category))
    @method('PUT')
  @endif
  <div class="form-group row">
    <div class="col-sm-12">
      @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div>
        @endif
    </div>
    <div class="col-sm-12">
      @if (session()->has('message'))
      <div class="alert alert-success">
        {{session('message')}}
      </div>
        @endif
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-12">
      <label class="form-control-label">Title: </label>
      <input type="text" id="txturl" name="title" class="form-control" value="{{ @$category->title }}">
      <p class="small">{{ config('app.url') }}/<span id="url">{{ @$category->slug }}</span></p>
      <input type="hidden" name="slug" id="slug" value="{{ @$category->slug }}">
    </div>
  </div>
  <div class="form-group row">


    <div class="col-sm-12">
      <label class="form-control-label">Description: </label>
      <textarea name="description" id="editor" class="form-control" rows="10" cols="80">{!! @$category->description !!}</textarea>
    </div>
  </div>
  <div class="form-group row">
    @php
    use Illuminate\Support\Arr;
    $ids = (isset($category->childrens) && $category->childrens->count()>0) ? arr::pluck($category->childrens, 'id'):null;
    @endphp
    <div class="col-sm-12">
      <label class="form-control-label">Select Category: </label>
      <select class="form-control" id="parent_id" name="parent_id[]" multiple="multiple">
        @if (isset($categories))
          <option value="0">Top Level</option>
          @foreach ($categories as $cat)
            <option value="{{ $cat->id }}" @if (!is_null($ids ) && in_array($cat->id,$ids ))
              {{ 'selected' }}
            @endif >{{ $cat->title }}</option>
          @endforeach
        @endif
      </select>
    </div><br><br><br><br>
    <div style="padding-left: 15px"; >
      @if (isset($category))
      <button type="submit" class="btn btn-primary">Update</button>
      @else
      <button type="submit" class="btn btn-primary">Add Category</button>
      @endif
    </div>
</form>
@endsection

@section('scripts')
<script type="text/javascript">
$(function(){
  ClassicEditor.create( document.querySelector('#editor'),{
    toolbar: ['Heading','Link','bold','italic','bulletedList','numberedList','blockQuote','undo','redo'],
  }).then(editor => {
    console.log(editor);
  }).catch(error => {
    console.error(error);
  });
  $('#txturl').on('keyup',function(){
    var url= slugify($(this).val());
    $('#url').html(url);
    $('#slug').val(url);
  })
  $('#parent_id').select2({
    placeholder: "Select a Parent Category",
    allowClear: true,
    mimimumResultsForSearch: Infinity
  });
})
</script>
@endsection
@section('extra-js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
@endsection