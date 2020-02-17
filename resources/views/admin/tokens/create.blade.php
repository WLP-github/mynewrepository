@extends('admin.layouts.master')

@section('container')
<div class="row grid-margin">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
          <h4 class="card-title">Add New Token Slot</h4>

          <nav aria-label="breadcrumb" class="mb-1">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="{{ route('admin.index') }}">Dashboard</a>
              </li>
              <li class="breadcrumb-item">
                <a href="{{ route('admin.tokens.index') }}">Tokens</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">Create</li>
            </ol>
          </nav>
        </div>

        <form method="GET" action="{{ route('add_token_limit_form') }}">
          {{-- @csrf --}}
          <fieldset>

            <div class="row">

              <div class="col col-md-4">
                <!-- Appointment Type -->
                @component('components.selectbox-object')
                  @slot('title', 'Appointment Type *')
                  @slot('name', 'appointment_category_id')
                  @slot('objects', $AppointmentCategories )
                  @slot('selected','')
                @endcomponent
              </div>
            </div>

            <div class="row">
              <div class="col col-md-4">
                  <select name="slot_id" id="ava_time" class="form-control" required>
                  </select>
              </div>
            </div>

            <div class="row">
              <div class="col col-md-4">
                <br>
                <input class="btn btn-primary btn-lg" type="submit" value="Search">
              </div>
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

  selectAppCatType($("#appointment_category_id").val());
  //appointment category onChnage() of Add Token
  $('select[name="appointment_category_id"]').on('change',function(){
  selectAppCatType(this.value);
  $("#ava_time").empty();

  });

function selectAppCatType(cat_type){
  if(cat_type) {
    $.ajax({
    url : "{!! route('get_time_slot') !!}",
    type: "GET",
    cache: false,
    data: {"cat_type" : cat_type},
        success:function(data){
            var slot_name="";
            
            // console.log(data);
            // for time slot
            var time_slots=$.map(data, function(value, index){
                return [value.slot_id];
            });
            for(let time_slot in time_slots){
                var slot = time_slots[time_slot];
                slot = slot.replace(/'/g, '"');
                slot = JSON.parse(slot);
                // console.log(slot);
                if(slot.length != 0){
                    for(let key1 in slot){
                        if(slot[key1] == 1)slot_name="အချိန်( ၉:၀၀ မှ ၁၂:ဝဝ နာရီ အထိ)";
                        else if(slot[key1] == 2)slot_name="အချိန်( ၉:၀၀ မှ ၃:ဝဝ နာရီ အထိ)";
                        else slot_name="နေ့လည်ပိုင်း (၁၃:ဝဝ မှ ၁၅:၃၀ နာရီ အထိ)";
                        $('select[name=slot_id]').prepend('<option value='+slot[key1]+'>'+slot_name+'</option>');
                    }
                } 
            }
            // $('select[name=slot_id]').prepend('<option selected>Choose Time Slot</option>');
        },
        error:function(){
          console.log("error");
        }
    });
  }
}
</script>
@endsection
