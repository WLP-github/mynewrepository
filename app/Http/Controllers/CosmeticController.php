<?php

namespace FDA\Http\Controllers;

use Illuminate\Http\Request;
use FDA\AppointmentCategory;
use Illuminate\Support\Facades\DB;
use FDA\Token;
use FDA\Appointment;
use FDA\Http\Middleware\BlockUser;
use FDA\Notifications\CancelAppointment;
use FDA\User;
use FDA\Block;
use FDA\Jobs\SendNotiEmail;
use FDA\Rules\Captcha;
use Illuminate\Support\Carbon;

class CosmeticController extends Controller
{
    public function new($dId)
    {
        date_default_timezone_set('Asia/Yangon');
        $deptIds = AppointmentCategory::where('department_id', $dId)->get();
        // $carbon = new Carbon("first day of this week");
        // $start_date = $carbon->addWeeks(3);
        $thisWeek = strtotime("This Week");
        $start = strtotime("+2 Weeks", strtotime("This Week"));
        $end = strtotime("+3 weeks", strtotime("Last Saturday"));
        $date = array();
        $status = "";
        $show = "";
        // while ($start <= $end) {
        //     $date[] = date("Y-m-d", $start);
        //     $availabel_date = DB::table('tokens')->where([
        //         ['date', $date],
        //         ['limit_qty', "<>", '0'],
        //         ['limit_qty', "<>", 'book_qty'],
        //     ])->get();
        //     $start = strtotime("+1 day", $start);
        // }
        // dd($availabel_date);
        $today = strtotime("Today");
        $monday = strtotime("This Week Monday");
        if ($thisWeek < $monday) { // disable for weekend days
            $status = "disabled";
            // $show = "abc";
        } elseif ($today == $monday) {
            $status = date("H") >= 12 ? "" : "disabled"; // disable if today is monday and time is before noon
            // $show = "123";
        }

        // dd([date("Y-m-d",$monday), date("Y-m-d", $thisWeek)]);
        return view('cosmetic.appoint_new', compact('deptIds', 'date', 'status', 'dId'));
    }

    public function getDateByCatType(Request $request)
    { //change calendar for appointment change event
        $time_slot = AppointmentCategory::select('slot_id')->where('id', $request->cat_type)->get();
        date_default_timezone_set('Asia/Yangon');
        $start = strtotime("+2 Days", strtotime("This Week"));
        $end = strtotime("+3 Weeks", strtotime("Last Saturday"));
        if ($request->dept_id == 3) {
            $request->cat_type = 4; //get available qty for grouping as a one department that insert by admin backend add token form(A family)
        }
        if ($request->dept_id == 1) {
            $end = strtotime("+5 weeks", strtotime("Last Saturday"));
        }
        $availabel_date = Token::select('date', 'available_qty')
            ->whereRaw('limit_qty > booked_qty')
            ->where([
                ['appointment_category_id', $request->cat_type],
                ['date', '>=', date("Y-m-d", $start)],
                ['date', '<', date("Y-m-d", $end)],
                ['limit_qty', '<>', '0'],
            ])
            // ->groupBy('date')
            ->get();

        return response()->json(array($availabel_date, $time_slot));
    }

    public function getAvailableItem(Request $request) //change token QTY for time slot change event
    {
        $date = $request->date_value;
        if ($request->dept_id == 3) {
            $request->cat_type = 4; //get available qty for grouping as a one department(A family)
        }
        $availableItem = Token::select('available_qty')
            ->where([
                ['appointment_category_id', $request->cat_type],
                ['date', date("Y-m-d", strtotime($date))],
                ['slot_id', $request->slot_value],
            ])->get();

        $availableItem = Token::select('available_qty')
            ->where([
                ['appointment_category_id', $request->cat_type],
                ['date', date("Y-m-d", strtotime($date))],
                ['slot_id', $request->slot_value],
            ])
            ->get();
        return response()->json($availableItem);
    }

    public function resend()
    {
        return view('cosmetic.appoint_new')->with('id', 1);
    }

    public function cancel($id)
    {
        $app_cat_id = AppointmentCategory::where([['department_id', $id]])->pluck('id');
        $start = strtotime("+2 days", strtotime("today"));
        $user = auth()->user();
        $appBookLists = Appointment::with(["appointmentCategory", "slot"])->whereIn('appointment_category_id', $app_cat_id->toArray())
            ->where([
                ["user_id", $user->id],
                // ["appointment_date", ">=", date("Y-m-d", $start)],
            ])
            ->orderBy('appointment_date', 'desc')
            ->get();
        return view('cosmetic.appoint_cancel', compact('appBookLists'));
    }

