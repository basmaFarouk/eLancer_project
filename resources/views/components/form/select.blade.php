@props([
    'id'=>'','label','name','selected'=>'','options'=>[]
])

@if (isset($label))
<label for="{{$id}}" class="form-label">{{$label}} </label>
@endif

<select
    class="form-control  @error($name) is-invalid @enderror"
    name="{{$name}}"
    id="{{$id}}">

    <option value="">No Parent</option>
    @foreach($options as $value=>$text)
    {{-- options are array and value is the id and text is the name of the category --}}
    <option value="{{$value}}" @if ($value==old($name,$selected))  {{'selected'}} @endif>{{$text}}</option>
    @endforeach

</select>
@error($name)
<p class="text-danger">{{$message}}</p>
@enderror
