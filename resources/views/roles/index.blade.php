
@extends('layouts.dashboard')

@section('title')
    Roles  <small><a href="{{route('roles.create')}}" class="btn btn-sm btn-outline-primary">+Create Role</a></small>
@endsection

@section('breadcrump')
<li class="breadcrumb-item active">Role Page</li>
@endsection

@section('content')
    {{-- <div class="container"> --}}

       {{-- {{session()->get('message')}} --}}
       <x-flash-message />
    </h1>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Users #</th>
                    <th>Created At</th>
                    <th>Action</th>
                </thead>

                <tbody>
                    @foreach($roles as $role)
                    <tr>
                        <td>{{$role->id}}</td>
                        <td><a href="{{route('roles.show',['role'=>$role->id])}}">{{$role->name}}</a></td>
                        <td>{{$role->users_count}}</td>
                        <td>{{$role->created_at}}</td>
                        <td>

                            <a  class="btn btn-primary"  href="{{route('roles.edit',[$role->id])}}">Edit</a>


                            <form action="{{route('roles.destroy',[$role->id])}}" method="post">
                                <input type="hidden" name="_method" value="delete">
                                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>


            </table>
        </div>
        {{$roles->withQueryString()->links()}}
        {{-- withQueryString() >>> عشان يحافظ على الكويري سترينج فى الرابط وميمسحهوش --}}
    {{-- </div> --}}
@endsection
