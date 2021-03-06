<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use App\Models\Event;
use App\Models\Course;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:courses.view');
        $this->middleware('permission:courses.edit', ['only' => ['syncEventsTeacher', 'update_course_teacher', 'update_course_room', 'syncEventsRoom', 'store', 'destroy']]);
    }


    /**
     * get all events for a course
     */
    public function getCourseEvents($course)
    {
        $this->middleware(['permission:courses.view']);

        return Course::findOrFail($course)->events;
    }

    public function update_course_teacher(Request $request)
    {
        Log::notice('Calendar events updated by user ' . backpack_user()->id);
        $course = Course::findOrFail($request->input('course_id'));
        $teacher = User::findOrFail($request->input('resource_id'));

        $course->teacher_id = $teacher->id;
        $course->save();
        $course->events()->update(['teacher_id' => $course->teacher_id]);
    }

    public function update_course_room(Request $request)
    {
        Log::notice('Calendar events updated by user ' . backpack_user()->id);

        $course = Course::findOrFail($request->input('course_id'));
        $room = Room::findOrFail($request->input('resource_id'));

        $course->room_id = $room->id;
        $course->save();
        $course->events()->update(['room_id' => $course->room_id]);
    }

    /** Rewrite teacher for all events associated to a course */
    public function syncEventsTeacher(Course $course)
    {
        Event::where('course_id', $course->id)->update(['teacher_id' => $course->teacher_id]);
    }

    /** Rewrite room for all events associated to a course */
    public function syncEventsRoom(Course $course)
    {
        Event::where('course_id', $course->id)->update(['room_id' => $course->room_id]);
    }

}
