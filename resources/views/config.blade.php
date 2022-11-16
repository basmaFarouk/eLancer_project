
@extends('layouts.dashboard')

@section('title')
    Settings

@endsection

@section('breadcrump')
<li class="breadcrumb-item active">setting Page</li>

@endsection

@section('content')
<x-flash-message />
   <form action="{{route('config')}}" method="POST">
        @csrf
         <div class="form-group">
            <x-form.input id="name" name="config[app.name]" label=" Name" :value="config('app.name')"/>
        </div>
        <div class="form-group">

            <x-form.input id="locale" name="config[app.locale]" label="locale" :value="config('app.locale')"/>
        </div>
        <div class="form-group">

            <x-form.input id="currency" name="config[app.currency]" label="Currency" :value="config('app.currency')"/>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>

    </form>
@endsection
