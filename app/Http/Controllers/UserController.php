<?php

namespace FDA\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use FDA\User;
use Illuminate\Support\Facades\Hash;
use FDA\Appointment;
use FDA\AppointmentCategory;

class UserController extends Controller
{
    use AuthenticatesUsers;
    
    public function UserProfile(Request $request){
        $getUser = Auth::user();
        $user = User::find($getUser->id);
        Validator::make($request->all(), [
            'name' => 'required|string',
            'company_name' => 'required',
            'company_phone_no' => ['required', 'min:6', 'max:11'],
            'applicant_name' => 'required',
            'applicant_phone_no' => ['required', 'min:6', 'max:11'],
            'applicant_nrc' => ['required', 'unique:users'],
        ]);
        
        $user->name= $request['name'];
        $user->company_name = $request['company_name'];
        $user->company_phone_no = $request['company_phone_no'];
        $user->applicant_name = $request['applicant_name'];
        $user->applicant_phone_no = $request['applicant_phone_no'];
        $user->applicant_nrc = $request['nrc'];
        // dd($user->company_name);
        $user->save();
        
        return redirect('/profile')->with('success', "Your profile was successfully updated.");
    }

    public function changePassword(){
        return view('users.user-change-pw');
    }

    public function updatePassword(Request $request){
        Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => ['required', 'min:6', 'different:old_password'],
            'confirm_password' => ['required_with:password', 'same:password', 'min:6']
        ])->validate();
        
        $data = $request->all();
        // dd($data);
        $user = auth()->user();
        if (!Hash::check($data['old_password'], auth()->user()->password)) 
        {
            return back()->with('danger', 'The specified password does not match the database password');
        } 
        else 
        {
            // write code to update password
            $user->update([
                'password' => bcrypt($request->password) ,
            ]);
        }
        return redirect('/profile')->with('success', "Your password has been successfully updated.");
    }

    public function booking(Appointment $appointment){
        $appCatLists = AppointmentCategory::all();
        $appointment = $appointment->newQuery();

        if (request("app_cat_id") != "") {
            $appointment->where('appointment_category_id', request("app_cat_id"));
        }

        if(request("app_date")!=""){
            $appointment->where('appointment_date', date("Y-m-d", strtotime(request("app_date"))));
        }

        $appointment = $appointment->where("user_id", auth()->user()->id);
        $userBookLists = $appointment->with(["slot", "appointmentCategory"])->orderBy('appointment_date', 'desc')
            ->paginate(20);
        return view('users.user_booking', compact('userBookLists', 'appCatLists'));
    }

}
