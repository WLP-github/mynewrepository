@extends('admin.layouts.master')

@section('container')
<div class="row grid-margin">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
          <h4 class="card-title">Edit Reject</h4>

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

        <form method="POST" action="{{ route('admin.blocks.update', $block) }}">
          @csrf
          @method('PATCH')

          <fieldset>
          
            <div class="col col-md-6">

              <div class="form-group">
                <label>Company Name</label>
                <input type="text" class="form-control" name="company_name" placeholder="Company Name" value="{{ $block->rejectUser->company_name }}" readonly>
              </div>

              <div class="form-group">
                <label>Company Registration ID</label>
                <input type="text" class="form-control" name="company_registration_id" placeholder="Company Registration ID" value="{{ $block->rejectUser->company_registration_no }}" readonly>
              </div>

              <div class="form-group">
                  <label>Appointment Category</label>
                  <select required class="form-control select2" id="appointment_category_id" name="appointment_category_id">
                    <option selected value="">Select Appointment Category</option>
                    @foreach($appointmentCategories as $appointCategory)
                    
                      @if ($appointCategory->id == $block->appointment_category_id)
                        <option value="{{$appointCategory->id}}" selected>{{ $appointCategory->name }}</option>
                      @else
                        <option value="{{$appointCategory->id}}">{{ $appointCategory->name }}</option>
                      @endif
                      
                    @endforeach
                  </select>
                  @if($errors->has('appointment_category_id'))
                      <label class="error mt-2 text-danger">{{ $errors->first('appointment_category_id') }}</label>
                  @endif
                </div>
              
              <div class="form-group">
                <label>Start Date</label>
                <input type="text" class="form-control datepicker" name="block_from" placeholder="Start Date" value="{{ Carbon\Carbon::parse($block->block_from)->format('d/m/Y')}}" required autocomplete="off">
                @if($errors->has('block_from'))
                      <label class="error mt-2 text-danger">{{ $errors->first('block_from') }}</label>
                  @endif
              </div>

              <div class="form-group">
                <label>End Date</label>
                <input type="text" class="form-control datepicker" name="block_to" placeholder="End Date" value="{{ Carbon\Carbon::parse($block->block_to)->format('d/m/Y') }}" required autocomplete="off">
                @if($errors->has('block_to'))
                      <label class="error mt-2 text-danger">{{ $errors->first('block_to') }}</label>
                  @endif
              </div>

              <input class="btn btn-primary" type="submit" value="Save">
               
            </div>
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
    
  });

</script>

@endsection