@extends('layouts.app')

@section('title', 'Coaches')

@section('content')
    <div class="space-y-6 w-full">

        <!-- Page Header -->
        <div class="bg-white p-6 relative">
            <!-- Centered Title -->
            <div class="absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 flex items-center gap-2">
                <i class="bi bi-person text-3xl text-gray-800"></i>
                <h1 class="text-3xl font-bold text-gray-800 mb-0">Coach's</h1>
            </div>

            <!-- Right Button -->
            <div class="flex justify-end">
                <a href="#" 
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                    List of Coach's
                </a>
            </div>
        </div>

        <div class="flex items-end space-x-2">
            <!-- Full Name -->
            <div class="flex-1">
                <label class=" text-gray-700 font-medium mb-1" for="coach_name">Coach's Name</label>
                <input type="text" id="coach_name" name="coach_name" placeholder="Enter full name"
                    class="w-64 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600"
                    autocomplete="off">
            </div>

            <!-- Athlete ID -->
            <div class="flex-1">
                <label class=" text-gray-700 font-medium mb-1" for="coach_id">Coach's ID</label>
                <input type="text" id="coach_id" name="coach_id" placeholder="Enter athlete ID"
                    class="w-64 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600"
                    autocomplete="off">
            </div>

            <!-- Buttons -->
            <div class="flex space-x-2">
                <button type="submit" class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700 transition">
                    Save Coach
                </button>
                <button type="button" class="px-4 py-2 rounded bg-gray-300 text-gray-800 hover:bg-gray-400 transition">
                    Cancel New
                </button>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <nav class="mb-6 w-full overflow-x-auto h-8">
            <ul class="flex space-x-2 min-w-max">
                <li>
                    <a href="#coach-general-info" 
                    class="tab-link whitespace-nowrap px-4 py-2 text-gray-700 font-medium border-b-2 border-transparent hover:border-green-600 hover:text-green-600 transition">
                        General Information
                    </a>
                </li>
                <li>
                    <a href="#coach-achievements" 
                    class="tab-link whitespace-nowrap px-4 py-2 text-gray-700 font-medium border-b-2 border-transparent hover:border-green-600 hover:text-green-600 transition">
                        Achievements
                    </a>
                </li>
                <li>
                    <a href="#assigned-schedule-athletes" 
                    class="tab-link whitespace-nowrap px-4 py-2 text-gray-700 font-medium border-b-2 border-transparent hover:border-green-600 hover:text-green-600 transition">
                        Assigned Schedule / Athletes
                    </a>
                </li>
                <li>
                    <a href="#expenses-payments" 
                    class="tab-link whitespace-nowrap px-4 py-2 text-gray-700 font-medium border-b-2 border-transparent hover:border-green-600 hover:text-green-600 transition">
                        Expenses and Payments
                    </a>
                </li>
                <li>
                    <a href="#membership" 
                    class="tab-link whitespace-nowrap px-4 py-2 text-gray-700 font-medium border-b-2 border-transparent hover:border-green-600 hover:text-green-600 transition">
                        Membership
                    </a>
                </li>
                <li>
                    <a href="#seminars" 
                    class="tab-link whitespace-nowrap px-4 py-2 text-gray-700 font-medium border-b-2 border-transparent hover:border-green-600 hover:text-green-600 transition">
                        Seminars
                    </a>
                </li>
                <li>
                    <a href="#coach-work-history" 
                    class="tab-link whitespace-nowrap px-4 py-2 text-gray-700 font-medium border-b-2 border-transparent hover:border-green-600 hover:text-green-600 transition">
                        Work History
                    </a>
                </li>
                <li>
                    <a href="#coach-attachments" 
                    class="tab-link whitespace-nowrap px-4 py-2 text-gray-700 font-medium border-b-2 border-transparent hover:border-green-600 hover:text-green-600 transition">
                        Attachments
                    </a>
                </li>
                <li>
                    <a href="#coach-id" 
                    class="tab-link whitespace-nowrap px-4 py-2 text-gray-700 font-medium border-b-2 border-transparent hover:border-green-600 hover:text-green-600 transition">
                        Coach's ID
                    </a>
                </li>
            </ul>
        </nav>

        <hr class="border-t-2 border-gray-400 my-2 w-[100%]">

        <!-- Tab Content -->

        <!-- Coach General Info Content -->
        <div id="coach-general-info" class="tab-content">
            <p>This is the General Info content.</p>
        </div>

        <!-- Coach Achievements Content -->
        <div id="coach-achievements" class="tab-content hidden">
            <p>This is the Achievements content.</p>
        </div>

        <!-- Coach Assigned Schedule / Atheletes Content -->
        <div id="assigned-schedule-athletes" class="tab-content hidden">
            <p>This is the Assigned Schedule / Athletes.</p>
        </div>

        <!-- Coach Expenses and Payments Content -->
        <div id="expenses-payments" class="tab-content hidden">
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="text-center text-2xl font-semibold text-gray-800 mb-4 border-b pb-2">
                    EXPENSES AND PAYMENTS
                </h2>

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-300 text-sm text-gray-700">
                        <thead class="bg-green-100">
                            <tr>
                                <th class="border border-gray-300 px-4 py-2 text-left">Academic Year</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Term</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Type</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Amount</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Event / Athlete</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Notes</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- 10 Empty Rows -->
                            @for ($i = 0; $i < 20; $i++)
                            <tr class="{{ $i % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                <td class="border border-gray-300 px-4 py-2"></td>
                                <td class="border border-gray-300 px-4 py-2"></td>
                                <td class="border border-gray-300 px-4 py-2"></td>
                                <td class="border border-gray-300 px-4 py-2"></td>
                                <td class="border border-gray-300 px-4 py-2"></td>
                                <td class="border border-gray-300 px-4 py-2"></td>
                                <td class="border border-gray-300 px-4 py-2"></td>
                            </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Coach Membership Content -->
        <div id="membership" class="tab-content hidden">
            <p>This is the membership.</p>
        </div>

        <!-- Coach Seminars Content -->
        <div id="seminars" class="tab-content hidden">
            <p>This is the seminars.</p>
        </div>

        <!-- Coach Work History Content -->
        <div id="coach-work-history" class="tab-content hidden">
            <p>This is the work history.</p>
        </div>

        <!-- Coach Attachments Content -->
        <div id="coach-attachments" class="tab-content hidden">
            <p>This is the attachments.</p>
        </div>

        <!-- Coach's ID Content -->
        <div id="coach-id" class="tab-content hidden">
            <p>This is the coach's ID.</p>
        </div>

    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const tabs = document.querySelectorAll('.tab-link');
        const contents = document.querySelectorAll('.tab-content');

        // --- Default active tab setup ---
        const defaultTab = document.querySelector('.tab-link[href="#coach-general-info"]');
        const defaultContent = document.querySelector('#coach-general-info');

        if (defaultTab && defaultContent) {
            // Remove all active styles first
            tabs.forEach(t => t.classList.remove('border-b-2', 'border-green-600', 'text-green-600'));
            contents.forEach(c => c.classList.add('hidden'));

            // Set "General Information" as active
            defaultTab.classList.add('border-b-2', 'border-green-600', 'text-green-600');
            defaultContent.classList.remove('hidden');
        }

        // --- Tab switching behavior ---
        tabs.forEach(tab => {
            tab.addEventListener('click', e => {
                e.preventDefault();

                // Remove active styles from all tabs
                tabs.forEach(t => t.classList.remove('border-b-2', 'border-green-600', 'text-green-600'));
                // Hide all content sections
                contents.forEach(c => c.classList.add('hidden'));

                // Add active styles to the clicked tab
                tab.classList.add('border-b-2', 'border-green-600', 'text-green-600');

                // Show the matching content
                const target = document.querySelector(tab.getAttribute('href'));
                target.classList.remove('hidden');
            });
        });
    });
</script>


@endsection
