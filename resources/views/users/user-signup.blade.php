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
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('user.register') }}">
                        @csrf

                        <div class="row">
                            {{-- user name --}}
                            <div class="form-group col-md-6">
                                <label for="name" class="control-label text-md-right">{{ __('Name') }}</label>
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="name" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            {{-- email --}}
                            <div class="col-md-6">
                                <label for="email" class="control-label">{{ __('E-Mail Address') }}</label>
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="example@gmail.com" required >

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            {{-- company name --}}
                            <div class="form-group col-md-6">
                                <label for="company_name" class="control-label text-md-right">{{ __('Company Name') }}</label>
                                <input id="company_name" type="text" class="form-control{{ $errors->has('company_name') ? ' is-invalid' : '' }}" name="company_name" value="{{ old('company_name') }}" placeholder="Company Name" required>

                                @if ($errors->has('company_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('company_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            {{-- company registration Id --}}
                            <div class="col-md-6">
                                <label for="company_registration_no" class="control-label">{{ __('Registration No.') }}</label>
                                <input id="company_registration_no" type="text" class="form-control{{ $errors->has('company_registration_no') ? ' is-invalid' : '' }}" name="company_registration_no" value="{{ old('company_registration_no') }}" placeholder="011112222" required >

                                @if ($errors->has('company_registration_no'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('company_registration_no') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            {{-- company name --}}
                            <div class="form-group col-md-6">
                                <label for="company_phone_no" class="control-label text-md-right">{{ __('Company Phone No') }}</label>
                                <input id="company_phone_no" type="text" class="form-control{{ $errors->has('company_phone_no') ? ' is-invalid' : '' }}" name="company_phone_no" value="{{ old('company_phone_no') }}" placeholder="09123456789" required>

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

                                <input id="applicant_name" type="text" class="form-control{{ $errors->has('applicant_name') ? ' is-invalid' : '' }}" name="applicant_name" value="{{ old('applicant_name') }}" placeholder="name" required>

                                @if ($errors->has('applicant_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('applicant_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            {{-- applicant phone no --}}
                            <div class="col-md-6">
                            <label for="applicant_phone_no" class="control-label">{{ __('Applicant Phone No') }}</label>

                                <input id="applicant_phone_no" type="text" class="form-control{{ $errors->has('applicant_phone_no') ? ' is-invalid' : '' }}" name="applicant_phone_no" value="{{ old('applicant_phone_no') }}" placeholder="09123456789" required>

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
                            <div class="form-group col-md-3">
                                <select name="state_number" id="state_number" class="form-control">
                                    @foreach ($nrcs as $nrc)
                                    <option value="{{$nrc->state_number}}">{{$nrc->state_number}}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- applicant nrc's short district --}}
                            <div class="col-md-3">
                                <select name="city_name" id="city_name" class="form-control">

                                </select>
                            </div>
                            {{-- applicant nrc's long district --}}
                            <div class="col-md-3">
                                <select name="nationality_type" class="form-control">
                                    <option value="နိုင်">နိုင်</option>
                                    <option value="ဧည့်">ဧည့်</option>
                                    <option value="ပြု">ပြု</option>
                                    <option value="">သာ</option>
                                </select>
                            </div>
                            {{-- applicant nrc's no --}}
                            <div class="col-md-3">
                                <input id="nrcno" type="text" class="form-control{{ $errors->has('applicant_phoneno') ? ' is-invalid' : '' }}" name="nrcno" value="{{ old('nrcno') }}" required>
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
                            <!-- show captcha image html -->
                                {!! 
                                    app('captcha')->render();
                                !!}
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
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
@section('script')
    
<script>
    $(function(){

        selectCityName($("#state_number").val());

        $('select[name="state_number"]').on('change',function(){

            $("#city_name").empty();
            selectCityName(this.value);

        });
    });

    function selectCityName(state_number)
    {
        if(state_number) {
            $.ajax({
            url: "{!! url('cityNameAjax') !!}",
            type: "GET",
            data: {"state_number" : state_number},
                success:function(data){
                    
                    $.each(data, function(key, value){
                        console.log(value);

                        $('select[name=city_name]').prepend('<option value='+value.short_district_mm+'>'+value.short_district_mm+'</option>');
                    });
                }
            });
        }
    }
    
        
</script>
@endsection