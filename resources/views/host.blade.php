<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Host an Event!") }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="text-center">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
        </div>


        <div class="sm:w-full md:w-full lg:w-2/4 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('event.store') }}">
                        @csrf
                        <div class="mt-4">
                            <x-label for="title" :value="__('Title')" />
                            <x-input id="title" class="block mt-1 w-full" type="text" maxlength="100" name="title" :value="old('title')" required />
                            <span class="block text-xs text-red-400 leading-0 italic">
                                Be creative, simple and cool with titles. <br>Examples are
                                <strong>Moment with Pizza!</strong>,
                                <strong>I scream Ice cream!</strong>,
                                <strong>Lunch packs in a Park?</strong>,
                                <strong>Move to the Movies!</strong>. <br>
                                Avoid adding your name or info that reveals your identity. The idea is for
                                people to hangout without knowing who they're hanging out with.
                                Thus making new friends/acquitance. Sounds fun?
                            </span>
                        </div>

                        <div class="mt-4">
                            <x-label for="description" :value="__('Description')" />

                            <x-input id="description" class="block mt-1 w-full" type="text" name="description" :value="old('description')" />
                        </div>

                        <div class="mt-4">
                            <x-label for="number_of_participants" :value="__('No. of Participants')" />

                            <x-input id="number_of_participants" class="block mt-1 w-full" type="number" name="number_of_participants" :value="old('number_of_participants')" required />
                        </div>

                        <div class="mt-4">
                            <x-label for="date" :value="__('Date')" />

                            <x-input id="date" class="block mt-1 w-full" type="datetime-local" name="date" :value="old('date')" required />
                        </div>

                        <div class="mt-4">
                            <x-label for="location" :value="__('Location')" />
                            <div class="grid grid-cols-3 w-full">
                                <div><x-input id="location" type="radio" name="location" value="akka" required /> Akka</div>

                                <div><x-input id="location"  type="radio" name="location" value="bahji" required /> Bahji</div>

                                <div><x-input id="location"  type="radio" name="location" value="haifa" required /> Haifa</div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <x-label for="location_detail" :value="__('Location Detail')" />

                            <x-input id="location_detail" class="block mt-1 w-full" type="text" name="location_detail" :value="old('location_detail')"
                                     placeholder="Only shown to friends who chose to join the event"
                                     required />
                        </div>


                        <div class="mt-4">
                            <x-label for="requirements" :value="__('Requirements')" />
                            <div class="grid grid-cols-3 w-full">
                                <div><x-input id="requirements" type="checkbox" name="requirements[]" value="mask" /> Nose Mask</div>

                                <div><x-input id="requirements"  type="checkbox" name="requirements[]" value="sanitizer" /> Hand Sanitizer</div>

                                <div><x-input id="requirements"  type="checkbox" name="requirements[]" value="glove" /> Gloves</div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <x-label for="payer" :value="__('Payer')" />
                            <div class="grid grid-cols-3 w-full">
                                <div><x-input id="payer" type="radio" name="payer" value="host" required /> Host</div>

                                <div><x-input id="payer" type="radio" name="payer" value="participants" required /> Participants</div>

                                <div><x-input id="payer" type="radio" name="payer" value="all parties" required /> All parties</div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button class="ml-4 text-gray-200 bg-gray-800 py-1 px-10 rounded-2xl font-bold"
                                      onclick="return confirm('NOTE: This hangout may be joined by someone you may have had some sort of relationship with, and this, you\'d only find out when you meet with them. It\'d be a good opportunity to fix or strengthen it. Also please endeavor to show up for it :-)')">
                                {{ __('Create') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
