@props([
    'id','label','name','value'=>'','type'=>'text'
])

<label for="{{$id}}" class="form-label">{{$label}}</label>
<input
    type="{{$type ?? 'text'}}"
    {{-- class="form-control @error($name) is-invalid @enderror" --}}
    id="{{$id}}"
    name="{{$name}}"
    value="{{old($name,$value)}}"
    {{$attributes->class(['form-control','is-invalid'=>$errors->has('name')])}}
    {{-- {{$attributes}} --}}
    {{-- attributes are collection --}}
    >
@error($name)
    <p class="text-danger">{{$message}}</p>
@enderror
