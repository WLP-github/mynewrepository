<div class="form-group {{ $errors->has($name) ? 'has-danger' : '' }}">
  <label for="{{ $name }}">{{ $title }}</label>

  <select name="{{ $name }}" id="{{ $name }}" class="form-control select2" {{ isset($required) ? 'required' : '' }}>
    @foreach ($objects as $key => $value)
          <option
            value="{{ $value->id }}"
            {{ old($name, (isset($selected) ? $selected : '') ) == $value->id ? 'selected' : '' }}
          >
          {{ $value->name }}
        </option>
      @endforeach
  </select>

  @if($errors->has($name))
      <label class="error mt-2 text-danger">{{ $errors->first($name) }}</label>
  @endif
</div>