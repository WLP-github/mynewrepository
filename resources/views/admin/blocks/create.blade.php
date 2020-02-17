@extends('admin.layouts.master')

@section('container')
<div class="row grid-margin">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
          <h4 class="card-title">Add New Reject</h4>

          <nav aria-label="breadcrumb" class="mb-1">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="{{ route('admin.index') }}">Dashboard</a>
              </li>
              <li class="breadcrumb-item">
                <a href="{{ route('admin.blocks.index') }}">Rejected List</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
          </nav>
        </div>

        <form method="POST" action="{{ route('admin.blocks.store') }}">
          @csrf
          @method('POST')

          <fieldset>

            <div class="row">
              <div class="col col-md-6">
                <div class="form-group">
                  <label>Company Name</label>
                  <select  required class="form-control select2" id="user_id" name="user_id">
                    <option selected value="">Select Company Name</option>
                    @foreach($users as $user)
                      <option value="{{$user->id}}">{{ $user->company_name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="col col-md-4">
                <div class="form-group">
                  <label>Company Registration ID</label>
                  <input type="text" class="form-control" name="company_registration_id" id="company_registration_id" placeholder="Company Registration ID" value="{{ old('company_registration_id') }}" readonly>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col col-md-6">
                <div class="form-group">
                  <label>Appointment Category</label>
                  <select required class="form-control select2" id="appointment_category_id" name="appointment_category_id">
                    <option selected value="">Select Appointment Category</option>
                    @foreach($appointmentCategories as $appointCategory)
                      <option value="{{$appointCategory->id}}">{{ $appointCategory->name }}</option>
                    @endforeach
                  </select>
                  @if($errors->has('appointment_category_id'))
                      <label class="error mt-2 text-danger">{{ $errors->first('appointment_category_id') }}</label>
                  @endif
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col col-md-6">
                <div class="form-group">
                  <label>Start Date</label>
                  <input type="text" class="form-control datepicker" name="block_from" placeholder="Start Date"  required autocomplete="off">
                  @if($errors->has('block_from'))
                      <label class="error mt-2 text-danger">{{ $errors->first('block_from') }}</label>
                  @endif
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col col-md-6">
                <div class="form-group">
                  <label>End Date</label>
                  <input type="text" class="form-control datepicker" name="block_to" placeholder="End Date" required autocomplete="off">
                  @if($errors->has('block_to'))
                      <label class="error mt-2 text-danger">{{ $errors->first('block_to') }}</label>
                  @endif
                </div>
              </div>
            </div>

              <input class="btn btn-primary" type="submit" value="Save">
               
          </fieldset>
        </form>
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
<script>

  $(function(){

    $(".datepicker").datepicker(
        {
          format : "dd/mm/yyyy",
          autoclose : true
        }
    );

    $("#user_id").on('change',function(){

      $.ajax({

        url : "{!! url(config('app.admin_prefix').'/ajax/companyRegId') !!}",
        type : "POST",
        data : { 
          "user_id" : this.value,
          "_token" : "{{ csrf_token() }}"
        },
        success:function(data){
            $("#company_registration_id").val(data.company_registration_no);
        }

      });

    });
    
  });

</script>

@endsection