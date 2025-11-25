<script src="https://cdn.tailwindcss.com"></script>


<!-- Sidebar -->
<div class="flex h-screen bg-[#2e4e1f]">
    <!-- Sidebar container -->
    <aside class="fixed top-0 left-0 w-64 h-screen bg-[#2e4e1f] text-white flex flex-col p-4">
        <!-- Logo / Brand -->
        <a href="#" class="flex items-center mb-6 text-lg font-bold no-underline">
            SPORTS OFFICE
        </a>

        <!-- Navigation -->
        <nav class="flex-1">
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('dashboard') }}"
                       class="flex items-center px-3 py-2 rounded bg-[#3b5d28] font-semibold hover:bg-[#446634] transition-colors">
                        <i class="bi bi-speedometer2 mr-2"></i>
                        Dashboard
                    </a>
                </li>

                <li>
                    <a href="{{ route('student.athlete') }}"
                       class="flex items-center px-3 py-2 rounded bg-[#3b5d28] font-semibold hover:bg-[#446634] transition-colors">
                        <i class="bi bi-person-walking mr-2"></i>
                        Student–Athletes
                    </a>
                </li>

                <li>
                    <a href="{{ route('coach') }}"
                       class="flex items-center px-3 py-2 rounded bg-[#3b5d28] font-semibold hover:bg-[#446634] transition-colors">
                        <i class="bi bi-people-fill mr-2"></i>
                        Coaches
                    </a>
                </li>

                <li>
                    <a href="{{ route('schedule') }}"
                       class="flex items-center px-3 py-2 rounded bg-[#3b5d28] font-semibold hover:bg-[#446634] transition-colors">
                        <i class="bi bi-calendar2-week mr-2"></i>
                        Schedule
                    </a>
                </li>

                <li>
                    <a href="#"
                       class="flex items-center px-3 py-2 rounded bg-[#3b5d28] font-semibold hover:bg-[#446634] transition-colors">
                        <i class="bi bi-journal-text mr-2"></i>
                        Classes
                    </a>
                </li>

                <li>
                    <a href="#"
                       class="flex items-center px-3 py-2 rounded bg-[#3b5d28] font-semibold hover:bg-[#446634] transition-colors">
                        <i class="bi bi-trophy-fill mr-2 text-yellow-400"></i>
                        Achievements
                    </a>
                </li>

                <li>
                    <a href="#"
                       class="flex items-center px-3 py-2 rounded bg-[#3b5d28] font-semibold hover:bg-[#446634] transition-colors">
                        <i class="bi bi-clipboard-check mr-2"></i>
                        Exams
                    </a>
                </li>

                <li>
                    <a href="#"
                       class="flex items-center px-3 py-2 rounded bg-[#3b5d28] font-semibold hover:bg-[#446634] transition-colors">
                        <i class="bi bi-cash-stack mr-2"></i>
                        Transactions
                    </a>
                </li>

                <li>
                    <a href="#"
                       class="flex items-center px-3 py-2 rounded bg-[#3b5d28] font-semibold hover:bg-[#446634] transition-colors">
                        <i class="bi bi-bell-fill mr-2"></i>
                        Notifications
                    </a>
                </li>

                <li>
                    <a href="#"
                       class="flex items-center px-3 py-2 rounded bg-[#3b5d28] font-semibold hover:bg-[#446634] transition-colors">
                        <i class="bi bi-person-gear mr-2"></i>
                        Admin
                    </a>
                </li>
            </ul>

            <!-- Logout button at the bottom -->
            <div class="mt-auto">
                <a href="{{ route('log.login') }}"
                class="w-full block text-center px-4 py-2 rounded bg-red-600 hover:bg-red-700 transition">
                    Logout
                </a>
            </div>

        </nav>
    </aside>

    <!-- Main content placeholder -->
    <main class="ml-64 flex-1 bg-gray-50 p-6 overflow-y-auto h-screen">
        @yield('content')
    </main>
</div>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
