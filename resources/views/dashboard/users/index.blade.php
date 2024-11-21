@extends('layouts.dashboard')

@section('title','Roles Page')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Users</li>
@endsection

@section('content')
    <div style="padding-left: 25px" class="mb-5">

        <a href="{{route('dashboard.users.create')}}" class="btn btn-sm btn-outline-primary mr-2">Create New User</a>


    </div>
<x-alert type="success"/>
<x-alert type="info"/>
<div>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Created At</th>
            <th colspan="2"></th>
        </tr>
        </thead>
        <tbody>
        @forelse($users as $user)
        <tr>

            <td>{{$user->id}}</td>
            <td><a href="{{route('dashboard.users.show',$user->id)}}">{{$user->name}}</a></td>
            <td>{{$user->created_at}}</td>
            <td>
                @can('users.update')
                 <a href="{{route('dashboard.users.edit',$user->id)}}" class="btn btn-sm btn-outline-success">Edit</a>
                @endcan
            </td>
            <td>
                 @can('users.delete')
                 <form action="{{route('dashboard.users.destroy',$user->id)}}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                @endcan
            </td>
        </tr>
        @empty
            <tr>
                <td colspan="4">No Users Defined</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    {{$users->withQueryString()->links()}}
</div>
@endsection

