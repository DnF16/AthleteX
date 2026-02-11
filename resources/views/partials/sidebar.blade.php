<aside class="fixed top-0 left-0 w-64 h-screen bg-[#2e4e1f] text-white flex flex-col p-4 z-50">
    <a href="#" class="flex items-center mb-6 text-lg font-bold no-underline text-white">
        SPORTS OFFICE
    </a>

   @if(auth()->check())
    <div class="flex items-center mb-6 p-2 bg-[#3b5d28] rounded">
        <i class="bi bi-person-circle mr-2 text-2xl"></i>
        <span class="font-semibold">
            @if(auth()->user()->role === 'coach')
                Coach: {{ auth()->user()->coach ? auth()->user()->coach->coach_first_name . ' ' . auth()->user()->coach->coach_last_name : auth()->user()->name }}
            @elseif(auth()->user()->role === 'admin')
                Admin: {{ auth()->user()->name }}
            @else
                {{ auth()->user()->name }}
            @endif
        </span>
    </div>
@endif


    <nav class="flex-1">
        <ul class="space-y-2">
            <li>
                <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 rounded bg-[#3b5d28] font-semibold hover:bg-[#446634] transition-colors text-white no-underline">
                    <i class="bi bi-speedometer2 mr-2"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('student.athlete') }}" class="flex items-center px-3 py-2 rounded bg-[#3b5d28] font-semibold hover:bg-[#446634] transition-colors text-white no-underline">
                    <i class="bi bi-person-walking mr-2"></i> Student–Athletes
                </a>
            </li>
            <li>
                <a href="{{ route('coach') }}" class="flex items-center px-3 py-2 rounded bg-[#3b5d28] font-semibold hover:bg-[#446634] transition-colors text-white no-underline">
                    <i class="bi bi-people-fill mr-2"></i> Coaches
                </a>
            </li>
            <li>
                <a href="{{ route('schedule') }}" class="flex items-center px-3 py-2 rounded bg-[#3b5d28] font-semibold hover:bg-[#446634] transition-colors text-white no-underline">
                    <i class="bi bi-calendar2-week mr-2"></i> Schedule
                </a>
            </li>
            <!-- <li>
                <a href="#" class="flex items-center px-3 py-2 rounded bg-[#3b5d28] font-semibold hover:bg-[#446634] transition-colors text-white no-underline">
                    <i class="bi bi-journal-text mr-2"></i> Classes
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-3 py-2 rounded bg-[#3b5d28] font-semibold hover:bg-[#446634] transition-colors text-white no-underline">
                    <i class="bi bi-trophy-fill mr-2 text-yellow-400"></i> Achievements
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-3 py-2 rounded bg-[#3b5d28] font-semibold hover:bg-[#446634] transition-colors text-white no-underline">
                    <i class="bi bi-clipboard-check mr-2"></i> Exams
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-3 py-2 rounded bg-[#3b5d28] font-semibold hover:bg-[#446634] transition-colors text-white no-underline">
                    <i class="bi bi-cash-stack mr-2"></i> Transactions
                </a>
            </li>
            <li> -->

            {{-- Admin-only links --}}
            @if(auth()->check() && auth()->user()->role === 'admin')
                <li>
                    <a href="{{ route('admin.approvals') }}" class="flex items-center px-3 py-2 rounded bg-[#3b5d28] font-semibold hover:bg-[#446634] transition-colors text-white no-underline">
                        <i class="bi bi-bell-fill mr-2"></i> Athlete Approvals
                    </a>
                </li>
                <li>

                    <a href="{{ route('admin.general') }}" class="flex items-center px-3 py-2 rounded bg-[#3b5d28] font-semibold hover:bg-[#446634] transition-colors text-white no-underline">
                        <i class="bi bi-person-gear mr-2"></i> Admin
                    </a>
                </li>
                <li>
                    <a href="{{ route('sports') }}" class="flex items-center px-3 py-2 rounded bg-[#3b5d28] font-semibold hover:bg-[#446634] transition-colors text-white no-underline">
                        <i class="bi bi-person-gear mr-2"></i> Sports
                    </a>
                </li>
            @endif


        <div class="mt-auto pt-4">
            <a href="{{ route('log.login') }}" class="w-full block text-center px-4 py-2 rounded bg-red-600 hover:bg-red-700 transition text-white no-underline font-bold">
                Logout
            </a>
        </div>
    </nav>
</aside>