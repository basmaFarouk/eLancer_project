
@props([
    'id'=>'','label','name','value'=>'',
])

@if (isset($label))
<label for="{{$id}}" class="form-label">{{$label}}</label>
@endif

<textarea

    {{-- class="form-control @error($name) is-invalid @enderror" --}}
    id="{{$id}}"
    name="{{$name}}"

    {{$attributes->class(['form-control','is-invalid'=>$errors->has($name)])}}
    {{-- {{$attributes}} --}}
    {{-- attributes are collection --}}
    >    {{old($name,$value) ?? ''}} </textarea>
@error($name)
    <p class="text-danger">{{$message}}</p>
@enderror
