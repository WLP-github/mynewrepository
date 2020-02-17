<?php

namespace FDA\Http\Controllers\Admin;

use FDA\User;
use Illuminate\Http\Request;
use FDA\Http\Controllers\Controller;
use FDA\Appointment;
use FDA\AppointmentCategory;
use FDA\Block;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::where('role', '99')->count(); // front-end users lists

        if (auth()->user()->role_id === 1) {

            $blockUsers = Block::where([
                ['block_to', '>=', date("Y-m-d", strtotime("today"))]
            ])->count();

            $cancelEmails = Appointment::where([
                ['is_cancel', '1'],
                ['status', '1']
            ])->count();
        }else{

            $app_cat_id = AppointmentCategory::where([
                ['department_id', auth()->user()->department_id]
            ])->pluck('id');

            $blockUsers = Block::whereIn('appointment_category_id', $app_cat_id->toArray())
                ->where([
                    ['block_to', '>=', date("Y-m-d", strtotime("today"))]
                ])->count();
            

            $cancelEmails = Appointment::whereIn('appointment_category_id', $app_cat_id->toArray())
            ->where([
                ['is_cancel', '1'],
                ['status', '1']
                ])->count();

        }

        return view('admin.dashboard', compact('users', 'cancelEmails', 'blockUsers'));
    }
    
}
