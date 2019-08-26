<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Calendar;

class CalendarController extends Controller
{
    public function newCalendar(Request $request) {
        Calendar::create([
            'year' => $request->year,
            'term' => $request->term,
            'date' => $request->date
        ]);
        return $this->response->noContent();
    }

    public function deleteCalendar($year, $term) {
        Calendar::where(['year' => $year, 'term' => $term])->delete();
        return $this->response->noContent();
    }

    public function updateCalendar($year, $term, Request $request) {
        Calendar::where(['year' => $year, 'term' => $term])->first()
            ->update([
                'date' => $request->date,
            ]);
        return $this->response->noContent();
    }

    public function showCalendar($year=0,$term=0) {
        if ($year && $term) $calendars=Calendar::where('year',$year)->where('term',$term)->get();
        else $calendars=Calendar::all();
        return $this->response->array($calendars->toArray());
    }
}
