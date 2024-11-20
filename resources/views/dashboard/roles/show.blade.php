@extends('layouts.dashboard')

@section('title',$category->name)
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
    <li class="breadcrumb-item active">{{$category->name}}</li>
@endsection

@section('content')
    <table class="table">
        <thead>
        <tr>

            <th>Image</th>
            <th>Name</th>
            <th>Status</th>
            <th>Store</th>
            <th>Created At</th>
        </tr>
        </thead>
        <tbody>
        @php
            $products= $category->products()->with('store')->latest()->paginate(5);
        @endphp
        @forelse($products as $product)
            <tr>
                <td><img src="{{asset('storage/'.$product->image)}}" height="100px"></td>
                <td>{{$product->name}}</td>
                <td>{{$product->status}}</td>
                <td>{{$product->store->name}}</td>
                <td>{{$category->created_at}}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7">No Categories Defined</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    {{$products->links()}}
@endsection
