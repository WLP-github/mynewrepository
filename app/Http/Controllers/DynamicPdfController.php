<?php

namespace FDA\Http\Controllers;

use FDA\Appointment;
use PDF;

class DynamicPdfController extends Controller
{
    public function exportPdf($id){
        $appList = Appointment::find($id);
        $data['app_cat_name'] = $appList->appointmentCategory->name;
        $data['app_cat_short_name'] = $appList->appointmentCategory->short_name;
        $data['time'] = $appList->slot->name;
        $data['date'] = $appList->appointment_date;
        $data['brand_name'] = $appList->brand_name;
        $data['item_amonut'] = $appList->item_amount;
        $user = auth()->user();
        $data['company_name'] = $user->company_name;
        $data['company_registration_no'] = $user->company_registration_no;
        $data['applicant_name'] = $user->applicant_name;
        $data['applicant_phone_no'] = $user->applicant_phone_no;
        $data['applicant_nrc'] = $user->applicant_nrc;
        $data['department_id'] = $appList->appointmentCategory->department_id;

        // $appLists = Appointment::where([
        //     ['appointment_date', $appList->appointment_date],
        //     ['appointment_category_id', $appList->appointment_category_id],
        //     ['slot_id', $appList->slot_id]
        // ])->get();

        $data['token_no'] = $appList->appointment_id;
        // return view('pdf.appointment_pdf', compact('data'));
        $pdf = PDF::loadView('pdf.appointment_pdf', compact('data'));
        return $pdf->stream();
        return $pdf->download('AppointmentPdf('.$data['app_cat_short_name'].'-'.$data['date'].').pdf');
    }

}
