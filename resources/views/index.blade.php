@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="divider-custom">
            <div class="divider-custom-line"></div>
                <div class="divider-custom-icon">
                    Online Booking
                </div>
            <div class="divider-custom-line"></div>
        </div>
        @include('layouts.message')
        
    <div class="text-center" id="time"></div>
    <div class="row">
    <!-- Portfolio item one  -->
    <div class="col-md-6 col-lg-4 mb-3">
        <div class="portfolio-item mx-auto text-center">
            <div class="fa-icon-1">
                    <span class="fa fa-book fa-6"></span>
                </div>
            </div>
            <div class="col-lg-12 mt-n4">
                <label for="" class="form-control text-center">
                    <a class="bookingLink" href="{{ url('cosmetic/appoint_new/1') }}"> New Costmetic Booking</a>
                </label>
                <label for="" class="form-control text-center">
                    <a class="bookingLink" href="{{ url('profile/bookingList') }}"> Resend Costmetic Booking</a>
                </label>
                <label for="" class="form-control text-center"><a href="{{ url('etoken/cancelAppointmentList', ['dept_id'=>1]) }}">Apply Cancel Booking</a></label>
            </div>
        </div>

        <!-- Portfolio Item 2 -->
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="portfolio-item mx-auto text-center">
                <div class="fa-icon-1">
                <span class="fas fa-briefcase-medical fa-6"></span>
                </div>
            </div>
            <!-- </a> -->
            <div class="col-lg-12 mt-n4">
                <label for="" class="form-control text-center"><a href="{{ url('cosmetic/appoint_new/2') }}">New Medical Device Booking</a></label>
                <label for="" class="form-control text-center"><a href="{{ url('profile/bookingList') }}">Resend Medical Device Booking</a></label>
                <label for="" class="form-control text-center"><a href="{{ url('etoken/cancelAppointmentList', ['dept_id'=>2]) }}">Apply Cancel Booking</a></label>
            </div>
        </div>

        <!-- Portfolio Item 3 -->
        <div class="col-md-6 col-lg-4">
            <div class="portfolio-item mx-auto text-center">
                <div class="fa-icon-1">
                <span class="fas fa-first-aid fa-6"></span>
                </div>
            </div>
            <div class="col-lg-12 mt-n4">
            <label for="" class="form-control text-center"><a href="{{ url('cosmetic/appoint_new/3') }}">New Grouping Booking</a></label>
            <label for="" class="form-control text-center"><a href="{{ url('profile/bookingList') }}">Resend Grouping Booking</a></label>
            <label for="" class="form-control text-center"><a href="{{ url('etoken/cancelAppointmentList', ['dept_id'=>3]) }}">Cancel Booking</a></label>
            </div>
        </div>
    </div>

@endsection
