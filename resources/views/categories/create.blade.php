@extends('layouts.dashboard')

@section('breadcrump')
<li class="breadcrumb-item active">Create Category</li>
@endsection

@section('title','Create Category')


@section('create')
    @if($errors->any())
        <div  class="alert alert-danger">
            <ul>
               @foreach($errors->all() as $error)
                <li>
                     {{$error}}
                </li>
                @endforeach
            </ul>
        </div>

    @endif

<form method="post" action="{{route('categories.store')}}" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="<?= csrf_token()?>">
    <?php echo csrf_field()?>

    @include('categories._form')
</form>

@endsection

