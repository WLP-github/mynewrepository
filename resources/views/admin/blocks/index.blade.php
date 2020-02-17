@extends('admin.layouts.master')

@section('plugin-css')

@endsection

@section ('container')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
          <h4 class="card-title">Rejected List</h4>

          <nav aria-label="breadcrumb" class="mb-1">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="{{ route('admin.index') }}">Dashboard</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">rejected list</li>
            </ol>
          </nav>
        </div>

        <form action="{{ route('admin.blocks.index') }}" method="GET">
          <div class="row">
            <div class="col col-md-3">
              <div class="form-group">
                <input type="text" class="form-control" name="company_registration_no" value="{{ request('company_registration_no') }}" placeholder="Enter Company Registration ID">
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
                    <th>Company Name</th>
                    <th>Company ID</th>
                    <th>Category</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Blocked By</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($blocks as $index => $block)
                  <tr>
                    <td>{{ $index + 1}}</td>
                    <td>{{ optional($block->rejectUser)->company_name }}</td>
                    <td>{{ optional($block->rejectUser)->company_registration_no }}</td>
                    <td>{{ optional($block->appointmentCategory)->name }}</td>
                    <td>{{ $block->block_from }}</td>
                    <td>{{ $block->block_to }}</td>
                    <td>{{ optional($block->blockByUser)->name }}</td>
                    <td class="text-right">
                    
                      @if ((auth()->user()->department_id == $block->appointmentCategory->department_id) || (auth()->user()->role_id == 1))
                        <a href="{{ route('admin.blocks.edit', $block) }}" class="btn btn-icons btn-light">
                          <span class="fa fa-edit fa-lg text-primary"></span></a>

                        <form action="{{ route('admin.blocks.destroy', $block) }}" method="POST" 
                              class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-icons btn-light" onclick="return confirm('Are You Sure?');">
                            <span class="fa fa-trash fa-lg text-danger"></span></button>
                        </form>
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
            {{ $blocks->appends($_GET)->links() }}
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