<style>
    #notificationPopup {
        z-index: 1000;
    }
</style>
<div class="w-full h-[110px] flex items-center border-b-2 border-b-gray-200 justify-between px-6 pr-10 bg-white">
    <div class="flex h-full items-center">
        <div class="relative mr-6">
            <div class="self-center w-[30px] h-[30px]">
                <img id="notificationButton" aria-hidden="true" class="w-full h-full" src="{{ asset('images/notification.png') }}" alt=""/>
            </div>
            <div id="notificationPopup" class="hidden absolute top-[65px] left-4 bg-white border border-gray-300 shadow-md rounded-md w-80 z-100 overflow-y-auto" style="max-height: 300px;">
                <div style="background:#12A2BD;" class="px-4 py-2 rounded-t-md">
                    <h3 class="text-white font-semibold">Notification</h3>
                </div>
                <div class="p-4">
                    {{-- @foreach ($notifications as $notification) --}}
                        {{-- @if ($notification->read_at === null) --}}
                            {{-- <div class="items-center mb-2 px-4 py-2 @if($notification->read_at) bg-white @else bg-gray-100 @endif"> --}}
                            <div class="items-center mb-2 px-4 py-2">
                                <div class="flex justify-between items-center">
                                    {{-- <h1 class="font-bold" style="color: black; font-size: 16px; margin-right: 10px;">Trafo ID {{ $notification->data['trafo_number'] }}</h1> --}}
                                    {{-- <p style="color: #7F7F7F; font-size: 16px; text-align: right;">{{ $notification->created_at->format('d/m') }}</p> --}}
                                </div>
                                <div class="flex" style="color:#7F7F7F; font-size: 16px">
                                    {{-- <p>There is an {{$notification->data['status']}} on your trafo</p> --}}
                                </div>
                            </div>
                        {{-- @endif --}}
                    {{-- @endforeach --}}
                </div>
                <div style="background:#E2EFFD;" class="px-4 py-2 rounded-b-md">
                    <center>
                        <h3 style="color:#24BEFE;" class="font-semibold"><a href="view-all">View All</a></h3>
                    </center>
                </div>
            </div>
            <div id="notificationIndicator" class="absolute top-0 right-0 w-3 h-3 bg-red-500 rounded-full cursor-pointer hidden"></div>
        </div>
        
<script>
    // Get the notification button and popup
    const notificationButton = document.getElementById('notificationButton');
    const notificationPopup = document.getElementById('notificationPopup');
    const notificationIndicator = document.getElementById('notificationIndicator');

    // Function to toggle popup visibility
    function togglePopup() {
        notificationPopup.classList.toggle('hidden');
        //Hide the indicator when the popup is opened
        if (!notificationPopup.classList.contains('hidden')) {
            notificationIndicator.classList.add('hidden');
        }
    }

    // Add click event listener to the notification button
    notificationButton.addEventListener('click', togglePopup);

    // Close the popup if user clicks outside of it
    window.addEventListener('click', function(event) {
        if (!notificationButton.contains(event.target) && !notificationPopup.contains(event.target)) {
            notificationPopup.classList.add('hidden');
        }
    });

    //Function to show the notification indicator
    function showNotificationindicator() {
        // Check if there are unread notifications
        const unreadNotifications = document.querySelectorAll('.bg-gray-100').length;
        if (unreadNotifications > 0) {
            notificationIndicator.classList.remove('hidden');
        } else {
            notificationIndicator.classList.add('hidden');
        }
    }

    showNotificationindicator();
</script>
       
    </div>
    
        <a href="/profile">
            <img aria-hidden="true" class="w-[40px] h-[40px] self-center" src="{{ asset('images/Icon.png') }}" alt=""/>
        </a>
</div>