    public function cancelAppointment($id)
    {
        $appointment = Appointment::where([ //query for already cancel or not
            ['is_cancel', 0],
            ['id', $id]
        ])->first();
        if ($appointment) {

            $deptId = $appointment->appointmentCategory->department_id; //get department Id by Category Id
            $company_name = $appointment->appUser->company_name;
            $userByDept = User::where([ // get back-end's admin user by department id
                ["department_id", $deptId],
                ["role", 1]
            ])->first();

            $appointment->is_cancel = "1";
            if ($appointment->save()) { // user is empty at user table
                // $job = (new SendNotiEmail())->delay(Carbon::now()->addSeconds(4));
                // dispatch($job);
                if ($deptId == 3) {

                    $appointmentDate = $appointment->appointment_date;
                    $appointmentCatId = $appointment->appointment_category_id;
                    if ($appointmentCatId == 4 || $appointmentCatId == 5 || $appointmentCatId == 6) { //all cat id are used as 4 for token slot dept
                        $appointmentCatId = 4;
                    }
                    $appointmentTimeSlot = $appointment->slot_id;
                    $token = Token::where([
                        ["date", $appointmentDate],
                        ["appointment_category_id", $appointmentCatId],
                        ["slot_id", $appointmentTimeSlot]
                    ])->first();

                    $availableQty = $token->available_qty;
                    $bookedQty = $token->booked_qty;
                    $availableQty = $availableQty + 1;
                    $bookedQty = $bookedQty - 1;
                    if ($bookedQty < 0) {
                        return back()->with('error', 'Error Occurs to cancel your appointment.');
                    }
                    $appointment->status = 0;
                    $appointment->save();

                    Token::where([
                        ["date", $appointmentDate],
                        ["appointment_category_id", $appointmentCatId],
                        ["slot_id", $appointmentTimeSlot]
                    ])
                        ->update(['booked_qty' => $bookedQty, 'available_qty' => $availableQty, 'updated_by' => auth()->user()->id]); // update token

                    return redirect('etoken/cancelAppointmentList/' . $deptId)->with('success', 'Successfully cancel your appointment.');
                } else {

                    if ($userByDept) {

                        $cancelAppointment = new CancelAppointment($id, $company_name, $appointment->appointment_date);
                        $userByDept->notify($cancelAppointment); // send email notification 
                        return redirect('etoken/cancelAppointmentList/' . $deptId)->with('success', 'Cancel notification have been send succcessfully.');
                    }
                }
            }
            return redirect('/')->with('warning', 'Something went wrong, please try again.');
        }
        return redirect('/')->with('warning', 'Something went wrong, please try again.');
    }

    public function store(Request $request)
    {
        $appList = Appointment::where([ // check already book or not
            ['appointment_date', date("Y-m-d", strtotime($request->appointment_date))],
            ['appointment_category_id', $request->appointment_category_id],
            ['user_id', auth()->user()->id],
        ])->first();
        if ($appList) {
            return redirect("/")->with("error", "You were already booked for that date.");
        }
        $validator = $this->validate($request, [
            'appointment_date' => 'required',
            'item_amount' => 'required|digits_between:1,75',
            'slot_id' => 'required',
            'appointment_category_id' => 'required',
            'brand_name' => 'required',
            'g-recaptcha-response' => 'required|captcha',
        ]);
        if ($validator) {
            if ($request->deptId == 3) { // for grouping department appointment
                $app_cat_id = 4; // assign 4 bcoz back-end's system insert as 4 for token slots of grouping department appointment
                // $request->appointment_category_id = 4; //get available qty for grouping as a one department(A family)
            } else {
                $app_cat_id = $request->appointment_category_id;
            }

            $appDate = date("Y-m-d", strtotime($request->appointment_date));
            $availableTokenObj = Token::select(["available_qty", "booked_qty"])
                ->where('date', $appDate)
                ->where('slot_id', $request->slot_id)
                ->where('appointment_category_id', $app_cat_id)
                ->first();
            $availableToken = $availableTokenObj->available_qty;
            $bookedToken = $availableTokenObj->booked_qty;

            if (empty($availableToken)) {
                return redirect()->to("/")->with("error", "The appointment is not available right now.");
            } elseif (($app_cat_id != 4) && ($request->item_amount > $availableToken)) {
                return redirect()->to("/")->with("error", "The token quantity is not available right now.");
            } else {

                $appointment_id = Appointment::where('appointment_date', $appDate)
                    ->where('slot_id', $request->slot_id)
                    ->where('appointment_category_id', $app_cat_id)
                    ->count();

                $appointment = new Appointment();
                $appointment->appointment_id = $appointment_id < 10 ? '00' . ($appointment_id + 1) : '0' . ($appointment_id + 1);
                $appointment->appointment_date = $appDate;
                $appointment->item_amount = $request->item_amount;
                $appointment->slot_id = $request->slot_id;
                $appointment->appointment_category_id = $request->appointment_category_id;
                $appointment->brand_name = $request->brand_name;
                $appointment->user_id = auth()->user()->id;
                $appointment->save(); // insert new appointment

                if ($request->deptId == 3) { // for grouping department appointment
                    $balance_qty = $availableToken - 1;
                    $request->item_amount = 1;
                    $bookedToken += 1;
                } else {
                    $balance_qty = $availableToken - $request->item_amount;
                    $bookedToken =  $bookedToken + $request->item_amount;
                }

                $token = Token::where('date', $appDate)
                    ->where('slot_id', $request->slot_id)
                    ->where('appointment_category_id', $app_cat_id)
                    ->update(['booked_qty' => $bookedToken, 'available_qty' => $balance_qty]); // update token available

                if ($token && $request->item_amount > 15 && $request->deptId != 3) {
                    $blockUser = new Block();
                    $blockUser->user_id = auth()->user()->id;
                    $blockUser->blocked_by = auth()->user()->id;
                    $blockUser->appointment_category_id = $app_cat_id;
                    $blockUser->block_from = date("Y-m-d", strtotime("today"));
                    // $noOfDays = "";
                    if ($request->item_amount <= 50) //block 2 weeks from today date
                        $blockUser->block_to = date("Y-m-d", strtotime("+2 Weeks", strtotime("today")));
                    else //block 3 weeks from today date
                        $blockUser->block_to = date("Y-m-d", strtotime("+3 Weeks", strtotime("today")));
                    $blockUser->save();
                    return redirect()->to("profile/bookingList")->with("success", "You have got token successfully and but you have been block till " . $blockUser->block_to . " by the system. Check your PDF file at below list.");
                }
            }

            return redirect()->to("profile/bookingList")->with("success", "You have got token successfully. Check your PDF file at below list.");
        }
        return back()->with('error', 'something wrong');
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
    {
        //
    }
}
