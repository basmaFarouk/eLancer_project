
@extends('layouts.dashboard')

@section('title')
    Deleted Categories  <small><a href="{{route('categories.create')}}" class="btn btn-sm btn-outline-primary">+Create Category</a></small>
@endsection

@section('breadcrump')
<li class="breadcrumb-item active">Deleted Categories</li>
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
                    <th>Deleted At</th>
                    <th>Action</th>
                </thead>

                <tbody>
                    @foreach($data as $raw)
                    <tr>
                        <td><?= $raw->id?></td>
                        <td><a href="categories/<?php echo $raw->id?>"><?= $raw->name?></a></td>
                        <td><?= $raw->slug?></td>
                        <td><?= $raw->parent->name?></td>
                        <td><?= $raw->deletetd_at?></td>
                        <td>
                            {{-- <a  class="btn btn-primary"  href="categories/<?php echo $raw->id?>/edit">Edit</a> --}}
                            <a  class="btn btn-primary"  href="{{route('categories.edit',[$raw->id])}}">Edit</a>

                            <form action="{{route('categories.restore',[$raw->id])}}" method="post">
                                <input type="hidden" name="_method" value="put">
                                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                <button type="submit" class="btn btn-info">Restore</button>
                            </form>
                            {{-- <form action="/categories/<?php echo $raw->id?>" method="post"> --}}
                            <form action="{{route('categories.forceDelete',[$raw->id])}}" method="post">
                                <input type="hidden" name="_method" value="delete">
                                <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                <button type="submit" class="btn btn-danger">Force Delete</button>
                            </form>
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
