@extends('layouts.dashboard')

@section('title','Edit Users Page')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Users</li>
    <li class="breadcrumb-item active">Edit Users</li>
@endsection

@section('content')
    <form action="{{route('dashboard.users.update',$user->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('dashboard.users._form',[
            'button_label'=>'Update'
])
    </form>
@endsection

