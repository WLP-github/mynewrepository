<?php

namespace FDA\Exports;

use FDA\Appointment;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportAppointment implements FromCollection
{
    public $app_date, $app_cat_id;

    function __construct($a, $b){
        $this->app_date = $a;
        $this->app_cat_id = $b;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $appCat = new Appointment();
        $appCat = $appCat->newQuery();
        if ($this->app_cat_id != "") {
            $appCat->where('appointment_category_id', $this->app_cat_id);
        }

        if ($this->app_date != "") {
            $appCat->where('appointment_date', date("Y-m-d", strtotime($this->app_date)));
        }

        $appCat->where('status', 1);
        // dd($this->app_cat_id);
        return $appCat->orderBy('appointment_date', 'desc')->get();

    }
}
