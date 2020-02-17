@extends('admin.layouts.master')

@section('plugin-css')

@endsection

@section ('container')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
          <h4 class="card-title">Users</h4>

          <nav aria-label="breadcrumb" class="mb-1">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="{{ route('admin.index') }}">Dashboard</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">Users</li>
            </ol>
          </nav>
        </div>

        <form action="{{ route('admin.users.index') }}" method="GET">
          <div class="row">
            <div class="col col-md-3">
              <div class="form-group">
                <input type="text" class="form-control" name="name" value="{{ request('name') }}" placeholder="Enter User Name">
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
                    <th>Full Name</th>
                    <th>Department</th>
                    <th>User Name</th>
                    <th>User Level</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($users as $index => $user)
                  <tr>
                    <td>{{ $index + 1}}</td>
                    <td>{{ $user->full_name }}</td>
                    <td>{{ optional($user->department)->name }}</td>
                    <td>{{ $user->name }}</td>
                    <td>
                      <label class="badge badge-{{ $user->label() }}">{{ $user->roleUser->name }}</label>
                    </td>
                    <td class="text-right">
                      <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-icons btn-light">
                        <span class="fa fa-edit fa-lg text-primary"></span></a>

                      <form action="{{ route('admin.users.destroy', $user) }}" method="POST" 
                            class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-icons btn-light" onclick="return confirm('Are You Sure?');">
                          <span class="fa fa-trash fa-lg text-danger"></span></button>
                      </form>

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
            {{ $users->appends($_GET)->links() }}
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

@section('plugin-js')

@endsection

@section('custom-js')

<script>
  $(function () {
   

  });
</script>
@endsection