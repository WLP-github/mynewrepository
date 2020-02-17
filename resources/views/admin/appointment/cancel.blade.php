@extends('admin.layouts.master')

@section('plugin-css')

@endsection

@section ('container')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
          <h4 class="card-title">Appointment Cancel List</h4>

          <nav aria-label="breadcrumb" class="mb-1">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="{{ route('admin.index') }}">Dashboard</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">tokens</li>
            </ol>
          </nav>
        </div>

        <form action="{{ route('appointment_cancel') }}" method="GET">
          <div class="row">
            <div class="col col-md-3">
              <div class="form-group">
                <input type="text" class="form-control" name="company_registration_no" value="{{ request('company_registration_no') }}" placeholder="Enter Company RegID">
              </div>
            </div>

            <div class="col col-md-3">
              <div class="form-group">
                <select name="app_cat_id" id="" class="form-control">
                    <option value="">choose appointment type</option>
                  @foreach ($appCatLists as $index => $appCatList)
                    @if ($index+1 == request('app_cat_id'))
                      <option value="{{ $index+1 }}" selected>{{ $appCatList->name }}</option>
                    @else
                      <option value="{{ $index+1 }}" >{{ $appCatList->name }}</option>
                    @endif
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col col-md-3">
              <input class="btn btn-success" type="submit" value="Search"> 
            </div>
          </div>
        </form>
        <!-- /.d-flex -->

        <div class="row">
          <div class="col-12">
            <div class="table-responsive">
              <table id="order-listing" class="table">
                <thead>
                  <tr class="bg-primary text-white">
                    <th>#</th>
                    <th>Appointment Date</th>
                    <th>Cancel Noti Date</th>
                    <th>Appointment Category</th>
                    <th>Company Name</th>
                    <th>Company Registration No</th>
                    <th>Token Qty</th>
                    <th>Is Cancel</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($appLists as $index => $appList)
                  <tr>
                    <td>{{ $index + 1}}</td>
                    <td>{{ Carbon\Carbon::parse($appList->appointment_date)->format('D, d-M-Y') }}</td>
                    <td>{{ Carbon\Carbon::parse($appList->cancel_time)->format('D, d-M-Y') }}</td>
                    <td class="edit" token_id="{{$appList->id}}">
                      <label>{{ $appList->appointmentCategory->name }}</label>
                    </td>
                    <td>
                      <label>{{ optional($appList->appUser)->company_name }}</label>
                    </td>
                    <td>
                      <label>{{ optional($appList->appUser)->company_registration_no }}</label>
                    </td>
                    <td>
                      <label>{{ $appList->item_amount }}</label>
                    </td>
                    @php
                        $status = $appList->status == 0 ? "Yes": "No";
                        $disabled = $appList->status == 0 ? 1: 0;
                    @endphp
                    <td>
                        <label>{{ $status }}</label>
                      </td>
                    <td class="text-center">
                      @if ((auth()->user()->department_id == $appList->appointmentCategory->department_id) || (auth()->user()->role_id == 1))

                        @if ($disabled)
                          <span class="fa fa-times-circle"></span>
                        @else
                          <a href="{{ url('admin/appointmentCancel', ['id' => $appList->id]) }}"><span class="fa fa-trash-o"></span></a>
                        @endif
                        
                        {{-- <form action="{{ route('admin.tokens.destroy', $appList) }}" method="POST" 
                              class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-light" onclick="return confirm('Are You Sure?');">
                            <span class="fa fa-trash fa-lg text-danger"></span></button>
                        </form> --}}  
                      @else
                        <span class="fa fa-times-circle"></span>
                      @endif
                      </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.table-responsive -->
          </div>
          <!-- /.col -->

          <!-- pagination -->
          <nav class="col-12 d-flex justify-content-end mt-4">
            {{-- {{ $appLists->appends($_GET)->links() }} --}}
          </nav>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
@endsection
