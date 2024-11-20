@extends('layouts.dashboard')

@section('title','Roles Page')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Roles</li>
@endsection

@section('content')
    <div style="padding-left: 25px" class="mb-5">

        <a href="{{route('dashboard.roles.create')}}" class="btn btn-sm btn-outline-primary mr-2">Create New Role</a>


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
        @forelse($roles as $role)
        <tr>

            <td>{{$role->id}}</td>
            <td><a href="{{route('dashboard.roles.show',$role->id)}}">{{$role->name}}</a></td>
            <td>{{$role->created_at}}</td>
            <td>
                @can('Roles.update')
                 <a href="{{route('dashboard.roles.edit',$role->id)}}" class="btn btn-sm btn-outline-success">Edit</a>
                @endcan
            </td>
            <td>
                 @can('Roles.delete')
                 <form action="{{route('dashboard.roles.destroy',$role->id)}}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                @endcan
            </td>
        </tr>
        @empty
            <tr>
                <td colspan="4">No Roles Defined</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    {{$roles->withQueryString()->links()}}
</div>
@endsection

