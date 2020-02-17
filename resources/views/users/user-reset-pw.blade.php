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
        <div class="col-md-6">
            @include('layouts.message')
            <div class="card">
                <div class="card-header">{{ __('User Profile') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('user.update-reset-password') }}">
                            @csrf 
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="email" class="control-label">{{ __('Email') }}</label>
                                    <input id="email" type="email" class="form-control{{ $errors->has('user_email') ? ' is-invalid' : '' }}" value="{{old("user_email")}}" name="email" required autofocus>

                                    @if ($errors->has('user_email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('user_email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group row mb-0">
                                <div class="col-md-12 text-center">
                                    <a href="javascript:history.back();" class="btn btn-default btn-link">Cancel</a>
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Send') }}
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