<div class="form-group {{ $errors->has($name) ? 'has-danger': ''}}">
  	<label for="{{ $name }}">{{ $title }}</label>

  	<input id="{{ $name }}" 
  		   class="form-control" 
  		   name="{{ $name }}" 
  		   type="{{ isset($type) ? $type : 'text' }}"
  		   placeholder="{{ isset($placeholder) ? $placeholder : '' }}"
  		   value="{{ old($name, $value) }}" 
  		   {{ isset($autofocus) ? 'autofocus': ''}}
  		   {{ isset($required) ? 'required': '' }}>
  
  	@if($errors->has($name))
		<label class="error mt-2 text-danger">{{ $errors->first($name) }}</label>
	@endif
</div>
