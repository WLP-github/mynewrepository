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
                <a href="{{ url("/profile") }}" class="btn btn-link">User Profile</a>
                @include('layouts.message')
                <div class="card">
                    <div class="card-header">{{ __('Booking List') }}</div>
                    <div class="card-body">
                        <table class="table table-striped table-hover table-bordered">
                            <thead>
                                <form action="{{ url('profile/bookingList') }}" method="GET">
                                    <tr>
                                        <td></td>
                                        <td>
                                            <select name="app_cat_id" id="" class="form-control">
                                                <option value="">Choose Appointment Type</option>
                                                @foreach ($appCatLists as $index => $appCatList)
                                                    @if ($appCatList->id == request('app_cat_id'))
                                                    <option value="{{ $index+1 }}" selected>{{ $appCatList->name }}</option>
                                                    @else
                                                    <option value="{{ $index+1 }}" >{{ $appCatList->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </td>
                                        <td> <input id="selector" type="text" value="{{request('app_date')}}" class="form-control" name="app_date" autocomplete="off"></td>
                                        <td></td>
                                        <td></td>
                                        <td><input type="submit" value="Search" class="btn btn-primary"></td>
                                    </tr>
                                </form>
                                <tr>
                                    <td>No</td>
                                    <td>Appointment Type</td>
                                    <td>Booked Date</td>
                                    <td>Booked Time</td>
                                    <td>Booked Qty</td>
                                    <td>Export PDF</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($userBookLists as $index=>$userBookList)
                                    <tr>
                                        <td class="text-right">{{++$index}}</td>
                                        <td>{{ $userBookList->appointmentCategory->name }}</td>
                                        <td>{{ date("d, M-Y", strtotime($userBookList->appointment_date)) }}</td>
                                        <td>{{ $userBookList->slot->name }}</td>
                                        <td class="text-right">{{ $userBookList->item_amount }}</td>
                                        <td class="text-center">
                                            @if ($userBookList->status)
                                                <a href="{{ url('exportPdf/pdf', ['id'=>$userBookList->id]) }}" class="btn btn-link" target="_blank">Export PDF</a>
                                            @else
                                                <span class="badge badge-info">Canceled</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        {{
                            $userBookLists->links()
                        }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('function-js')
    <script>
        $(function(){
            $("#selector").datepicker({
                showAnim: "fold",
                showOptions: { direction: "left" },
                dateFormat: 'dd-mm-yy',
                todayHighlight: true,
            });
        });
    </script>
@endsection

