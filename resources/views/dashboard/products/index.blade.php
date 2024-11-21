@extends('layouts.dashboard')

@section('title','Products')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Products</li>
@endsection

@section('content')
    <div style="padding-left: 25px" class="mb-5">
            <a href="{{route('dashboard.products.create')}}" class="btn btn-sm btn-outline-primary mr-2">Create New Product</a>
{{--        <a href="{{route('dashboard.products.trash')}}" class="btn btn-sm btn-outline-dark">Trash</a>--}}
    </div>
<x-alert type="success"/>
<x-alert type="info"/>
<form action="{{URL::current()}}" method="get" class="d-flex justify-content-between mb-4">
    <x-form.input name="name" placeholder="Name" class="mx-2" :value="request('name')"/>
    <select name="status" class="form-control mx-2">
        <option value="">All</option>
        <option value="active"@selected(request('status') == 'active')>Active</option>
        <option value="archive" @selected(request('status') == 'archive')>Archive</option>
    </select>
    <button class="btn btn-dark">Filter</button>

</form>
<div>
    <table class="table">
        <thead>
        <tr>
            <th>Image</th>
            <th>ID</th>
            <th>Name</th>
            <th>Status</th>
            <th>Category</th>
            <th>Store</th>
            <th>Created At</th>
            <th colspan="2"></th>
        </tr>
        </thead>
        <tbody>
        @forelse($products as $product)
        <tr>
            <td><img src="{{asset('storage/'.$product->image)}}" height="100px"></td>
            <td>{{$product->id}}</td>
            <td>{{$product->name}}</td>
            <td>{{$product->status}}</td>
            <td>{{$product->category->name}}</td>
            <td>{{$product->store->name}}</td>
            <td>{{$product->created_at}}</td>
            <td>

                 <a href="{{route('dashboard.products.edit',$product->id)}}" class="btn btn-sm btn-outline-success">Edit</a>
            </td>
            <td>
                 <form action="{{route('dashboard.products.destroy',$product->id)}}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
            </td>
        </tr>
        @empty
            <tr>
                <td colspan="9">No Products Defined</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    {{$products->withQueryString()->appends(['search'=>1])->links()}}
</div>
@endsection

