<?php

namespace App\Services;

use App\Lesson;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CalendarServiceForStudent
{
    public function generateCalendarData($weekDays,$request)
    {
      //  dd($weekDays);
        $calendarData = [];
        $timeRange = (new TimeService)->generateTimeRange(config('app.calendar.start_time'), config('app.calendar.end_time'));
    // dd($timeRange);
    $lessons= DB::table('kelex_timetables')
    ->leftJoin('kelex_employees', 'kelex_timetables.EMP_ID', '=', 'kelex_employees.EMP_ID')
    ->leftJoin('kelex_classes', 'kelex_timetables.CLASS_ID', '=', 'kelex_classes.Class_id')
    ->leftJoin('kelex_sections', 'kelex_timetables.SECTION_ID', '=', 'kelex_sections.Section_id')
    ->leftJoin('kelex_subjects', 'kelex_timetables.SUBJECT_ID', '=', 'kelex_subjects.SUBJECT_ID')
    ->where('kelex_timetables.SECTION_ID', '=',Session::get('SECTION_ID'))
    ->where('kelex_timetables.CLASS_ID', '=',Session::get('CLASS_ID'))
    ->where('kelex_sections.CAMPUS_ID', '=', Session::get('CAMPUS_ID'))
    ->select('kelex_classes.*','kelex_employees.*','kelex_timetables.*','kelex_subjects.SUBJECT_NAME')
    ->get();
        // dd($lessons);
        foreach ($timeRange as $time)
        {
            $timeText = $time['start'] . ' - ' . $time['end'];
            $calendarData[$timeText] = [];

            foreach ($weekDays as $index => $day)
            {
                $lesson = $lessons->where('DAY', $index)->where('TIMEFROM', Carbon::parse($time['start'])->format('H:i:s'))->first();
            // dd($lesson);
            
                if ($lesson)
                { 
                 $difference = Carbon::parse($lesson->TIMEFROM)->diffInMinutes($lesson->TIMETO);   
                    array_push($calendarData[$timeText], [
                        'class_name'   => $lesson->Class_name,
                        'teacher_name' => $lesson->EMP_NAME,
                        'subject_name' => $lesson->SUBJECT_NAME,
                        'rowspan'      => $difference/30 ?? ''
                      
                    ]);
                   
                }
                else if (!$lessons->where('DAY', $index)->where('TIMEFROM', '<', $time['start'])->where('TIMETO', '>=', $time['end'])->count())
                {

                    array_push($calendarData[$timeText], 1);
                  
                }
                else
                {
                    array_push($calendarData[$timeText], 0);
                    
                } //dd($calendarData);
            }
        }
 //dd($calendarData);
        return $calendarData;
    }
}
