@extends('admin.layouts.app')

@section('content')
<div class="container-fluid page-body-wrapper full-page-wrapper">
  <div class="content-wrapper d-flex align-items-center auth auth-bg-2 theme-one">
    <div class="row w-100">
      <div class="col-lg-4 mx-auto">
        <div class="auto-form-wrapper">
          <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="form-group">
              <label class="label">Email</label>

              <div class="input-group has-danger">
                <input type="email" class="form-control {{ $errors->has('email') ? 'border-danger': '' }}" 
                  name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
                <div class="input-group-append">
                  <span class="input-group-text">
                    <i class="mdi mdi-check-circle-outline"></i>
                  </span>
                </div>
              </div>

              @if ($errors->has('email'))
                <label class="error mt-2 text-danger" for="email">
                  {{ $errors->first('email') }}
                </label>
              @endif
            </div>
            
            <!-- Password -->
            <div class="form-group">
              <label class="label">Password</label>

              <div class="input-group">
                <input type="password" class="form-control {{ $errors->has('email') ? 'border-danger': '' }}" 
                  name="password" placeholder="*********" required>
                <div class="input-group-append">
                  <span class="input-group-text">
                    <i class="mdi mdi-check-circle-outline"></i>
                  </span>
                </div>
              </div>

              @if ($errors->has('password'))
                <label class="error mt-2 text-danger" for="password">
                  {{ $errors->first('password') }}
                </label>
              @endif
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-primary submit-btn btn-block">Login</button>
            </div>

          </form>
        </div>
        
        <ul class="auth-footer">
          
        </ul>
        <p class="footer-text text-center">Copyright © {{ date('Y') }} </p>
        <p class="footer-text text-center">FOOD AND DRUG ADMINISTRATION DEPARTMENT,</p>
        <p class="footer-text text-center">All Right Reserved.</p>
      </div>
    </div>
  </div>
  <!-- content-wrapper ends -->
</div>
@endsection