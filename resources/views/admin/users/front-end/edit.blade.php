@extends('admin.layouts.master')

@section('container')
<div class="row grid-margin">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
          <h4 class="card-title">Edit User</h4>

          <nav aria-label="breadcrumb" class="mb-1">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="{{ route('admin.index') }}">Dashboard</a>
              </li>
              <li class="breadcrumb-item">
                <a href="{{ route('admin.front_end_users.index') }}">Front-End Users</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
          </nav>
        </div>

        <form method="POST" action="{{ route('admin.front_end_users.update', $user) }}">
          @csrf
          @method('PATCH')

          <fieldset>

            <!-- name -->
            <div class="form-group">
              <label for="">User Name</label>
              <input type="text" class="form-control" value="{{$user->name}}" readonly>
            </div>
            <!-- email -->
            <div class="form-group">
              <label for="">User Email</label>
              <input type="text" class="form-control" value="{{$user->email}}" readonly>
            </div>

             <!-- email -->
             <div class="form-group">
              <label for="">Company Registration No</label>
              <input type="text" class="form-control" value="{{$user->company_registration_no}}" readonly>
            </div>
            <input type="hidden" name="user_id" value="{{$user->id}}">
            {{-- status --}}
            <div class="form-group">
              <label for="status">Status</label>
              <select name="status" id="" class="form-control">
                @if ($user->is_active == 0)
                  <option value="0" selected>False</option>
                  <option value="1" >True</option>
                @else
                  <option value="0" >False</option>
                  <option value="1" selected>True</option>
                @endif
              </select>
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

@endsection