@extends('layouts.dashboard')

@section('breadcrump')
<li class="breadcrumb-item active">Create Role</li>
@endsection

@section('title','Create Role')


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

<form method="post" action="{{route('roles.store')}}">
    <input type="hidden" name="_token" value="<?= csrf_token()?>">
    <?php echo csrf_field()?>

    @include('roles._form')
</form>

@endsection

