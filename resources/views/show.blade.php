<x-app-layout>
    <x-slot name="header"></x-slot>

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
                        <h6 class="text-sm text-center font-bold mt-6">Event Detail</h6>
                        <li class="border border-gray-200 rounded-xl my-4 p-2 shadow-lg">
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
                            @elseif(!auth()->user() || (auth()->user() && $event->user_id != auth()->user()->id))
                                <a onclick="return confirm('NOTE: This hangout may be hosted by someone you may have had some sort of relationship with, and this, you\'d only find out when you meet with them. It\'d be a good opportunity to fix or strengthen it. Also please endeavor to show up for it :-)')"
                                    href="{{ route('event.join', $event->id) }}"
                                    class="shadow-md cursor-pointer bg-blue-500 hover:bg-blue-600 p-1 mt-1 rounded-md text-center font-bold block">
                                    Join
                                </a>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function copyShareLink() {
        // Get the text field
        var copyText = document.getElementById("shareText").innerText;

        // Select the text field
        // copyText.select();
        // copyText.setSelectionRange(0, 99999); // For mobile devices

        // Copy the text inside the text field
        // setTimeout(async()=>console.log(await window.navigator.clipboard.writeText(copyText).then(function() {
        //     alert("Shareable link copied...");
        // })), 3000);

        window.navigator.clipboard.writeText(copyText).then(function() {
            alert("Shareable link copied...");
        });

        // navigator.clipboard.writeText(copyText);

        // Alert the copied text
    }
</script>
