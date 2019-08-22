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
    }

    public function deleteCalendar($year, $term) {
        Calendar::where(['year' => $year, 'term' => $term])->delete();
    }

    public function updateCalendar($year, $term, Request $request) {
        Calendar::where(['year' => $year, 'term' => $term])->first()
            ->update([
                'year' => $request->year,
                'term' => $request->term,
                'date' => $request->date
            ]);
    }

    public function showCalendar() {
        $calendars=Calendar::all();
        return $this->response->array($calendars->toArray());
    }
}
