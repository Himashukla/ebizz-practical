<div class="row mb-3 div{{$temp ?? 1}}">
  <label for="title" class="col-md-2 col-form-label text-md-end">Item Title</label>

  <div class="@if(isset($temp)) col-md-8 @else col-md-10 @endif">
    <input type="text" class="form-control @error('t_title') is-invalid @enderror" name="t_title[]" required
      data-parsley-required-message="Please enter item title." data-parsley-maxlength="25"
                  data-parsley-maxlength-message="Title must be of 25 letters or less.">

    @error('title')
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
    @enderror
  </div>

  @if(isset($temp))
  <div class="col-md-2">
    <button class="btn btn-danger btn-sm m-1 btnRemove" data-temp="{{$temp ?? 1}}">Remove</button>
  </div>
  @endif
</div>

<div class="row mb-3">
    <label for="title" class="col-md-2 col-form-label text-md-end">Set Status</label>
  
    <div class="col-md-10">
      @foreach(\Config::get('Option.item_status') as $option)
      <input type="radio" name="t_title_status[]" value="{{$option}}" @if($loop->first) checked @endif> {{$option}}
      @endforeach                
    </div>
  </div>

<hr>