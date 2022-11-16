@extends('layouts.dashboard')

@section('title','Edit Category')

@section('breadcrump')
<li class="breadcrumb-item active">Edit Role</li>
@endsection

@section('content')
{{-- <form method="post" action="/categories/<?= $category->id?>"> --}}
<form method="post" action="{{route('roles.update',$role->id)}}">
<input type="hidden" name="_method" value="put">
    <input type="hidden" name="_token" value="<?= csrf_token()?>">
    <?php echo csrf_field()?>
    @include('roles._form')
</form>
@endsection


