<?php
namespace App\Models\POS\Shared;

class CalendarEvent extends \Illuminate\Database\Eloquent\Model implements \MaddHatter\LaravelFullcalendar\Event
{
    //...

    public $employeeId;



    public function __construct($title, $isAllDay, $start, $end, $id = null, $options = [], $employeeId)
    {
        parent::__construct();
        $this->_employeeId = $employeeId;
    }


    //...

    /**
     * Get the event's title
     *
     * @return string
     */
    public function getTitle(){
        return "";
    }

    /**
     * Is it an all day event?
     *
     * @return bool
     */
    public function isAllDay(){
        return "";
    }
    /**
     * Get the start time
     *
     * @return DateTime
     */
    public function getStart(){
        return $this->start;
    }

    /**
     * Get the end time
     *
     * @return DateTime
     */
    public function getEnd(){
        return $this->end;
    }

}