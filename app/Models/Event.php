<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function workshops(){
        return $this->hasMany('App\Models\Workshop', 'event_id','id');
    }

    public static function getEventsWithWorkshops()
    {
        return self::with('workshops')->get()->toArray();
    }

    public static function getNotStartedEvents()
    {
        $current_date = Carbon::now();
        $date = Carbon::parse($current_date)->format('Y-m-d');
        return self::with('workshops')->whereHas('workshops', function ($query) use ($date) {
            $query->whereDate('start', '>', $date);
        })->get()->toArray();
    }
}
