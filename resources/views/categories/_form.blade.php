<div class="mb-3">
    {{-- <label for="name" class="form-label">Name</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name',$category->name)}}">
    @error('name')
        <p class="text-danger">{{$message}}</p>
    @enderror --}}

    <x-form.input id="name" name="name" label="Name" value="{{$category->name}}"/>

  </div>
  <div class="mb-3">
    <label for="description" class="form-label">Description </label>
    <textarea  class="form-control  @error('description') is-invalid @enderror" name="description" id="description">{{old('description',$category->description)}}</textarea>
    @error('description')
    <p class="text-danger">{{$message}}</p>
    @enderror
  </div>
  <div class="mb-3">

    <x-form.select id="parent_id" name="parent_id" label="Parent" :options="$data->pluck('name','id')" :selected="$category->parent_id" />

    {{-- <label for="parent_id" class="form-label">Parent </label>
    <select class="form-control  @error('parent_id') is-invalid @enderror" name="parent_id" id="parent_id">

        <option value="">No Parent</option>
        <?php foreach($data as $raw){?>
        <option value="<?= $raw->id?>" @if ($raw->id==old('parent_id',$category->parent_id))  {{'selected'}} @endif><?= $raw->name?></option>
        <?php }?>
    </select>
    @error('parent_id')
    <p class="text-danger">{{$message}}</p>
    @enderror --}}
  </div>
  <div class="mb-3">
    <label for="image" class="form-label">image </label>
    <input type="file" class="form-control  @error('image') is-invalid @enderror" name="image" id="image">
    @error('image')
    <p class="text-danger">{{$message}}</p>
    @enderror
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>
