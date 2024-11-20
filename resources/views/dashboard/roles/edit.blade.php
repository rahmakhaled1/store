@extends('layouts.dashboard')

@section('title','Edit Roles Page')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Roles</li>
    <li class="breadcrumb-item active">Edit Roles</li>
@endsection

@section('content')
    <form action="{{route('dashboard.roles.update',$role->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('dashboard.roles._form',[
            'button_label'=>'Update'
])
    </form>
@endsection

