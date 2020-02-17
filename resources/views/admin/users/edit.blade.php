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
                <a href="{{ route('admin.users.index') }}">Users</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
          </nav>
        </div>

        <form method="POST" action="{{ route('admin.users.update', $user) }}">
          @csrf
          @method('PATCH')

          <fieldset>

            @if ($user->id <> auth()->user()->id)
              <!-- Department -->
              @component('components.selectbox-object')
              @slot('title', 'Department *')
              @slot('name', 'department_id')
              @slot('objects', $departments )
              @slot('selected', $user->department_id)
              @endcomponent
            
            @else
              <input type="hidden" name="department_id", value="{{auth()->user()->department_id}}">
            @endif
            
            <!-- full name -->
            @component('components.textbox')
              @slot('title', 'Full Name *')  
              @slot('name', 'full_name')
              @slot('placeholder', 'Enter Full Name')
              @slot('value', isset($user) ? $user->full_name : '')
              @slot('autofocus', 'autofocus')
              @slot('required', 'required')
            @endcomponent

            <!-- name -->
            @component('components.textbox')
              @slot('title', 'Name *')  
              @slot('name', 'name')
              @slot('placeholder', 'Enter Username')
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
              @slot('selected', $user->role_id)
            @endcomponent

            @if(! $user->isUser())
              <!-- password -->
              @component('components.textbox')
                @slot('type', 'password')
                @slot('title', 'Password *')  
                @slot('name', 'password')
                @slot('placeholder', 'Enter Password')
                @slot('value', '')
              @endcomponent

              <!-- confirm password -->
              @component('components.textbox')
                @slot('title', 'Confirm Password *')  
                @slot('name', 'password_confirmation')
                @slot('type', 'password')
                @slot('placeholder', 'Enter Confirm Password')
                @slot('value', '')
              @endcomponent

            @endif

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