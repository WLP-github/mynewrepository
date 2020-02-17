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
            <a href="{{ url('profile/bookingList') }}" class="btn btn-link">Booking List</a>
            @include('layouts.message')
            <div class="card">
                <div class="card-header">{{ __('User Profile') }}</div>
                @php
                    $user = Auth::user()  
                @endphp
                <div class="card-body">
                    <form method="POST" action="{{ route('user.profile') }}">
                        @csrf 
                        <div class="row">
                            {{-- user name --}}
                            <div class="form-group col-md-6">
                                <label for="name" class="control-label text-md-right">{{ __('Name') }}</label>
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $user->name }}" >

                            </div>
                            {{-- email --}}
                            <div class="col-md-6">
                                <label for="email" class="control-label">{{ __('E-Mail Address') }}</label>
                                <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}" disabled>
                            </div>
                        </div>

                        <div class="row">
                            {{-- company name --}}
                            <div class="form-group col-md-6">
                                <label for="company_name" class="control-label text-md-right">{{ __('Company Name') }}</label>
                                <input id="company_name" type="text" class="form-control{{ $errors->has('company_name') ? ' is-invalid' : '' }}" name="company_name" value="{{ $user->company_name }}" required>

                                @if ($errors->has('company_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('company_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            {{-- company registration Id --}}
                            <div class="col-md-6">
                                <label for="company_registration_no" class="control-label">{{ __('Registration No.') }}</label>
                                <input id="company_registration_no" type="text" class="form-control" name="company_registration_no" value="{{ $user->company_registration_no }}" disabled>
                            </div>
                        </div>

                        <div class="row">
                            {{-- company name --}}
                            <div class="form-group col-md-6">
                                <label for="company_phone_no" class="control-label text-md-right">{{ __('Company Phone No') }}</label>
                                <input id="company_phone_no" type="text" class="form-control{{ $errors->has('company_phone_no') ? ' is-invalid' : '' }}" name="company_phone_no" value="{{ $user->company_phone_no }}" required>

                                @if ($errors->has('company_phone_no'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('company_phone_no') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            {{-- applicant name --}}
                            <div class="form-group col-md-6">
                                <label for="applicant_name" class="control-label">{{ __('Applicant Name') }}</label>

                                <input id="applicant_name" type="text" class="form-control{{ $errors->has('applicant_name') ? ' is-invalid' : '' }}" name="applicant_name" value="{{ $user->applicant_name }}" required>

                                @if ($errors->has('applicant_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('applicant_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            {{-- applicant phone no --}}
                            <div class="col-md-6">
                                <label for="applicant_phone_no" class="control-label">{{ __('Applicant Phone No') }}</label>

                                <input id="applicant_phone_no" type="text" class="form-control{{ $errors->has('applicant_phone_no') ? ' is-invalid' : '' }}" name="applicant_phone_no" value="{{ $user->applicant_phone_no }}" required>

                                @if ($errors->has('applicant_phone_no'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('applicant_phone_no') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <label for="applicant_nrc" class="control-label">{{ __('Applicant NRC') }}</label>
                        <div class="row">
                            {{-- nrc --}}
                            <div class="form-group col-md-6">
                               <input type="text" class="form-control" name="nrc" value="{{$user->applicant_nrc}}" required>
                            </div>
                            @if ($errors->has('nrc'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('nrc') }}</strong>
                                </span>
                            @endif

                            <div class="form-group col-md-6">
                                <a href="{{ url('changePassword') }}" class="btn btn-link">Change Password</a>
                            </div>
                        </div>
                        
                        {{-- <div class="row">
                            <div class="form-group col-md-6">
                            <label for="password" class="control-label">{{ __('Password') }}</label>

                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                            <label for="password-confirm" class="control-label">{{ __('Confirm Password') }}</label>

                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div> --}}

                        <div class="form-group row mb-0">
                            <div class="col-md-12 text-center">
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