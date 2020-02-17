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
                <div class="card-header">{{ __('Booking List') }}</div>
                <div class="card-body">
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Appointment Type</td>
                                <td>Booked Date</td>
                                <td>Booked Time</td>
                                <td>Booked Qty</td>
                                <td>Cancel Appointment</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($appBookLists as $index=>$appBookList)
                                <tr>
                                    <td class="text-right">{{++$index}}</td>
                                    <td>{{ $appBookList->appointmentCategory->name }}</td>
                                    <td>{{ date("d, M-Y", strtotime($appBookList->appointment_date)) }}</td>
                                    <td>{{ $appBookList->slot->name }}</td>
                                    <td class="text-right">{{ $appBookList->item_amount }}</td>

                                    @php
                                        $booked_date = strtotime("-3 days", strtotime($appBookList->appointment_date));
                                        $today = strtotime("today");
                                    @endphp

                                    @if ($booked_date < $today)

                                        <td class="text-center"><span class="badge badge-info">Date Expired</span></td>
                                    
                                    @elseif ($appBookList->is_cancel)

                                        <td class="text-center"><span class="badge badge-info">Canceled</span></td>

                                    @else

                                        <td class="text-center"><a href="{{ url('etoken/cancelAppointment', ['id'=>$appBookList->id]) }}" class="btn btn-link" >Cancel</a></td>

                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection