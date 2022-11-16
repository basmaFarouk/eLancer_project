@extends('layouts.dashboard')

@section('title','Edit Category')

@section('breadcrump')
<li class="breadcrumb-item active">Edit Page</li>
@endsection

@section('content')
{{-- <form method="post" action="/categories/<?= $category->id?>"> --}}
<form method="post" action="{{route('categories.update',['id'=>$category->id])}}" enctype="multipart/form-data">
<input type="hidden" name="_method" value="put">
    <input type="hidden" name="_token" value="<?= csrf_token()?>">
    <?php echo csrf_field()?>
    @include('categories._form')
</form>
@endsection


