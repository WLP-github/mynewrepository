@extends('admin.layouts.master')

@section('plugin-css')

@endsection

@section ('container')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
          <h4 class="card-title">Token Slot List</h4>

          <nav aria-label="breadcrumb" class="mb-1">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="{{ route('admin.index') }}">Dashboard</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">tokens</li>
            </ol>
          </nav>
        </div>
        <form action="{{ route("search_token") }}" method="GET">
          <div class="row">
            <div class="col col-md-3">
              <div class="form-group">
                <select name="app_cat_id" id="" class="form-control">
                  <option value="">Choose Appointment Type</option>
                  @foreach ($apCategories as $index=>$apCategorie)
                    @if ($apCategorie->id == request("app_cat_id"))
                      <option value="{{$apCategorie->id}}" selected>{{$apCategorie->name}}</option>
                    @else
                      <option value="{{$apCategorie->id}}">{{$apCategorie->name}}</option>
                    @endif
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
              <input type="text" name="daterangepicker" value="{{ request("daterangepicker") }}" class="form-control" autocomplete="off">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <select name="slot_id" id="" class="form-control">
                  <option value="">Appointment Type</option>
                  @foreach ($slots as $index=>$slot)
                    @if ($slot->id == request("slot_id"))
                    <option value="{{$slot->id}}" selected>{{$slot->name}}</option>
                    @endif
                    <option value="{{$slot->id}}">{{$slot->name}}</option>
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
                    <th>App Dept Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Limit Qty</th>
                    <th>Booked Qty</th>
                    <th>Available<br> Qty</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($tokens as $index => $token)
                  <tr>
                    <td class="text-right">{{ $index + 1}}</td><td>
                      <label for="">{{$token->AppCatName->name}}</label>
                    </td>
                    <td>{{ Carbon\Carbon::parse($token->date)->format('(d/D)-M-Y') }}</td>
                    <td>
                      <label for="">{{$token->TimeSlot->name}}</label>
                    </td>
                  <td class="edit text-right" date="{{$token->date}}" app_cat_id="{{$token->appointment_category_id}}" slot_id="{{$token->slot_id}}">
                      <label>{{ $token->limit_qty }}</label>
                    </td>
                    <td>
                      <label>{{ $token->booked_qty }}</label>
                    </td>
                    <td>
                      <label>{{ $token->available_qty }}</label>
                    </td>
                    <td class="text-right">

                      @if ((auth()->user()->department_id == $token->AppCatName->department_id) || (auth()->user()->role_id == 1))
                        <form action="{{ route('admin.tokens.destroy', ['date'=>$token->date, 'app_cat_id'=>$token->appointment_category_id, 'slot_id'=>$token->slot_id]) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                        <button class="btn btn-icons btn-light delete" data-date="{{$token->date}}" onclick="return confirm('Are Your Sure want to delete.')" data-app-cat-id="{{$token->appointment_category_id}}" data-slot-id="{{$token->slot_id}}">
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
            {{ $tokens->appends($_GET)->links() }}
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

      $('input[name="daterangepicker"]').daterangepicker({
        timePicker: false,
        StartDate: 2019,
        Endate: parseInt(moment().format('YYYY'),10),
        locale: {
          format: 'DD/MM/YYYY'
        }
      });

      $(document).on("dblclick", "td.edit", function(){ makeEditable(this); });

      $(document).on("blur", "input#editbox", function(){ removeEditable(this) });

      $(document).on("keypress", "input#editbox", function(e){
        var key = e.which;
        if(key == 13)
         removeEditable(this) 
      });

      // $(selector).keypress(function (e) { 
        
      // });

  });

  function removeEditable(element) {
    
    var date = $('.current').attr('date');
    var app_cat_id = $('.current').attr('app_cat_id');
    var slot_id = $('.current').attr('slot_id');
    var newLimit = $(element).val();

    $.ajax({
      url : "{!! route('update_token_limit') !!}",
      type : "POST",
      data : { 
        "date" : date, 
        "app_cat_id" : app_cat_id, 
        "slot_id" : slot_id, 
        "limit_amount" : newLimit,
        "_token" : "{{ csrf_token() }}" 
      },
      success : function(data){
        $('.current').removeClass('current');   
        setTimeout(function(){// wait for 5 secs(2)
            location.reload(); // then reload the page.(3)
        }, 100); 
      },
      error: function(){
        alert("Error occurs, you may be unauthorized to update data.");
          setTimeout(function(){// wait for 5 secs(2)
              location.reload(); // then reload the page.(3)
          }, 100); 
      }
    });  

  }

  function makeEditable(element) {

    $(element).html('<input id="editbox" type="text" class="form-control" style="width:100px" value="'+ $(element).text().trim() +'">');  
    $('#editbox').focus();
    $(element).addClass('current').removeClass('edit');

  }
</script>
@endsection