@if ($count%2 == 0)
    <div class="mt-4 ml-3 mr-3 mb-0 border-l border-t border-red-500 grid grid-cols-1 w-100 col-span-2">
@else
    <div class="mt-4 ml-3 mr-3 border-r border-t border-yellow-600 grid grid-cols-1 w-100 col-span-2">
@endif
    <!-- header -->
    <div class="pl-2 mt-2 text-xl font-bold text-white col-span-1">
        Comments
    </div>
    <!-- add comment form -->
    <div class="pl-2 text-sm font-bold text-white col-span-1">
        <form method="POST" class="block w-100 m-2" action="{{ route('addTrackComment') }}">
            @csrf
            <input type="hidden" id="comment-track-id" name="comment-track-id" value="{{ $track->id }}">
            <label for="comment-content" class="sr-only">Comment</label>
            <textarea id="comment-content" class="placeholder-white block mt-1 w-full bg-transparent text-gray-200 text-start" rows="3" type="text" name="comment-content" placeholder="Comment Here"required></textarea>
            @if ($count%2 == 1)
                <button dusk="comment-track-btn" class="text-yellow-500 hover:text-yellow-700 float-right">Leave a Comment</button>
            @else
                <button dusk="comment-track-btn" class="text-red-500 hover:text-red-700 float-right">Leave a Comment</button>
            @endif
        </form>
    </div>
    <!-- list all comments -->
    <div class="pl-2 grid grid-cols-1 mt-2 mr-2 ml-2">
        @foreach ($track->comments->sortByDesc('created_at') as $comment)
            @php
                $date = \App\Http\Controllers\LeaderboardController::getCreatedAtAttribute($comment->created_at, $timezone);
            @endphp
            <div class="mb-2 p-1 col-span-1 grid grid-rows-2">
                <div class="row-span-1 text-sm md:text-base font-bold grid grid-cols-2">
                    @if ($count%2 == 1)
                        <div class="col-span-1 text-left text-yellow-500">{{ $comment->user->name }}</div>
                    @else
                        <div class="col-span-1 text-left text-red-500">{{ $comment->user->name }}</div>
                    @endif
                    <script>
                        import moment from "moment";

                        function changeTimeZone(created_at) {
                            let date;
                            date = document.getElementById("date");
                            const user_tz = Intl.DateTimeFormat().resolvedOptions().timeZone;
                            const message_formatted_date = moment.utc(created_at ? created_at : undefined).tz(user_tz).format("MMMM D, YYYY, h:mm A");
                            date.textContent = message_formatted_date;
                        }
                    </script>
                    <div id="date" class="col-span-1 text-right text-white">
                        {{$date->hour}}:{{$date->minute}} {{$date->month}}-{{$date->day}}-{{$date->year}}
                    </div>


                </div>
                <div class="row-span-1 text-sm md:text-base text-gray-200">
                    {{ $comment->content }}
                </div>
                @if (Auth::user()->id == $comment->user_id)
                    <form method="POST" class="block w-100 m-0" action="{{ route('deleteTrackComment') }}">
                        @csrf
                        <input type="hidden" id="comment-id" name="comment-id" value="{{ $comment->id }}">
                        <button dusk="delete-comment-btn" class="text-sm text-red-600 hover:text-red-800 float-right">Delete</button>
                    </form>
                @endif
            </div>
        @endforeach
    </div>


</div>
