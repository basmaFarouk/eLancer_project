@extends('layouts.dashboard')

@section('title')
    Assign Roles
    {{-- @if (Auth::user()->can('categories.create')) --}}

    {{-- <small><a href="{{route('categories.create')}}" class="btn btn-sm btn-outline-primary">+Create Category</a></small> --}}
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

        <form action="{{route('users.update',$new_user->id)}}" method="POST">
            @csrf
            @method('PUT')
    <div class="form-group">
        @foreach ($roles as $role )

        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="roles[]" value="{{$role->id}}" @if (in_array($role->id,$userRoles))
            checked @endif >
            <label class="form-check-label" for="flexCheckDefault">

              {{$role->name}}
            </label>
          </div>

        @endforeach
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>

        </form>

        {{$roles->withQueryString()->links()}}
        {{-- withQueryString() >>> عشان يحافظ على الكويري سترينج فى الرابط وميمسحهوش --}}
    {{-- </div> --}}
@endsection
