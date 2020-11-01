@extends('layouts.app')
@section('sidebar')
@parent
    <p>I love Namuna</p>
@endsection
@section('content')
    @include('layouts/partials/products')
@endsection