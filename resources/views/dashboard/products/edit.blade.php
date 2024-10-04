@extends('layouts.dashboard')

@section('title','Edit Products Page')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Edit products</li>
@endsection

@section('content')
    <form action="{{route('dashboard.products.update',$product->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('dashboard.products._form',[
            'button_label'=>'Update'
])
    </form>
@endsection

