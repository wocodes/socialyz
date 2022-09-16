<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("You are logged in!") }}
        </h2>
    </x-slot>

    <div class="grid place-content-center">
        <a href="host" class="bg-sky-500 rounded-3xl py-2 hover:bg-sky-700 my-6 mx-4 w-48 text-center mx-auto block">Host a Hangout</a>
    </div>

    <div class="text-center">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-errors class="mb-4" :errors="$errors" />
    </div>

    <div class="py-6">
        <div class="sm:w-full md:w-full lg:w-2/4 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <ul>
                        @if(!empty($data['users']))
                            @foreach($data['users'] as $user)
                                <li>
                                    {{ $user->username }} -
                                    @if($user->verified_at)
                                        Verified
                                    @else
                                        <a class="underline text-blue-500" href="verify/{{ base64_encode($user->username . '0000') }}">Verify</a>
                                    @endif
                                </li>
                            @endforeach
                        @endif

                        @if(!empty($data['joined_upcoming_events']))
                            <h6 class="text-sm text-center font-bold">Joined Upcoming events</h6>
                            @foreach($data['joined_upcoming_events'] as $upcomingEvent)
                                <li class="border border-gray-200 rounded-xl my-4 p-2 shadow-lg">
                                    <a href="event/{{ $upcomingEvent->id }}">
                                        <span class="text-1xl font-bold block">
                                            <span class="text-gray-300">#{{ $upcomingEvent->id }}</span>
                                            {{ $upcomingEvent->title }}
                                        </span>
                                        <span class="text-xs">
                                            <span class="mx-1">
                                                No. ppts:
                                                <strong>
                                                    {{ $upcomingEvent->number_of_participants }}
                                                    ({{ $upcomingEvent->slots_left }} slot left)
                                                </strong>
                                            </span> &middot;
                                            <span class="mx-1"><strong>{{ ucfirst($upcomingEvent->location) }}</strong></span> &middot;
                                            <span class="mx-1">
                                                Date: <strong>{{ date("dS M, Y", strtotime($upcomingEvent->date)) }}</strong> &middot;
                                                Time: <strong>{{ date("h:ia", strtotime($upcomingEvent->date)) }}</strong> &middot;
                                                Sponsor: <strong>{{ $upcomingEvent->payer }}</strong>
                                            </span>
                                        </span>
                                        @if($upcomingEvent->requirements)
                                            <span class="block text-xs mx-1">Requirements:
                                                <strong>{{ implode(", ", $upcomingEvent->requirements) }}</strong>
                                            </span>
                                        @endif
                                        <span class="text-blue-500 block text-xs mx-1">
                                            Location Detail: {{ $upcomingEvent->location_detail }}
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        @endif

                        <h6 class="text-sm text-center font-bold mt-6">New events</h6>
                        @if($data['events'])
                            @foreach($data['events'] as $event)
                                <li class="border border-gray-200 rounded-xl my-4 p-2 shadow-lg">
                                    @if($event->user_id == auth()->user()->id)
                                        <span class="text-sm rounded-2xl px-2 text-white bg-red-300 inline-block">my event</span>
                                    @endif
                                    <span class="text-2xl font-bold block">
                                        <span class="text-gray-300">#{{ $event->id }}</span>
                                        {{ $event->title }}
                                    </span>
                                    <span class="text-sm">
                                        <span class="mx-1">
                                            No. ppts:
                                            <strong>{{ $event->number_of_participants }} ({{ $event->slots_left }} slot left)</strong>
                                        </span> &middot;
                                        <span class="mx-1"><strong>{{ ucfirst($event->location) }}</strong></span> &middot;
                                        <span class="mx-1">
                                            Date: <strong>{{ date("dS M, Y", strtotime($event->date)) }}</strong> &middot;
                                            Time: <strong>{{ date("h:ia", strtotime($event->date)) }}</strong> &middot;
                                            Sponsor: <strong>{{ $event->payer }}</strong>
                                        </span>
                                    </span>
                                    @if($event->requirements)
                                        <span class="block text-sm mx-1">Requirements: <strong>{{ implode(", ", $event->requirements) }}</strong></span>
                                    @endif

                                    @if($event->userHasJoined())
                                        <span class="text-blue-500 cursor-pointer bg-white p-1 mt-1 rounded-md text-center font-bold block">
                                            Joined
                                        </span>
                                    @elseif($event->user_id != auth()->user()->id)
                                        <a onclick="return confirm('NOTE: This hangout may be hosted by someone you may have had some sort of relationship with, and this, you\'d only find out when you meet with them. It\'d be a good opportunity to fix or strengthen it. Also please endeavor to show up for it :-)')"
                                            href="join/{{ $event->id }}"
                                            class="shadow-md cursor-pointer bg-blue-500 hover:bg-blue-600 p-1 mt-1 rounded-md text-center font-bold block">
                                            Join
                                        </a>
                                    @endif
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
