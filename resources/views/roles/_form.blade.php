<div class="mb-3">
    {{-- <label for="name" class="form-label">Name</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name',$category->name)}}">
    @error('name')
        <p class="text-danger">{{$message}}</p>
    @enderror --}}

    <div class="form-group">

        <x-form.input id="name" name="name" label="Role Name" value="{{$role->name}}"/>
    </div>

    <div class="form-group">
        @foreach (config('abilities') as $ability=>$label )

        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="abilities[]" value="{{$ability}}" @if(in_array($ability,($role->abilities ?? []))) checked @endif>
            <label class="form-check-label" for="flexCheckDefault">
              {{$label}}
            </label>
          </div>

        @endforeach
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>

</div>
