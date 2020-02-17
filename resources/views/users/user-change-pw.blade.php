@extends('layouts.master')

@section('content')
<div class="divider-custom">
    <div class="divider-custom-line"></div>
    <div class="divider-custom-icon">
        Online Booking
    </div>
    <div class="divider-custom-line"></div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('layouts.message')
            <div class="card">
                <div class="card-header">{{ __('User Profile') }}</div>
                @php
                    $user = Auth::user()  
                @endphp
                <div class="card-body">
                    <form method="POST" action="{{ route('user.updatePassword') }}">
                        @csrf 
                        
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="old-password" class="control-label">{{ __('Old Password') }}</label>
                                <input id="old-password" type="password" class="form-control{{ $errors->has('old-password') ? ' is-invalid' : '' }}" name="old_password" required autofocus>

                                @if ($errors->has('old-password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('old-password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="old-password" class="control-label">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
    
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label for="confirm-password" class="control-label">{{ __('Confirm Password') }}</label>
                                <input id="confirm-password" type="password" class="form-control" name="confirm_password" required>
                                
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12 text-center">
                                <a href="javascript:history.back();" class="btn btn-default btn-link">Back</a>
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection