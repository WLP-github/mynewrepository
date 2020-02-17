<div class="form-group {{ $errors->has($name) ? 'has-danger': '' }}">
  	<label for="{{ $name }}">{{ $title }}</label> 

  	<textarea id="{{ $name }}" 
  			  class="form-control" 
  			  name="{{ $name }}" 
  			  placeholder="{{ isset($placeholder) ? $placeholder : '' }}"
	  		  {{ isset($autofocus) ? 'autofocus': ''}}
	  		  {{ isset($required) ? 'required': '' }}>{{ old($name, $value) }}</textarea> 

	@if($errors->has($name))
	  	<label class="error mt-2 text-danger">{{ $errors->first($name) }}</label>
	@endif
</div>
