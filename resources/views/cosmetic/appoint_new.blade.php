@extends('layouts.master')

@section('content')
    <div class="divider-custom">
        <div class="divider-custom-line"></div>
        <div class="divider-custom-icon">
            Online Booking
        </div>
        <div class="divider-custom-line"></div>
    </div>
    @php
        $user = Auth::user();
    @endphp
    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">{{ __('Online Appointment Application Form
                            ') }}</div>
                            <div class="card-body">
                                <fieldset {{ $status }}>
                                <form method="POST" action="{{ route('cosmetic.appoint_new') }}">
                                    @csrf
                                    <div class="row">
                                        {{-- app type --}}
                                       
                                        <div class="form-group col-md-6">
                                            <label for="app_type" class="control-label text-md-right">{{ __('Application Type') }}</label>
                                            <select name="appointment_category_id" id="cat_type" class="form-control{{ $errors->has('app_type') ? ' is-invalid' : '' }}"  autofocus>
                                                @foreach ($deptIds as $deptId)
                                                    <option value="{{$deptId->id}}">{{$deptId->name}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        {{-- email --}}
                                        
                                        <div class="col-md-6">
                                            <label for="date" class="control-label">{{ __('Available Date') }}</label>
                                            <input id="selector" type="text" class="form-control" name="appointment_date" autocomplete="off" readonly required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        {{-- Time --}}
                                        <div class="form-group col-md-6">
                                            <label for="avatime" class="control-label text-md-right">{{ __('Available Time') }}</label>
                                            <select name="slot_id" id="ava_time" class="form-control" required>
                                            </select>
            
                                        </div>
                                        {{-- item --}}
                                        <div class="col-md-6">
                                            <label for="item" class="control-label">{{ __('Choose Number Of Item') }}</label>
                                            @if ($dId == 3)
                                                <input type="number" name="item_amount" class="form-control" required>
                                            @else
                                                <select name="item_amount" id="item" class="form-control" required>
                                                </select>
                                            @endif
                                            <span id="item_msg" role="alert">
                                                <strong class="text-danger"></strong>
                                            </span>
                                        </div>
                                       
                                    </div>
                                    <div class="row">
                                        {{-- Brand Name --}}
                                        <div class="form-group col-md-6">
                                            <label for="brand_name" class="control-label text-md-right">{{ __('Brand Name') }}</label>
                                            <input type="text" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" name="brand_name" value="{{ old('brand_name') }}" required>
                                            @if ($errors->has('brand_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('brand_name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        {{-- Company Registration No --}}
                                        <div class="col-md-6">
                                            <label for="company_regno" class="control-label text-md-right">{{ __('Company Registration No') }}</label>
                                            <input type="text" class="form-control" name="company_regno" value="{{ $user->company_registration_no }}" readonly required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        {{-- Company Name --}}
                                        <div class="form-group col-md-6">
                                            <label for="company_name" class="control-label text-md-right">{{ __('Company Name') }}</label>
                                            <input type="text" class="form-control" name="company_name" value="{{ $user->company_name }}" readonly required>
                                        </div>
                                        {{-- Applicant Name --}}
                                        <div class="col-md-6">
                                            <label for="applicant_name" class="control-label text-md-right">{{ __('Applicant Name') }}</label>
                                            <input type="text" class="form-control" name="applicant_name" value="{{ $user->applicant_name }}" readonly required>
                                            
                                        </div>
                                    </div>
                                    <div class="row">
                                        {{-- Applicatn Nrc --}}
                                        <div class="form-group col-md-6">
                                            <label for="applicant_nrc" class="control-label text-md-right">{{ __('Applicant NRC') }}</label>
                                            <input type="text" class="form-control" name="applicant_nrc" value="{{ $user->applicant_nrc }}" readonly required>
                                        </div>
                                        {{-- Phone No --}}
                                        <div class="col-md-6">
                                            <label for="applicant_phoneno" class="control-label text-md-right">{{ __('Applicant Phone No') }}</label>
                                            <input type="text" class="form-control" name="applicant_phoneno" value="{{ $user->applicant_phone_no }}" readonly required>
                                            
                                        </div>
                                        <input type="hidden" name="deptId" id="deptartmentId" value={{$dId}}>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-md-12 text-center">
                                        <!-- show captcha image html -->
                                            {!! 
                                                app('captcha')->render();
                                            !!}
                                        </div>
                                        @if ($errors->has('g-recaptcha-response'))
                                            <span class="invalid-feedback" style="display: block;">
                                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-md-12 text-center">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Submit') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
    $(function(){
        // page ready

        selectAppCatType($("#cat_type").val());
        // on change
        $('select[name="appointment_category_id"]').on('change',function(){
            selectAppCatType(this.value);
            $("#ava_time").empty();
            $("#selector").val("");
            $("select[name=item_amount]").html("");
        });

        $("#ava_time").on("change", function () { 
            $("select[name=item_amount]").empty();
            getAvailableItem(this.value);
            
        });

        var count = 0;
        $("#selector").change(function (e) {
            count +=1;
            e.preventDefault();
            $("select[name=item_amount]").empty();
            // alert(count);
            if(count > 1){
                $("select[name=slot_id]").val("-1").change();
            }

        });
    });
    function selectAppCatType(cat_type){
        $( "#selector" ).datepicker( "destroy" );
        var deptId = $("#deptartmentId").val();

        if(cat_type) {
            $.ajax({
            url: "{!! url('catTypeAjax') !!}",
            type: "GET",
            cache: false,
            data: {
                "cat_type" : cat_type,
                "dept_id" : deptId,
                },
                success:function(data){
                    // console.log(data);
                    var disableddates="";
                    var slot_name="";
                    
                    // for time slot
                    var time_slots=$.map(data[1], function(value, index){
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
                    $('select[name=slot_id]').prepend('<option value="-1" selected>Choose Time Slot</option>');

                    // for datepicker to filter dates 
                    // console.log(time_slots.length);
                    if(data[0] == null){
                        $("#selector").datepicker({
                            showAnim: "fold",
                            showOptions: { direction: "left" },
                            dateFormat: 'dd-mm-yy',
                            maxDate: "0",
                            minDate: "0",
                            beforeShowDay: EnableSpecificDates
                        });
                    }else{
                        var disableddates = $.map(data[0], function(value, index) {
						    return [value.date];
						});
                       
                        $( "#selector" ).datepicker({
                            showAnim: "fold",
                            showOptions: { direction: "left" },
                            dateFormat: 'dd-mm-yy',
                            maxDate: "+2m",
                            minDate: "+2d",
                            beforeShowDay: EnableSpecificDates
                            });
                        // console.log(disableddates);
                       
                    }
                    function EnableSpecificDates(date) {
                        var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                        return [disableddates.indexOf(string) != -1];
                    }
                    
                }
            });
        }
    }

    function getAvailableItem(slotValue){
        var catType = $("#cat_type").val();
        var dateValue = $("#selector").val();
        var deptID = $("#deptartmentId").val();
        if(slotValue){

            $.ajax({
                url: "{!! url('getAvailableItemAjax') !!}",
                type: "get",
                data: {
                    slot_value : slotValue,
                    cat_type : catType,
                    date_value : dateValue,
                    dept_id : deptID
                    },
                dataType : "json",
                    success : function(data){

                        // for availabel qty token
                        var available_qty=$.map(data, function(value, index){
                            return [value.available_qty];
                        });
                        if(available_qty <= 0){
                            $("#item_msg > strong").html("Select fields correctly or choose other datetime.");
                        }
                        for(var i=1; i<=available_qty; i++){
                            $("#item_msg > strong").html("");
                            $("select[name=item_amount]").append("<option value="+i+">"+i+"</option>");
                        }

                    },
                    error : function(){
                        alert("error");
                    }
            });

        }
    }


    </script>
@endsection
