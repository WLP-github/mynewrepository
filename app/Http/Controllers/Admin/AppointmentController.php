<?php

namespace FDA\Http\Controllers\Admin;

use Illuminate\Http\Request;
use FDA\Http\Controllers\Controller;
use FDA\Appointment;
use FDA\AppointmentCategory;
use FDA\Token;
use FDA\User;
use FDA\Exports\ExportAppointment;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Appointment $appCat)
    {
        $appCatLists = AppointmentCategory::all();
        $appCat = $appCat->newQuery();

        // Search for appointment list based on their company registration id.
        if (request('company_registration_no') != "") {
            $user = User::where([
                ['company_registration_no', request()->company_registration_no]
            ])->first();
            if ($user) {
                $appCat->where('user_id', $user->id);
            }
        }

        // Search for appointment list based on their app type.
        if (request('app_cat_id') != "") {
            $appCat->where('appointment_category_id', request()->input('app_cat_id'));
        }

        if (request('app_date') != "") {
            $appCat->where('appointment_date', date("Y-m-d", strtotime(request("app_date"))));
        }

        $appCat->where('status', 1);

        $app_cat_id = AppointmentCategory::where([['department_id', auth()->user()->department_id]])->pluck('id'); //get appointment categories by department

        if (auth()->user()->role_id != 1) {
            $appCat->whereIn('appointment_category_id', $app_cat_id->toArray());
        }
        
        $appLists = $appCat->with(["slot", "appointmentCategory", "appUser"])->orderBy('appointment_date', 'desc')->paginate(10); //get appointment list auth user's app cats of department

        return view("admin.appointment.index", compact("appLists", "appCatLists"));
    }

    public function cancel(Appointment $appCat)
    {
        $appCatLists = AppointmentCategory::all();
        $appCat = $appCat->newQuery();

        // Search for appointment list based on their company registration id.
        if (request('company_registration_no') != "") {
            $user = User::where([
                ['company_registration_no', request()->company_registration_no]
            ])->first();
            if ($user) {
                $appCat->where('user_id', $user->id);
            }
        }

        // Search for appointment list based on their app type.
        if (request('app_cat_id') != "") {

            $appCat->where('appointment_category_id', request()->input('app_cat_id'));
        }
        $appCat->where('is_cancel', 1);

        $appCat->where('status', 1);

        $app_cat_id = AppointmentCategory::where([['department_id', auth()->user()->department_id]])->pluck('id'); //get appointment categories by department

        if (auth()->user()->role_id != 1) {

            $appCat->whereIn('appointment_category_id', $app_cat_id->toArray());
        }

        $appLists = $appCat->with(["slot", "appointmentCategory", "appUser"])->orderBy('appointment_date', 'desc')->paginate(20);

        return view("admin.appointment.cancel", compact("appLists", "appCatLists"));
    }

    public function appointmentCancel($id)
    {
        $appointment = Appointment::find($id);
        $appointmentDate = $appointment->appointment_date;
        $appointmentCatId = $appointment->appointment_category_id;
        if ($appointmentCatId == 4 || $appointmentCatId == 6) $appointmentCatId = 4;
        $appointmentTimeSlot = $appointment->slot_id;
        $appointmentItemAmount = $appointment->item_amount;
        $appDepartmentId = $appointment->appointmentCategory->department_id;
        $token = Token::where([
            ["date", $appointmentDate],
            ["appointment_category_id", $appointmentCatId],
            ["slot_id", $appointmentTimeSlot]
        ])->first();
        // dd($token);
        $availableQty = $token->available_qty;
        $bookedQty = $token->booked_qty;
        // $today = date("Y-m-d", strtotime("today"));
        $cancelWeek = date("Y-m-d", strtotime("+2 weeks", strtotime("this week"))); //this week (Mon date of this week)

        if ($appointmentDate >= $cancelWeek) {
            if ($appDepartmentId == 3) { /// department is grouping
                $availableQty = $availableQty + 1;
                $bookedQty = $bookedQty - 1;
            } else {
                $availableQty = $availableQty + $appointmentItemAmount;
                $bookedQty = $bookedQty - $appointmentItemAmount;
            }
            if ($bookedQty < 0) {
                return back()->with('error', 'Error Occurs to cancel');
            }
            $appointment->status = 0;
            $appointment->canceled_by = auth()->user()->id;
            $appointment->save();
            Token::where([
                ["date", $appointmentDate],
                ["appointment_category_id", $appointmentCatId],
                ["slot_id", $appointmentTimeSlot]
            ])
                ->update(['booked_qty' => $bookedQty, 'available_qty' => $availableQty, 'updated_by' => auth()->user()->id]); // update token

            return redirect()->route('appointment_cancel')->with('success', 'Successfully cancel.');
        }
        return redirect()->route('appointment_cancel')->with('warning', '!Fail. Cancel date expire or something wrong.');
    }

    public function appointmentSearch(Request $request)
    {
        $appCatLists = AppointmentCategory::all();
        if ($request->company_registration_no != "") {
            $user = User::where([
                ['company_registration_no', $request->company_registration_no]
            ])->first();
            // dd($user);
            if ($user->count()) {

                $appLists = Appointment::where([
                    ['user_id', $user->id],
                    ['appointment_category_id', $request->app_cat_id],
                    ['is_cancel', $request->is_cancel]
                ])->get();
                return view("admin.appointment.index", compact("appLists", "appCatLists"));
            }
        }
        $appLists = Appointment::all();
        return view("admin.appointment.index", compact("appLists", "appCatLists"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    { }

    public function export(){
        // dd(request("app_date"));
        return Excel::download(new ExportAppointment(request("app_date"), request("app_cat_id")), 'appointment.xlsx');
    }

    public function view(): View
    {
        return view('exports.invoices', [
            'invoices' => Invoice::all()
        ]);
    }
}
