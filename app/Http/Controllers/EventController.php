<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        if(auth()->user()->is_admin) {
            $data['users'] = User::orderBy('created_at', 'desc')->paginate(10);
            $data['events'] = Event::orderBy('created_at', 'desc')->paginate(10);
        } else {
            $data['events'] = Event::orderBy('created_at', 'desc')->where('slots_left', '>', 0)
                ->whereDate('date', '>', today())
                ->paginate(10);

            $data['joined_upcoming_events'] = Event::orderBy('created_at', 'desc')->whereHas('participants', function($query) {
                      return $query->where('user_id', auth()->user()->id);
                })->whereDate('date', '>', now())->get();

        }

        return view('dashboard', compact("data"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "title" => "required|string",
            "description" => "nullable|string",
            "number_of_participants" => "required|numeric",
            "date" => "date|string",
            "location" => "required|string",
            "location_detail" => "required|string",
            "requirements" => "nullable|array",
            "payer" => "required|string",
        ]);

        $validatedData['slots_left'] = $validatedData['number_of_participants'];

        $event = auth()->user()->events()->create($validatedData);

        if($event) {
            return redirect()->route('event.create')->with('status', 'Event created!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        return view("show", compact("event"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }



    public function join($id)
    {
        $event = Event::findOrFail($id);
        $eventDate = Carbon::parse($event->date)->toDateString();

        if($event->date < today()) {
            return back()->with('errors', ["Too late to join event"]);
        }

        if($event->user_id == auth()->user()->id) {
            return back()->with('errors', ["You're already the host of \"{$event->title}\""]);
        }

        if($event->number_of_participants <= $event->participants()->count()) {
            return back()->with('errors', ["Event is full"]);
        }

        $alreadyHasPendingEventForSameDay = Event::whereDate('date', $eventDate)
            ->whereHas('participants', function($query) {
                return $query->where('user_id', auth()->user()->id);
            })
            ->exists();

        if($alreadyHasPendingEventForSameDay) {
            return back()->with('errors', ["Can't join more than one same-day event."]);
        }

        $fromCalendarDate = str_replace(["-",":"], "", explode(".", Carbon::parse($event->date)->toISOString())[0]);
        $toCalendarDate = str_replace(["-",":"], "", explode(".", Carbon::parse($event->date)->addHour()->toISOString())[0]);

        $event->participants()->create(["user_id" => auth()->user()->id]);
        $event->slots_left--;
        $event->save();


        $response = "You've joined {$event->title}. <br> <strong><a href='https://calendar.google.com/calendar/render?action=TEMPLATE&text={$event->title}&details={$event->description}&dates={$fromCalendarDate}/{$toCalendarDate}&location={$event->location_detail}'>Add to Calendar</a></strong>";

        return back()->with('status', $response);
    }
}
