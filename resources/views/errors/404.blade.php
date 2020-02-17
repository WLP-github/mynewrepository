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
                <h3 class="text-danger text-center">Page Not Found.</h3>
            </div>
            <div class="text-danger text-center"><h4><a href="{{ url('/') }}" class="text-center btn btn-link">Click me to go home page.</a></h4></div>
            <div class="text-info text-center">If you feel something wrong, you can contact with phone number at the footer.</div>
        </div>

        <p class="mb-3">&nbsp;</p>
    </div>
</div>

@endsection