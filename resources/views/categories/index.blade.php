
@extends('layouts.dashboard')

@section('title')
    Categories
    @if (Auth::user()->can('categories.create'))

    <small><a href="{{route('categories.create')}}" class="btn btn-sm btn-outline-primary">+Create Category</a></small>
    @endif
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
                    <th>ID</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>perent_id</th>
                    <th>Created At</th>
                    <th>Action</th>
                </thead>

                <tbody>
                    @foreach($data as $raw)
                    <tr>
                        <td><?= $raw->id?></td>
                        <td><a href="categories/<?php echo $raw->id?>"><?= $raw->name?></a></td>
                        <td><?= $raw->slug?></td>
                        <td><?= $raw->parent_name?></td>
                        <td><?= $raw->created_at?></td>
                        <td>
                            {{-- <a  class="btn btn-primary"  href="categories/<?php echo $raw->id?>/edit">Edit</a> --}}

                            @can('categories.update')
                            <a  class="btn btn-primary"  href="{{route('categories.edit',[$raw->id])}}">Edit</a>
                            @endcan

                            {{-- <form action="/categories/<?php echo $raw->id?>" method="post"> --}}
                            @if (Gate::allows('categories.delete'))

                            <form action="{{route('categories.destroy',[$raw->id])}}" method="post">
                                <input type="hidden" name="_method" value="delete">
                                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>


            </table>
        </div>
        {{$data->withQueryString()->appends(['q'=>'test'])->links()}}
        {{-- withQueryString() >>> عشان يحافظ على الكويري سترينج فى الرابط وميمسحهوش --}}
    {{-- </div> --}}
@endsection
