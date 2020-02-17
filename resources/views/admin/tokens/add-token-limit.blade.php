@extends('admin.layouts.master')

@section('plugin-css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
@endsection

@section('container')
<div class="row grid-margin">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
          <h4 class="card-title">Add New Token Slot</h4>

          <nav aria-label="breadcrumb" class="mb-1">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="{{ route('admin.index') }}">Dashboard</a>
              </li>
              <li class="breadcrumb-item">
                <a href="{{ route('admin.tokens.index') }}">Tokens</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">Create</li>
            </ol>
          </nav>
        </div>

        @if(isset($dates))

        <div class="col-12">
            <h3>Limit For {{ $appointmentCategory->name }}</h3>
            <div class="table-responsive">
              <form action="{{ route('admin.tokens.store') }}" method="POST" role="form">
                @csrf

                <input type="hidden" name="appointment_category_id" value="{{ $appointmentCategory->id }}">
                <input type="hidden" name="slot_id" value="{{ $slotId }}">

                <table id="order-listing" class="table">
                  <thead>
                    <tr class="bg-primary text-white">
                          <td></td>
                      @foreach($dates as $date)
                          <td class="text-center">
                            <b>{{ Carbon\Carbon::parse($date)->format('D') }}</b>
                            <br><br>
                            <label class="badge badge-success">{{ Carbon\Carbon::parse($date)->format('d-M-Y') }}</label>
                          </td>
                      @endforeach
                    </tr>
                  </thead>
                  <tbody>
                      <tr>
                        <td>
                          <strong>Limit Qty</strong>
                        </td>
                        @foreach($dates as $date)
                          <td class="text-center">
                            <input type="number" name="limit_amount[]" class="form-control" autocomplete="off" min="0" value="0">
                            <input type="hidden" name="dates[]" value="{{ Carbon\Carbon::parse($date) }}">
                          </td>
                        @endforeach
                      </tr>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="6">
                        <button class="btn btn-primary">Submit</button>
                      </td>
                    </tr>
                  </tfoot>
                </table>
              </form>
            </div>
            <!-- /.table-responsive -->
        </div>
        <hr>
        <!-- /.col -->
        {{-- calendar --}}
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Online Booking Calendar</div>
                <div class="panel-body">
                  {!! $calendar->calendar() !!}
                </div>
            </div>
        </div>
        {{-- end calendar --}}
        @endif

      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->
@endsection

@section('custom-js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
  {!! $calendar->script() !!}
@endsection
