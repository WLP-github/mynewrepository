@extends('admin.layouts.master')

@section('container')
<div class="row grid-margin">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
          <h4 class="card-title">Add New User</h4>

          <nav aria-label="breadcrumb" class="mb-1">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="{{ route('admin.index') }}">Dashboard</a>
              </li>
              <li class="breadcrumb-item">
                <a href="{{ route('admin.users.index') }}">Users</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">Create</li>
            </ol>
          </nav>
        </div>

        <form method="POST" action="{{ route('admin.users.store') }}">
          @csrf

          <fieldset>
            <!-- Department -->
            @component('components.selectbox-object')
              @slot('title', 'Department *')
              @slot('name', 'department_id')
              @slot('objects', $departments )
              @slot('selected', '')
            @endcomponent

            <!-- full name -->
            @component('components.textbox')
              @slot('title', 'Full Name *')  
              @slot('name', 'full_name')
              @slot('placeholder', 'Enter Full Name')
              @slot('value', isset($user) ? $user->full_name : '')
              @slot('autofocus', 'autofocus')
              @slot('required', 'required')
            @endcomponent

            <!-- user name -->
            @component('components.textbox')
              @slot('title', 'User Name *')  
              @slot('name', 'name')
              @slot('placeholder', 'Enter User Name')
              @slot('value', isset($user) ? $user->name : '')
              @slot('autofocus', 'autofocus')
              @slot('required', 'required')
            @endcomponent

            <!-- email -->
            @component('components.textbox')
              @slot('type', 'email')
              @slot('title', 'Email *')  
              @slot('name', 'email')
              @slot('placeholder', 'Enter Email')
              @slot('value', isset($user) ? $user->email : '')
              @slot('required', 'required')
            @endcomponent

            <!-- role -->
            @component('components.selectbox-object')
              @slot('title', 'Role *')
              @slot('name', 'role_id')
              @slot('objects', $roles)
              @slot('selected', '')
            @endcomponent

            <!-- password -->
            @component('components.textbox')
              @slot('type', 'password')
              @slot('title', 'Password *')  
              @slot('name', 'password')
              @slot('placeholder', 'Enter Password')
              @slot('value', '')
              @slot('required', 'required')
            @endcomponent

            <!-- confirm password -->
            @component('components.textbox')
              @slot('title', 'Confirm Password *')  
              @slot('name', 'password_confirmation')
              @slot('type', 'password')
              @slot('placeholder', 'Enter Confirm Password')
              @slot('value', '')
              @slot('required', 'required')
            @endcomponent

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