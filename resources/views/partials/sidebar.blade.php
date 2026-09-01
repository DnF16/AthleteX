<aside class="fixed top-0 left-0 w-64 h-screen bg-[#2e4e1f] text-white flex flex-col p-6 z-50">
    <a href="#" class="flex items-center mb-6 text-lg font-bold no-underline text-white">
        SPORTS OFFICE
    </a>

   @if(auth()->check())
    <div class="flex items-center mb-6 p-2 bg-[#3b5d28] rounded">
        <i class="bi bi-person-circle mr-2 text-2xl"></i>
        <span class="font-semibold text-sm">
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

    <nav class="flex-1 flex flex-col overflow-y-auto overflow-x-hidden pr-2"> 
        <ul class="space-y-2 w-full"> 

            <li>
                <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 rounded {{ request()->routeIs('dashboard') ? 'bg-[#446634]' : 'bg-[#3b5d28]' }} font-semibold hover:bg-[#446634] transition-colors text-white no-underline w-full">
                    <i class="bi bi-speedometer2 mr-2"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('student.athlete') }}" class="flex items-center px-3 py-2 rounded {{ request()->routeIs('student.athlete') ? 'bg-[#446634]' : 'bg-[#3b5d28]' }} font-semibold hover:bg-[#446634] transition-colors text-white no-underline w-full">
                    <i class="bi bi-person-walking mr-2"></i> Student–Athletes
                </a>
            </li>
            @php
                $attendanceRoute = auth()->user()->role === 'admin'
                    ? route('admin.attendance')
                    : route('coach.attendance.index');
            @endphp

            <li>
                <a href="{{ $attendanceRoute }}" class="flex items-center px-3 py-2 rounded {{ request()->is('*attendance*') ? 'bg-[#446634]' : 'bg-[#3b5d28]' }} font-semibold hover:bg-[#446634] transition-colors text-white no-underline w-full">
                    <i class="bi bi-calendar2-week mr-2"></i> Attendance
                </a>
            </li>
            @php
                $reportsRoute = auth()->user()->role === 'admin'
                    ? route('admin.reports')
                    : route('coach.reports.index');
            @endphp

            <li>
                <a href="{{ $reportsRoute }}" class="flex items-center px-3 py-2 rounded {{ request()->is('*reports*') ? 'bg-[#446634]' : 'bg-[#3b5d28]' }} font-semibold hover:bg-[#446634] transition-colors text-white no-underline w-full">
                    <i class="bi bi-journal-text mr-2"></i> Reports
                </a>
            </li>
            <li>
                <a href="{{ route('coach') }}" class="flex items-center px-3 py-2 rounded {{ request()->routeIs('coach') ? 'bg-[#446634]' : 'bg-[#3b5d28]' }} font-semibold hover:bg-[#446634] transition-colors text-white no-underline w-full">
                    <i class="bi bi-people-fill mr-2"></i> Coaches
                </a>
            </li>
            
            {{-- 🚀 NEW ACHIEVEMENTS TAB --}}
            <li>
                <a href="{{ route('achievements.index') }}" class="flex items-center px-3 py-2 rounded {{ request()->routeIs('achievements.index') ? 'bg-[#446634]' : 'bg-[#3b5d28]' }} font-semibold hover:bg-[#446634] transition-colors text-white no-underline w-full">
                    <i class="bi bi-trophy-fill mr-2 text-yellow-400"></i> Achievements
                </a>
            </li>

            {{-- Admin-only links --}}
            @if(auth()->check() && auth()->user()->role === 'admin')
                <li>
                    <a href="{{ route('admin.approvals') }}" class="flex items-center px-3 py-2 rounded {{ request()->routeIs('admin.approvals') ? 'bg-[#446634]' : 'bg-[#3b5d28]' }} font-semibold hover:bg-[#446634] transition-colors text-white no-underline w-full">
                        <i class="bi bi-bell-fill mr-2"></i> Athlete Approvals
                        
                        <!-- 🚀 THE NOTIFICATION BADGE -->
                        @php
                            $pendingCount = \App\Models\Athlete::where('approval_status', 'pending')
                                                ->where('classification', 'Tryout')
                                                ->count();
                        @endphp
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('admin.tryouts.index') }}" class="flex items-center px-3 py-2 rounded {{ request()->routeIs('admin.tryouts.index') ? 'bg-[#446634]' : 'bg-[#3b5d28]' }} font-semibold hover:bg-[#446634] transition-colors text-white no-underline w-full">
                        <i class="bi bi-calendar-event mr-2"></i> Manage Tryouts
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.blockchain') }}" class="flex items-center px-3 py-2 rounded {{ request()->routeIs('admin.blockchain') ? 'bg-[#446634]' : 'bg-[#3b5d28]' }} font-semibold hover:bg-[#446634] transition-colors text-white no-underline w-full">
                        <i class="bi bi-shield-lock-fill mr-2 text-green-400"></i> Security Ledger
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.general') }}" class="flex items-center px-3 py-2 rounded {{ request()->routeIs('admin.general') ? 'bg-[#446634]' : 'bg-[#3b5d28]' }} font-semibold hover:bg-[#446634] transition-colors text-white no-underline w-full">
                        <i class="bi bi-person-gear mr-2"></i> Admin
                    </a>
                </li>
                <li>
                    <a href="{{ route('sports') }}" class="flex items-center px-3 py-2 rounded {{ request()->routeIs('sports') ? 'bg-[#446634]' : 'bg-[#3b5d28]' }} font-semibold hover:bg-[#446634] transition-colors text-white no-underline w-full">
                        <i class="bi bi-trophy mr-2"></i> Sports 
                    </a>
                </li>
            @endif
        </ul>

        <div class="mt-auto pt-4">
            <a href="{{ route('login') }}" class="w-full block text-center px-4 py-2 rounded bg-red-600 hover:bg-red-700 transition text-white no-underline font-bold">
                Logout
            </a>
        </div>
    </nav>
</aside>