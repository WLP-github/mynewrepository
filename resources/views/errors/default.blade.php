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
            <div class="text-center">
                <h3 class="text-danger">Error.</h3>
                <span class="text-danger">Something went wrong, please login again</span>
                <br><span class="text-danger">click here to <a href="{{ url('user-login') }}">login</a> again.</span>
                <div class="text-info text-right">Thanks for your patient.</div>
            </div>

        </div>
    </div>
</div>

@endsection