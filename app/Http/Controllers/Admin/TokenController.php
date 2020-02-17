<?php

namespace FDA\Http\Controllers\Admin;

use FDA\Token;
use Illuminate\Http\Request;
use FDA\Http\Controllers\Controller;
use FDA\AppointmentType;
use Carbon\Carbon;
use FDA\AppointmentCategory;
use Calendar;
use FDA\Slot;
use Illuminate\Support\Facades\DB;

class TokenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slots = Slot::all();
        $apCategories = AppointmentCategory::all();
        $tokens = Token::with(['TimeSlot', 'AppCatName'])->orderBy('appointment_category_id', 'asc')
            ->orderBy('date', 'desc')
            ->paginate(30);
        return view('admin.tokens.index', compact('tokens', 'apCategories', 'slots'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $AppointmentCategories = AppointmentCategory::all();

        return view('admin.tokens.create',compact('AppointmentCategories'));
    }

    public function addTokenLimitForm(Request $request)
    {
        $roleId = auth()->user()->role_id == 1 ? true : false;

        $userDeptId =  auth()->user()->department_id;

        $appointmentCategory = AppointmentCategory::find($request->appointment_category_id);

        $appCatDepId = $appointmentCategory->department_id == $userDeptId ? true : false;
        
        // dd($roleId.$appCatDepId);

        if($roleId || $appCatDepId){

            $dates = null;
            // dd($request->all());
            $slotId = $request->slot_id;

            if ($appointmentCategory->department_id == 3) $appointmentCategory->id = 4; //4 is appointment category id of grouping and 3 is dept of grouping

            $lastTokenSlot = Token::orderBy('date', 'desc')->where([
                ['appointment_category_id',$appointmentCategory->id],
                ['slot_id', $slotId]
            ])->first();
            
            $lastTokenDate = $lastTokenSlot ? $lastTokenSlot->date : now();

            $start_date = Carbon::parse($lastTokenDate)->addWeek()->startOfWeek();

            $end_date = Carbon::parse($lastTokenDate)->addWeek()->endOfWeek()->subDays(2);

            for ($date = $start_date; $date->lte($end_date); $date->addDay()) {
                $dates[] = $date->format('Y-m-d');
            }

            //calendar data
            $events = [];
            $data = Token::where([
                ['appointment_category_id', $appointmentCategory->id],
                ['slot_id', $slotId]
            ])->get();
            if($data->count()) {
                foreach ($data as $key => $value) {
                    $dateRange = date("d/m/Y", strtotime($value->date));
                    $events[] = Calendar::event(
                        $value->limit_qty."/". $value->booked_qty,
                        true,
                        new \DateTime($value->date),
                        new \DateTime($value->date.' +1 day'),
                        $value->id,
                        // Add color and link on event
                        [
                            'color' => '#555555',
                            'url' => 'tokens/datesearch?app_cat_id='.$value->appointment_category_id.'&date_range_picker='.$dateRange." - ".$dateRange.'&slot_id='.$value->slot_id,
                        ]
                    );
                }
            }
            $calendar = Calendar::addEvents($events);
            // end calendar event
            return view('admin.tokens.add-token-limit',compact('dates', 'appointmentCategory', 'slotId', 'calendar'));
        }
        return back()->with('warning', "You are not authorized to access page.");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $slots = Slot::all();
        $apCategories = AppointmentCategory::all();
        $data['slot_id'] = $request->slot_id;
        foreach ($request->dates as $key => $date) {

            $data['date'] = $date;
            $data['limit_qty'] = $request->limit_amount[$key];
            $data['available_qty'] = $request->limit_amount[$key];
            $data['appointment_category_id'] = $request->appointment_category_id;
            $data['created_by'] = auth()->user()->id;
            $data['updated_by'] = "";
            try {
                Token::create($data);
            } catch (\Throwable $th) {
                return redirect('admin/tokens')->with('info', 'already inserted');
            }
            
        }
        $tokens = Token::orderBy('date','desc')->paginate(30);
        return back()->with('success', 'Token added successfully');
        // return view('admin.tokens.index', compact('tokens', 'apCategories', 'slots'))->with('success', 'Token added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \FDA\Token  $token
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        list($startDate, $endDate) = explode(' - ', $request->date_range_picker);// split into array from daterangepicker
        
        list($day, $month, $year) = explode('/', $startDate);
        // dd($day);
        $dateRange = $request->date_range_picker;
        $apCategories = AppointmentCategory::all(); //get all data from appointmentcategory table
        $slots = Slot::all(); // get all data from slot table

        $tokens = Token::orderBy('date', 'asc')
            ->where([
                ['appointment_category_id', $request->app_cat_id],
                ['slot_id', $request->slot_id],
                ['date', '>=', $year . "-" . $month . "-" . $day], // change date format like Y-d-m bcoz date fun return like Y-d-m format
                ['date', '<=', $year . "-" . $month . "-" . $day]
            ])->paginate(30);

        return view('admin.tokens.index', compact('tokens', 'apCategories', 'slots', 'dateRange'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \FDA\Token  $token
     * @return \Illuminate\Http\Response
     */
    public function edit(Token $token)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \FDA\Token  $token
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Token $token)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \FDA\Token  $token
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $date)
    {
        // dd($date);
        $token_delete = DB::table('tokens')->where([
            ['date', $date],
            ['appointment_category_id', $request->app_cat_id],
            ['slot_id', $request->slot_id]
        ])->delete();
        // dd($token_delete);
        if($token_delete){
            return back()->with('info', 'Successfully deleted.');
        }else{
            return back()->with('danger', 'Error to delete.');
        }
        return back();
    }

    public function search(Request $request)
    {
        // dd($request->all());
        list($startDate, $endDate) = explode(' - ', $request->daterangepicker); // split into array from daterangepicker
        list($startDay, $startMonth, $startYear) = explode('/', $startDate);
        list($endDay, $endMonth, $endYear) = explode('/', $endDate);
        $dateRange = $request->daterangepicker;
        $startDate = $startYear . "-" . $startMonth . "-" . $startDay;
        $endDate = $endYear . "-" . $endMonth . "-" . $endDay;
        $apCategories = AppointmentCategory::all(); //get all data from appointmentcategory table
        $slots = Slot::all(); // get all data from slot table

        if ($request->app_cat_id == "" && $request->slot_id == "") {
            $tokens = Token::with(['TimeSlot', 'AppCatName'])
                ->orderBy('date', 'asc')
                ->where([
                    ['date', '>=', $startDate], // change date format like Y-d-m bcoz date fun return like Y-d-m format
                    ['date', '<=', $endDate]
                ])->paginate(30);
        } elseif ($request->app_cat_id == "") {
            $tokens = Token::with(['TimeSlot', 'AppCatName'])
                ->orderBy('date', 'asc')
                ->where([
                    ['slot_id', $request->slot_id],
                    ['date', '>=', $startDate], // change date format like Y-d-m bcoz date fun return like Y-d-m format
                    ['date', '<=', $endDate]
                ])->paginate(30);
        } elseif ($request->slot_id == "") {
            $tokens = Token::with(['TimeSlot', 'AppCatName'])
                ->orderBy('date', 'asc')
                ->where([
                    ['appointment_category_id', $request->app_cat_id],
                    ['date', '>=', $startDate], // change date format like Y-d-m bcoz date fun return like Y-d-m format
                    ['date', '<=', $endDate]
                ])->paginate(30);
        } else {
            $tokens = Token::with(['TimeSlot', 'AppCatName'])
                ->orderBy('date', 'asc')
                ->where([
                    ['appointment_category_id', $request->app_cat_id],
                    ['slot_id', $request->slot_id],
                    ['date', '>=', $startDate], // change date format like Y-d-m bcoz date fun return like Y-d-m format
                    ['date', '<=', $endDate]
                ])->paginate(30);
        }
        return view('admin.tokens.index', compact('tokens', 'apCategories', 'slots', 'dateRange'));
    }

    public function updateTokenLimit(Request $request)
    {
        $roleId = auth()->user()->role_id == 1 ? true : false;

        $userDeptId =  auth()->user()->department_id;

        $appointmentCategory = AppointmentCategory::find($request->app_cat_id);

        $appCatDepId = $appointmentCategory->department_id == $userDeptId ? true : false;

        if($roleId || $appCatDepId){

            $token = Token::where([
                ['date', $request->date],
                ['appointment_category_id', $request->app_cat_id],
                ['slot_id', $request->slot_id]
            ])->first();
            
            $available_qty = $request->limit_amount - $token->booked_qty;
            if ($available_qty < 0) {
                return response(false);
            }
            
            $status = Token::where([
                ['date', $request->date],
                ['appointment_category_id', $request->app_cat_id],
                ['slot_id', $request->slot_id]
            ])->update([
                'limit_qty' => $request->limit_amount,
                'available_qty' => $available_qty
            ]);
            if($status){
                return response($token);
            }
            return redirect('admin/tokens/index')->with('info', 'Error to update');
    

        }
        return response(false);
    }

    public function getTimeSlot(Request $request){
        $time_slot = AppointmentCategory::select('slot_id')->where('id', $request->cat_type)->get();

        return response()->json($time_slot);
    }
}
