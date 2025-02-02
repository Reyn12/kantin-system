{{-- Calendar & Events Card --}}
<div class="space-y-4">
    <h2 class="text-xl font-bold">Calendar & Events</h2>
    
    {{-- Mini Calendar --}}
    <div class="relative">
        {{-- Gradient Background --}}
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/30 via-purple-500/30 to-pink-500/30 rounded-lg blur-xl"></div>
        
        {{-- Calendar Content --}}
        <div class="relative bg-white/80 backdrop-blur-sm rounded-lg p-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-sm font-semibold" id="currentMonth">Februari 2025</h3>
                <div class="flex gap-2">
                    <button onclick="changeMonth(-1)" class="p-1 hover:bg-gray-200 rounded-full">
                        <i class="fas fa-chevron-left text-gray-600 text-xs"></i>
                    </button>
                    <button onclick="changeMonth(1)" class="p-1 hover:bg-gray-200 rounded-full">
                        <i class="fas fa-chevron-right text-gray-600 text-xs"></i>
                    </button>
                </div>
            </div>
            
            {{-- Calendar Grid --}}
            <div class="grid grid-cols-7 gap-1">
                <div class="text-center text-gray-500 text-xs">Mon</div>
                <div class="text-center text-gray-500 text-xs">Tue</div>
                <div class="text-center text-gray-500 text-xs">Wed</div>
                <div class="text-center text-gray-500 text-xs">Thu</div>
                <div class="text-center text-gray-500 text-xs">Fri</div>
                <div class="text-center text-gray-500 text-xs">Sat</div>
                <div class="text-center text-gray-500 text-xs">Sun</div>
            </div>
            <div id="calendarDays" class="grid grid-cols-7 gap-1 mt-1">
                {{-- Calendar days will be inserted here by JS --}}
            </div>
        </div>
    </div>

    {{-- Events List --}}
    <div id="eventsList" class="space-y-3 mt-4">
        {{-- Events will be inserted here by JS --}}
    </div>
</div>

<script>
    // Data events
    const events = [
        {
            date: '2025-02-02',
            events: [
                {
                    title: 'Makan Gratis',
                    time: '12:00',
                    icon: 'fas fa-utensils'
                },
                {
                    title: 'Live Music',
                    time: '19:00',
                    icon: 'fas fa-music'
                }
            ]
        },
        {
            date: '2025-02-03',
            events: [
                {
                    title: 'Live Konser',
                    time: '20:00',
                    icon: 'fas fa-guitar'
                }
            ]
        }
    ];

    let currentDate = new Date(2025, 1, 1); // February 2025
    let selectedDate = '2025-02-02'; // Default to today's date

    // Generate calendar days
    function generateCalendar() {
        const daysContainer = document.getElementById('calendarDays');
        daysContainer.innerHTML = ''; // Clear previous days

        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();
        
        // Update month display
        const monthName = currentDate.toLocaleString('default', { month: 'long' });
        document.getElementById('currentMonth').textContent = `${monthName} ${year}`;

        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const totalDays = lastDay.getDate();
        const startDay = firstDay.getDay() || 7; // Convert Sunday from 0 to 7

        // Add empty cells for days before the 1st
        for (let i = 1; i < startDay; i++) {
            const emptyDay = document.createElement('div');
            emptyDay.className = 'h-6';
            daysContainer.appendChild(emptyDay);
        }

        // Add the days
        for (let day = 1; day <= totalDays; day++) {
            const currentDateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            const hasEvent = events.some(event => event.date === currentDateStr);
            
            const dayDiv = document.createElement('div');
            dayDiv.className = `h-6 flex items-center justify-center text-xs cursor-pointer rounded-full transition-colors
                ${currentDateStr === selectedDate ? 'bg-indigo-500 text-white hover:bg-indigo-600' : 
                  hasEvent ? 'text-indigo-600 hover:bg-indigo-100' : 'hover:bg-gray-200'}`;
            dayDiv.textContent = day;
            
            // Add click event to all days
            dayDiv.addEventListener('click', () => {
                selectedDate = currentDateStr;
                generateCalendar(); // Refresh calendar to update selected date
                generateEventsList(); // Update events list
            });
            
            daysContainer.appendChild(dayDiv);
        }
    }

    // Change month function
    function changeMonth(delta) {
        currentDate.setMonth(currentDate.getMonth() + delta);
        generateCalendar();
        generateEventsList();
    }

    // Generate events list
    function generateEventsList() {
        const eventsContainer = document.getElementById('eventsList');
        eventsContainer.innerHTML = ''; // Clear previous events
        
        // Find events for selected date
        const dateEvents = events.find(event => event.date === selectedDate);
        
        if (dateEvents) {
            dateEvents.events.forEach(event => {
                const eventDiv = document.createElement('div');
                eventDiv.className = 'flex items-center gap-3 p-2 hover:bg-gray-50 rounded-lg transition-colors';
                eventDiv.innerHTML = `
                    <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <i class="${event.icon} text-indigo-600 text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-semibold text-sm">${event.title}</h4>
                        <div class="flex items-center gap-1 text-xs text-gray-500">
                            <i class="far fa-clock"></i>
                            <span>${event.time}</span>
                        </div>
                    </div>
                `;
                eventsContainer.appendChild(eventDiv);
            });
        } else {
            eventsContainer.innerHTML = '<div class="text-center text-gray-500 text-sm">Tidak ada event di tanggal ini</div>';
        }
    }

    // Initialize calendar and events
    generateCalendar();
    generateEventsList();
</script>