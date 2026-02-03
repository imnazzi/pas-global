<?php
require_once __DIR__ . '/../models/CalendarEvent.php';

class CalendarController {
    public function index(){
        $events = CalendarEvent::all();
        require __DIR__ . '/../views/calendar/list.php';
    }
    public function view(){
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        if (!$id) { echo 'Event not found'; return; }
        $event = CalendarEvent::find($id);
        if (!$event) { echo 'Event not found'; return; }
        require __DIR__ . '/../views/calendar/view.php';
    }
}
