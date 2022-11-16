
@extends('layouts.dashboard')

@section('title')
    Users
    {{-- @if (Auth::user()->can('categories.create')) --}}

    <small><a href="{{route('categories.create')}}" class="btn btn-sm btn-outline-primary">+Create Category</a></small>
    {{-- @endif --}}
@endsection

@section('breadcrump')
<li class="breadcrumb-item active">Starter Page</li>
@endsection

@section('content')
    {{-- <div class="container"> --}}

       {{-- {{session()->get('message')}} --}}
       <x-flash-message />
    </h1>
        <div class="table-responsive">
            <table class="table">
                <thead>

                    <th>Name</th>
                    <th>Email</th>

                    <th>Action</th>
                </thead>

                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>

                            <a  class="btn btn-primary"  href="{{route('users.assignrole',$user->id)}}">Assign Role</a>
                            {{-- @if (Gate::allows('categories.delete')) --}}

                            <form action="{{route('users.destroy',$user->id)}}" method="post">
                                <input type="hidden" name="_method" value="delete">
                                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                            {{-- @endif --}}

                        </td>
                    </tr>
                    @endforeach
                </tbody>


            </table>
        </div>
        {{$users->withQueryString()->links()}}
        {{-- withQueryString() >>> عشان يحافظ على الكويري سترينج فى الرابط وميمسحهوش --}}
    {{-- </div> --}}
@endsection
