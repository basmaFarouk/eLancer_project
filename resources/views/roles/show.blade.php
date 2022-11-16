@extends('layouts.dashboard')
@section('title','Show Category')

@section('breadcrump')
<li class="breadcrumb-item active">Show Page</li>
@endsection
@section('content')


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

            <tr>
                <td><?= $category->id?></td>
                <td><?= $category->name?></a></td>
                <td><?= $category->slug?></td>
                <td><?= $category->parent_id?></td>
                <td><?= $category->created_at?></td>
                <td>
                    {{-- <a  class="btn btn-primary"  href="categories/<?php echo $category?>/edit">Edit</a> --}}
                    <a  class="btn btn-primary"  href="{{route('categories.edit',[$category->id])}}">Edit</a>

                    {{-- <form action="/categories/<?php echo $category->id?>" method="post"> --}}
                    <form action="{{route('categories.destroy',[$category->id])}}" method="post">
                        <input type="hidden" name="_method" value="delete">
                        <input type="hidden" name="_token" value="<?= csrf_token()?>">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>

        </tbody>


    </table>
</div>

@endsection
