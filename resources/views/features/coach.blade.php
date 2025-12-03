@extends('layouts.app')

@section('title', 'Coaches')

@section('content')
    <div class="space-y-6 w-full">

        <!-- Page Header -->
        <div class="bg-white p-6 relative">
            <!-- Centered Title -->
            <div class="absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 flex items-center gap-2">
                <i class="bi bi-person text-3xl text-gray-800"></i>
                @if(auth()->check() && auth()->user()->role === 'coach')
                    <h1 class="text-3xl font-bold text-gray-800 mb-0">My Profile</h1>
                @else
                    <h1 class="text-3xl font-bold text-gray-800 mb-0">Coaches</h1>
                @endif
            </div>

            <!-- Right Button - Only show for admins -->
            @if(!auth()->check() || auth()->user()->role !== 'coach')
                <div class="flex justify-end">
                    <a href="{{ route('coaches.index') }}" 
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                        List of Coaches
                    </a>
                </div>
            @endif
        </div>

        <!-- Search Section - Only for admins -->
        @if(!auth()->check() || auth()->user()->role !== 'coach')
            <div class="flex items-end space-x-2">
                <!-- Search -->
                <div class="">
                    <label class=" text-gray-700 font-medium mb-1" for="coach_search">Search</label>
                    <input type="text" id="coach_search" name="coach_search" placeholder="Enter full name"
                        class="w-64 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600"
                        autocomplete="off" value="">
                    <!-- Live search results -->
                    <div id="coach_searchResults" class="mt-2 w-64 bg-white border border-gray-200 rounded shadow-sm hidden"></div>
                </div>
            </div>
        @endif

        <!-- Action Buttons -->
        <!-- Action Buttons -->
        <div class="flex justify-center space-x-2">
            @if(auth()->check() && auth()->user()->role === 'coach')
                <!-- COACH USERS: Show Save (new) or Edit (existing) -->
                @if(!isset($coach))
                    <!-- New profile: Show Save button -->
                    <button id="coach_saveBtn" type="button" class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700 transition">
                        Save My Profile
                    </button>
                @else
                    <!-- Existing profile: Show Edit button -->
                    <button id="coach_editBtn" type="button" class="px-4 py-2 rounded bg-yellow-500 text-white hover:bg-yellow-600 transition">
                        Edit My Profile
                    </button>
                @endif
                
                <!-- ALWAYS render Update button (hidden by default) -->
                <button id="coach_updateBtn" type="button" class="hidden px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 transition">
                    Update My Profile
                </button>
                
            @else
                <!-- ADMIN USERS: Original logic -->
                <button id="coach_saveBtn" type="submit" form="coachForm" class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700 transition">
                    Save Coach
                </button>

                <button id="coach_updateBtn" type="button" form="coachForm" class="{{ isset($coach) ? '' : 'hidden' }} px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 transition">
                    Update Coach
                </button>

                <button type="button" onclick="resetCoachForm()" class="px-4 py-2 rounded bg-gray-300 text-gray-800 hover:bg-gray-400 transition">
                    Cancel New
                </button>
            @endif
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
    <div id="tab-content" class="bg-white p-6 rounded shadow w-full">

        <!-- Coach General Info Content -->
        <div id="coach-general-info" class="tab-content hidden">
            <div class="flex items-stretch gap-6">
                <form id="coachForm" method="POST" action="
                    @if(auth()->check() && auth()->user()->role === 'coach' && isset($coach))
                        {{ route('coaches.update', $coach->id) }}
                    @else
                        {{ route('coaches.store') }}
                    @endif
                " class="coach-form flex items-stretch gap-6 w-full" autocomplete="off" enctype="multipart/form-data">
                    @csrf

                    @if(auth()->check() && auth()->user()->role === 'coach' && isset($coach))
                        @method('PUT')
                    @endif

                    <!-- method spoofing input: stay POST by default, switched to PUT when updating -->
                    <input type="hidden" name="_method" id="coach_method" value="POST">
                    <!-- selected coach id (for reference) -->
                    <input type="hidden" name="selected_coach_id" id="selected_coach_id" value="{{ isset($coach) ? $coach->id : '' }}">

                    <!-- LEFT SIDE: Main Form -->
                    <div class="gap-4 mb-6">

                        <!-- 1st Row -->
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <!-- Last Name -->
                            <div class="flex items-center">
                                <label for="coach_last_name" class="w-1/3 text-gray-700 font-medium">Last Name</label>
                                <input type="text" id="coach_last_name" name="coach_last_name" placeholder="Enter last name"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <!-- First Name -->
                            <div class="flex items-center">
                                <label for="coach_first_name" class="w-1/3 text-gray-700 font-medium">First Name</label>
                                            <input type="text" id="coach_first_name" name="coach_first_name" placeholder="Enter first name"
                                                value="{{ old('coach_first_name', isset($coach) ? $coach->coach_first_name : '') }}"
                                                class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <!-- Middle Initial -->
                            <div class="flex items-center">
                                <label for="coach_middle_initial" class="w-1/3 text-gray-700 font-medium">Middle Initial</label>
                                <input type="text" id="coach_middle_initial" name="coach_middle_initial" placeholder="Enter middle initial"
                                    value="{{ old('coach_middle_initial', isset($coach) ? $coach->coach_middle_initial : '') }}"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>
                        </div>

                        <!-- 2nd Row -->
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div class="flex items-center">
                            <label class="w-1/3 text-gray-700 font-medium">Gender</label>

                            <select id="coach_gender" name="coach_gender"
                                class="w-2/3 border border-gray-300 rounded px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-green-600">
                                <option value="">Select Gender</option>
                                <option value="Male" {{ isset($coach) && $coach->coach_gender === 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ isset($coach) && $coach->coach_gender === 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>


                            <div class="flex items-center">
                                <label class="w-1/3 text-gray-700 font-medium">Birthdate</label>
                                <input type="date" id="coach_birthdate" name="coach_birthdate"
                                    value="{{ old('coach_birthdate', isset($coach) && $coach->coach_birthdate ? $coach->coach_birthdate->format('Y-m-d') : '') }}"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="flex items-center">
                                <label class="w-1/3 text-gray-700 font-medium">Age</label>
                                <input type="number" id="coach_age" name="coach_age" placeholder="Enter Age"
                                    value="{{ old('coach_age', isset($coach) ? $coach->coach_age : '') }}"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>
                        </div>

                        <!-- 3rd Row -->
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div class="flex items-center">
                                <label class="w-1/3 text-gray-700 font-medium">Blood Type</label>
                                <input type="text" id="coach_blood_type" name="coach_blood_type" placeholder="Enter Blood Type"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="flex items-center">
                                <label class="w-1/3 text-gray-700 font-medium">Place of Birth</label>
                                <input type="text" id="coach_place_of_birth" name="coach_place_of_birth" placeholder="Enter Place of Birth"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="flex items-center">
                                <label for="coach_marital_status" class="w-1/3 text-gray-700 font-medium">Marital Status</label>
                                <select id="coach_marital_status" name="coach_marital_status"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-green-600">
                                    <option value="">Select Marital Status</option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Widowed">Widowed</option>
                                    <option value="Divorced">Divorced</option>
                                    <option value="Separated">Separated</option>
                                </select>
                            </div>
                        </div>

                        <!-- 4th Row -->
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div class="flex items-center">
                                <label for="coach_email" class="w-1/3 text-gray-700 font-medium">Email Address</label>
                                <input type="text" id="coach_email" name="coach_email" placeholder="Enter Email Address"
                                    value="{{ old('coach_email', isset($coach) ? $coach->coach_email : '') }}"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="flex items-center">
                                <label for="coach_facebook" class="w-1/3 text-gray-700 font-medium">Facebook Link</label>
                                <input type="text" id="coach_facebook" name="coach_facebook" placeholder="Enter Facebook Account Link"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="flex items-center">
                                <label for="coach_tba" class="w-1/3 text-gray-700 font-medium">TBA</label>
                                <input type="text" id="coach_tba" name="coach_tba" placeholder="TO BE ANNOUNCE" 
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>
                        </div>

                        <!-- 5th Row -->
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div class="flex items-center">
                                <label for="coach_contact_number" class="w-1/3 text-gray-700 font-medium">Contact No.</label>
                                <input type="text" id="coach_contact_number" name="coach_contact_number" placeholder="Enter Contact Number"
                                    value="{{ old('coach_contact_number', isset($coach) ? $coach->coach_contact_number : '') }}"
                                    class="contact-number w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="col-span-2 flex items-center">
                                <label for="coach_address" class="w-1/6 text-gray-700 font-medium">Address</label>
                                <input type="text" id="coach_address" name="coach_address" placeholder="Enter Address"
                                    value="{{ old('coach_address', isset($coach) ? $coach->coach_address : '') }}"
                                    class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>
                        </div>

                        <!-- 6th Row -->
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div class="flex items-center">
                                <label for="coach_city_municipality" class="w-1/3 text-gray-700 font-medium">City / Municipality</label>
                                <input type="text" id="coach_city_municipality" name="coach_city_municipality" placeholder="Enter City/Municipality"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="flex items-center">
                                <label for="coach_province_state" class="w-1/3 text-gray-700 font-medium">Province / State</label>
                                <input type="text" id="coach_province_state" name="coach_province_state" placeholder="Enter Province/State"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="flex items-center">
                                <label for="coach_zip_code" class="w-1/3 text-gray-700 font-medium">Zip Code</label>
                                <input type="text" id="coach_zip_code" name="coach_zip_code" placeholder="Enter Zip Code"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>
                        </div>

                        <hr class="border-t-2 border-gray-400 my-2 w-[100%]">

                        <!-- 7th Row -->
                        <div class="grid grid-cols-2 gap-4 mb-4">

                            <div class="flex items-center gap-2">
                                <label for="coach_emergency_person" class="w-24 text-gray-700 font-medium">
                                    Emergency Contact Person
                                </label>
                                <input type="text" id="coach_emergency_person" name="coach_emergency_person"
                                    placeholder="Enter Contact Person"
                                    class="flex-1 border border-gray-300 rounded px-3 py-2 
                                        focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="flex items-center gap-2">
                                <label for="coach_emergency_contact" class="w-24 text-gray-700 font-medium">
                                    Contact No.
                                </label>
                                <input type="text" id="coach_emergency_contact" name="coach_emergency_contact"
                                    placeholder="Enter Contact Number"
                                    class="contact-number flex-1 border border-gray-300 rounded px-3 py-2 
                                        focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                        </div>


                        <hr class="border-t-2 border-gray-400 my-2 w-[100%]">

                        <!-- 8th Row -->
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div class="flex items-center">
                                <label for="post_graduate" class="w-1/3 text-gray-700 font-medium">Name of Post Graduate School</label>
                                <input type="text" id="post_graduate" name="post_graduate" placeholder="Enter Name of Post Graduate School"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="flex items-center">
                                <label for="course_graduated" class="w-1/3 text-gray-700 font-medium">Course Graduated</label>
                                <input type="text" id="course_graduated" name="course_graduated" placeholder="Enter Course Graduated"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="flex items-center">
                                <label for="coach_year_graduated" class="w-1/3 text-gray-700 font-medium">Year Graduated</label>
                                <input type="date" id="coach_year_graduated" name="coach_year_graduated" placeholder="Enter Year Graduated"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>
                        </div>

                        <!-- 9th Row -->
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div class="flex items-center">
                                <label for="name_collage" class="w-1/3 text-gray-700 font-medium">Name of Collage School</label>
                                <input type="text" id="name_collage" name="name_collage" placeholder="Enter Name of Collage School"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="flex items-center">
                                <label for="coach_course_graduated" class="w-1/3 text-gray-700 font-medium">Course Graduated</label>
                                <input type="text" id="coach_course_graduated" name="coach_course_graduated" placeholder="Enter Course Graduated"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="flex items-center">
                                <label for="coach_graduated" class="w-1/3 text-gray-700 font-medium">Year Graduated</label>
                                <input type="date" id="coach_graduated" name="coach_graduated" placeholder="Enter Year Graduated"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>
                        </div>

                        <hr class="border-t-2 border-gray-400 my-2 w-[100%]">

                        <!-- 10th Row -->
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div class="flex items-center">
                                <label for="coach_highschool" class="w-1/3 text-gray-700 font-medium">Name of Highschool</label>
                                <input type="text" id="coach_highschool" name="coach_highschool" placeholder="Enter Name of Highschool"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="flex items-center">
                                <label for="strand_graduated" class="w-1/3 text-gray-700 font-medium">Strand Graduated</label>
                                <input type="text" id="strand_graduated" name="strand_graduated" placeholder="Enter Strand Graduated"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="flex items-center">
                                <label for="highschool_graduated" class="w-1/3 text-gray-700 font-medium">Year Graduated</label>
                                <input type="date" id="highschool_graduated" name="highschool_graduated" placeholder="Enter Year Graduated"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>
                        </div>

                        <!-- 11th Row -->
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div class="flex items-center">
                                <label for="date_hired" class="w-1/3 text-gray-700 font-medium">Date Hired</label>
                                <input type="date" id="date_hired" name="date_hired" placeholder="Enter Date Hired"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="flex items-center">
                                <label for="honorarium_payment" class="w-1/3 text-gray-700 font-medium">Honorarium Payment</label>
                                <input type="text" id="honorarium_payment" name="honorarium_payment" placeholder="Enter Honorarium Payment"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="flex items-center">
                                <label for="date_resigned" class="w-1/3 text-gray-700 font-medium">Date Resigned</label>
                                <input type="date" id="date_resigned" name="date_resigned" 
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>
                        </div>

                        <hr class="border-t-2 border-gray-400 my-2 w-[100%]">

                        <!-- 12th Row -->
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="flex items-center">
                                <label for="occupation" class="w-1/3 text-gray-700 font-medium">Occupation</label>
                                <input type="text" id="occupation" name="occupation" placeholder="Enter Occupation"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="flex items-center">
                                <label for="coach_current_company" class="w-1/3 text-gray-700 font-medium">Current Company</label>
                                <input type="text" id="coach_current_company" name="coach_current_company" placeholder="Enter Current Company"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>
                        </div>


                        <hr class="border-t-2 border-gray-400 my-2 w-[100%]">
                    </div>

                    <!-- RIGHT SIDE WRAPPER -->
                    <div class="w-1/4 flex flex-col">

                        <!-- RIGHT SIDE: Sports Event / Picture Section -->
                        <div class="bg-gray-100 rounded-lg p-4 shadow-inner flex flex-col h-full">

                            <div class="flex flex-col items-center border border-dashed border-gray-400 rounded-lg p-3 bg-white mb-4">  
                                <span id="coach_selected_name" class="mt-2 text-gray-800 font-semibold">
                                    No Coach Selected
                                </span>
                            </div>
                            
                            <!-- Picture Preview Section -->
                            <div class="flex flex-col items-center border border-dashed border-gray-400 rounded-lg p-3 bg-white mb-4">
                                <div class="w-80 h-96 bg-gray-200 rounded-lg flex items-center justify-center text-gray-500 text-sm relative overflow-hidden">
                                    <img id="coach_picturePreview" class="absolute inset-0 w-full h-full object-cover hidden" />
                                    <span id="coach_noPictureText" class="text-gray-500 text-sm">No Picture</span>
                                </div>
                            </div>

                            <!-- Sports Event Form (Middle) -->
                            <div class="space-y-3 flex-1">
                                <div class="flex items-center">
                                    <label class="w-1/3 text-sm font-medium text-gray-700">Sports Event</label>
                                    @if(auth()->check() && auth()->user()->role === 'coach' && auth()->user()->coach_sport)
                                        <!-- Coach user: show sport from user account (read-only with hidden input) -->
                                        <input type="text" class="w-2/3 bg-blue-100 border border-gray-300 rounded px-2 py-1" 
                                            value="{{ auth()->user()->coach_sport }}" disabled>
                                        <input type="hidden" name="coach_sport_event" value="{{ auth()->user()->coach_sport }}">
                                        <span class="ml-2 text-sm text-green-600 font-semibold italic">(Assigned: {{ auth()->user()->coach_sport }})</span>
                                    @else
                                        <!-- Admin or coach without sport: show dropdown -->
                                        <select name="coach_sport_event" id="coach_sport_event" class="w-2/3 bg-blue-100 border border-gray-300 rounded px-2 py-1"
                                            {{ isset($coach) && $coach->coach_sport_event ? 'disabled' : '' }}>
                                            <option value="">-- Select Sport Event --</option>
                                            <option value="Basketball" {{ isset($coach) && $coach->coach_sport_event === 'Basketball' ? 'selected' : '' }}>Basketball</option>
                                            <option value="Volleyball" {{ isset($coach) && $coach->coach_sport_event === 'Volleyball' ? 'selected' : '' }}>Volleyball</option>
                                            <option value="Athletics" {{ isset($coach) && $coach->coach_sport_event === 'Athletics' ? 'selected' : '' }}>Athletics</option>
                                            <option value="Swimming" {{ isset($coach) && $coach->coach_sport_event === 'Swimming' ? 'selected' : '' }}>Swimming</option>
                                            <option value="Taekwondo" {{ isset($coach) && $coach->coach_sport_event === 'Taekwondo' ? 'selected' : '' }}>Taekwondo</option>
                                            <option value="Chess" {{ isset($coach) && $coach->coach_sport_event === 'Chess' ? 'selected' : '' }}>Chess</option>
                                            <option value="Football" {{ isset($coach) && $coach->coach_sport_event === 'Football' ? 'selected' : '' }}>Football</option>
                                            <option value="Boxing" {{ isset($coach) && $coach->coach_sport_event === 'Boxing' ? 'selected' : '' }}>Boxing</option>
                                        </select>
                                        @if(isset($coach) && $coach->coach_sport_event)
                                            <input type="hidden" name="coach_sport_event" value="{{ $coach->coach_sport_event }}">
                                            <span class="ml-2 text-sm text-gray-600 italic">(Locked: {{ $coach->coach_sport_event }})</span>
                                        @endif
                                    @endif
                                </div>

                                <script>
                                    document.addEventListener('DOMContentLoaded', () => {
                                        const isCoachWithProfile = {{ auth()->check() && auth()->user()->role === 'coach' && isset($coach) ? 'true' : 'false' }};
                                        if (!isCoachWithProfile) return;

                                        // Disable all inputs/selects/textareas initially for coach users who already have profile
                                        const form = document.getElementById('coachForm');
                                        if (form) {
                                            form.querySelectorAll('input,select,textarea,button').forEach(el => {
                                                // Keep the Edit button enabled
                                                if (el.id === 'coach_editBtn') return;
                                                // keep Cancel/New or other admin buttons unchanged
                                                if (el.id === 'coach_saveBtn') return;
                                                // disable form controls (but not hidden inputs)
                                                if (el.type !== 'hidden') el.disabled = true;
                                            });

                                            const editBtn = document.getElementById('coach_editBtn');
                                            const updateBtn = document.getElementById('coach_updateBtn');

                                            editBtn?.addEventListener('click', () => {
                                                // enable inputs for editing
                                                form.querySelectorAll('input,select,textarea').forEach(el => {
                                                    if (el.type !== 'hidden') el.disabled = false;
                                                });
                                                // swap buttons
                                                editBtn.classList.add('hidden');
                                                updateBtn.classList.remove('hidden');
                                                // mark method as PUT
                                                document.getElementById('coach_method').value = 'PUT';
                                            });

                                            updateBtn?.addEventListener('click', (e) => {
                                                // Gather and send via existing performFinalSave
                                                performFinalSave(e);
                                            });
                                        }
                                    });
                                </script>

                                <div class="flex items-center mt-2">
                                    <label class="w-1/3 text-sm font-medium text-gray-700">Positon</label>
                                    <select name="position" class="w-2/3 bg-blue-100 border border-gray-300 rounded px-2 py-1">
                                        <option value="">-- Select Position --</option>
                                        <option value="Head Coach">Head Coach</option>
                                        <option value="Assistant Coach">Assistant Coach</option>
                                        <option value="Trainer">Trainer</option>
                                        <option value="Physiotherapist">Physiotherapist</option>
                                        <option value="Manager">Manager</option>
                                        <option value="Scout">Scout</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>

                                <div class="flex items-center mt-2">
                                    <label class="w-1/3 text-sm font-medium text-gray-700">Status</label>
                                    <select name="coach_status" class="w-2/3 bg-blue-100 border border-gray-300 rounded px-2 py-1">
                                        <option value="">-- Select Status --</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                        <option value="Transfered">Transfered</option>
                                        <option value="Graduated">Graduated</option>
                                    </select>
                                </div>

                                <div class="flex justify-between mt-6">
                                    <input type="file" id="coach_pictureInput" name="coach_picture" accept="image/*" class="hidden">

                                    <button type="button" id="addPictureBtn"
                                        class="bg-green-700 text-white font-semibold rounded px-3 py-1 flex items-center gap-1 hover:bg-green-800 transition">
                                        <i class="bi bi-person-plus"></i> Add Picture
                                    </button>

                                    <button type="button" id="coach_clearPictureBtn"
                                        class="bg-green-700 text-white font-semibold rounded px-3 py-1 flex items-center gap-1 hover:bg-green-800 transition">
                                        <i class="bi bi-person-x"></i> Clear Picture
                                    </button>
                                </div>

                                <div class="flex items-center mt-4">
                                    <label class="w-1/3 text-sm font-medium text-gray-700">Date Inactive</label>
                                    <input type="date" name="coach_inactive_date" class="w-2/3 border border-gray-300 rounded px-2 py-1" autocomplete="off">
                                </div>
                            </div>
                        </div>

                    </form>

                </div>

            </div>
            <!-- Note Section -->
            <div id="coach_tab-content" >
                <div class="bg-white p-6 flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-3xl font-bold text-gray-800 mb-0">Coaches Notes</p>
                        <hr class="border-t-2 border-gray-400 my-2  w-[100%]">
                        <textarea type="text" name="coach_notes" class="w-2/3 border border-gray-300 rounded px-2 py-1 h-52 w-full" autocomplete="off">{{ isset($coach) ? $coach->coach_notes : '' }}</textarea>
                    </div>
                </div>
            </div>

        </div>

        <!-- ========================================================================================= -->
        <!-- Coach Achievements Content -->
        <div id="coach-achievements" class="tab-content hidden">
            <div class="space-y-6">
                <!-- PAGE HEADER -->
                <div class="bg-white p-6 shadow flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-800">Achievements</h1>
                    <button onclick="toggleCoachAchievementModal(true)"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 shadow">
                        + Add Achievement
                    </button>
                </div>

                <!-- Achievements Table -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-green-600 text-white text-center">
                            <tr>
                                <th class="px-6 py-3 font-medium">Year</th>
                                <th class="px-6 py-3 font-medium">Month-Day</th>
                                <th class="px-6 py-3 font-medium">Sports Event</th>
                                <th class="px-6 py-3 font-medium">Venue</th>
                                <th class="px-6 py-3 font-medium">Award</th>
                                <th class="px-6 py-3 font-medium">Category</th>
                                <th class="px-6 py-3 font-medium">Remarks</th>
                            </tr>
                        </thead>
                        <tbody id="coach-achievements-tbody">
                            <!-- Data will be loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal -->
            <div id="coach-AchievementModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-[#2e4e1f] rounded-xl shadow-xl w-full max-w-lg p-6 relative">
                    <button onclick="toggleCoachAchievementModal(false)" 
                            class="absolute top-3 right-3 text-white hover:text-gray-400 text-xl">
                        ✕
                    </button>
                    <h2 class="text-2xl font-semibold text-white text-center mb-4">Add Achievement</h2>
                    
                    <form id="coach-achievementForm">
                        @csrf
                        <input type="hidden" name="coach_id" id="coach_id" value="">
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-white mb-1">Year</label>
                                <input type="text" name="year" class="w-full border rounded px-3 py-2 text-sm" placeholder="2024">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-white mb-1">Month-Day</label>
                                <input type="text" name="month_day" class="w-full border rounded px-3 py-2 text-sm" placeholder="Mar-15">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-white mb-1">Sports Event</label>
                                <input type="text" name="sports_event" class="w-full border rounded px-3 py-2 text-sm" placeholder="Basketball Tournament">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-white mb-1">Venue</label>
                                <input type="text" name="venue" class="w-full border rounded px-3 py-2 text-sm" placeholder="City Gym">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-white mb-1">Award</label>
                                <select name="award" class="w-full border rounded px-3 py-2 text-sm">
                                    <option value="">Select Award</option>
                                    <option value="Coach of the Year">Coach of the Year</option>
                                    <option value="Best Performance">Best Performance</option>
                                    <option value="Team Excellence">Team Excellence</option>
                                    <option value="Achievement in Sports">Achievement in Sports</option>
                                    <option value="Lifetime Achievement">Lifetime Achievement</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-white mb-1">Category</label>
                                <input type="text" name="category" class="w-full border rounded px-3 py-2 text-sm" placeholder="Regional">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-white mb-1">Remarks</label>
                                <textarea name="remarks" rows="3" class="w-full border rounded px-3 py-2 text-sm" placeholder="Additional notes..."></textarea>
                            </div>
                        </div>
                        
                        <button type="submit" class="bg-green-600 text-white w-full py-2 rounded-lg hover:bg-green-700 mt-4 font-medium">
                            Save Achievement
                        </button>
                    </form>
                </div>
            </div>
        </div>


        <!-- ========================================================================================= -->
        <!-- Coach Assigned Schedule / Atheletes Content -->
        <div id="assigned-schedule-athletes" class="tab-content hidden">
            <div class="space-y-6">

                <!-- PAGE HEADER -->
                <div class="bg-white p-6 shadow flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-800">Assigned Schedule / Athletes</h1>

                    <button onclick="toggleScheduleModal(true)"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 shadow">
                        + Add Record
                    </button>
                </div>

                <!-- SUBJECT TABLE -->
                <div>
                    <table class="w-full text-left">
                        <thead class="bg-green-600 text-white text-center">
                            <tr>
                                <th class="py-3 border border-gray-300" rowspan="2">Term</th>
                                <th class="py-3 border border-gray-300" rowspan="2">Academic Year</th>
                                <th class="py-3 border border-gray-300" colspan="3">Total Number of Athletes</th>
                                <th class="py-3 border border-gray-300" rowspan="2">Remarks</th>
                            </tr>
                            <tr>
                                <th class="py-2 border border-gray-300">A</th>
                                <th class="py-2 border border-gray-300">B</th>
                                <th class="py-2 border border-gray-300">C</th>
                            </tr>
                        </thead>

                        <tbody id="scheduleTable" class="text-gray-700">
                            
                        </tbody>
                    </table>
                </div>

            </div>

            <!-- ADD SUBJECT MODAL -->
            <div id="scheduleModal" 
                class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

                <div class="bg-[#2e4e1f] rounded-xl shadow-xl w-full max-w-lg p-6 relative">

                    <button onclick="toggleScheduleModal(false)" 
                            class="absolute top-3 right-3 text-white hover:text-red-700">
                        ✕
                    </button>

                    <h2 class="text-xl font-bold mb-4 text-white">Add Schedule an Athlete</h2>

                    <form id="ScheduleForm" class="space-y-4">

                        <!-- TERM -->
                        <div>
                            <label class="text-white font-medium">Term</label>
                            <input type="text" class="w-full border border-gray-300 rounded px-3 py-2"
                                name="term" placeholder="e.g., 1st Term">
                        </div>

                        <!-- ACADEMIC YEAR -->
                        <div>
                            <label class="text-white font-medium">Academic Year</label>
                            <input type="text" class="w-full border border-gray-300 rounded px-3 py-2"
                                name="academic_year" placeholder="e.g., 2024 - 2025">
                        </div>

                        <!-- TOTAL NUMBER OF ATHLETES -->
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="text-white font-medium">Class A</label>
                                <input type="number" class="w-full border border-gray-300 rounded px-3 py-2"
                                    name="count_a" placeholder="0">
                            </div>
                            <div>
                                <label class="text-white font-medium">Class B</label>
                                <input type="number" class="w-full border border-gray-300 rounded px-3 py-2"
                                    name="count_b" placeholder="0">
                            </div>
                            <div>
                                <label class="text-white font-medium">Class C</label>
                                <input type="number" class="w-full border border-gray-300 rounded px-3 py-2"
                                    name="count_c" placeholder="0">
                            </div>
                        </div>

                        <!-- REMARKS -->
                        <div>
                            <label class="text-white font-medium">Remarks</label>
                            <input type="text" class="w-full border border-gray-300 rounded px-3 py-2"
                                name="remarks" placeholder="Any notes or remark">
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="bg-green-600 text-white w-full py-2 rounded-lg hover:bg-green-700">
                            Save Record
                        </button>

                    </form> 

                </div> 

            </div> 
        </div>

        <!-- ========================================================================================= -->
        <!-- Coach Expenses and Payments Content -->
        <div id="expenses-payments" class="tab-content hidden">
            <div class="space-y-6">

                <!-- PAGE HEADER -->
                <div class="bg-white p-6 shadow flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-800">Assigned Schedule / Athletes</h1>

                    <button onclick="toggleExpensesModal(true)"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 shadow">
                        + Add Record
                    </button>
                </div>

                <!-- SUBJECT TABLE -->
                <div>
                    <table class="w-full text-left">
                        <thead class="bg-green-600 text-white text-center">
                            <tr>
                                <th class="py-3">Year</th>
                                <th class="py-3">Date</th>
                                <th class="py-3">Title of Activity</th>
                                <th class="py-3">Estimate Budget</th>
                                <th class="py-3">Actual Budget</th>
                                <th class="py-3">Variance</th>
                                <th class="py-3">Remarks</th>
                            </tr>
                        </thead>

                        <tbody id="expensesTable" class="text-gray-700">
                            
                        </tbody>
                    </table>
                </div>

            </div>

            <!-- ADD EXPENSES MODAL -->
            <div id="expensesModal" 
                class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

                <div class="bg-[#2e4e1f] rounded-xl shadow-xl w-full max-w-lg p-6 relative">

                    <button onclick="toggleExpensesModal(false)" 
                            class="absolute top-3 right-3 text-white hover:text-red-700">
                        ✕
                    </button>

                    <h2 class="text-xl font-bold mb-4 text-white">Add Expenses</h2>

                    <form id="ExpensesForm" class="space-y-4">

                        <div>
                            <label class="text-white font-medium">Year</label>
                            <input type="text" class="w-full border rounded px-3 py-2" 
                                name="year" placeholder="Year">
                        </div>

                        <div>
                            <label class="text-white font-medium">Date</label>
                            <input type="date" class="w-full border rounded px-3 py-2" 
                                name="date" placeholder="Term">
                        </div>

                        <div>
                            <label class="text-white font-medium">Title of Activity</label>
                            <input type="text" class="w-full border rounded px-3 py-2" 
                                name="title" placeholder="Title of Activity">
                        </div>

                        <div>
                            <label class="text-white font-medium">Estimate Budget</label>
                            <input type="number" class="w-full border rounded px-3 py-2" 
                                name="estimate" placeholder="Estimate Budget">
                        </div>
                        
                        <div>
                            <label class="text-white font-medium">Actual Budget</label>
                            <input type="text" class="w-full border rounded px-3 py-2" 
                                name="actual" placeholder="Actual Budget">
                        </div>

                        <div>
                            <label class="text-white font-medium">Variance</label>
                            <input type="text" class="w-full border rounded px-3 py-2" 
                                name="variance" placeholder="Variance">
                        </div>

                        <div>
                            <label class="text-white font-medium">Remarks</label>
                            <input type="text" class="w-full border rounded px-3 py-2" 
                                name="remark" placeholder="Input Remark">
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="bg-green-600 text-white w-full py-2 rounded-lg hover:bg-green-700">
                            Save Record
                        </button>

                    </form> 

                </div> 

            </div> 
        </div>

        <!-- ========================================================================================= -->
        <!-- Coach Membership Content -->
        <div id="membership" class="tab-content hidden">
            <div class="space-y-6">

                <!-- PAGE HEADER -->
                <div class="bg-white p-6 shadow flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-800">Membership</h1>

                    <button onclick="toggleMembershipModal(true)"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 shadow">
                        + Add Record
                    </button>
                </div>

                <!-- SUBJECT TABLE -->
                <div>
                    <table class="w-full text-left">
                        <thead class="bg-green-600 text-white text-center">
                            <tr>
                                <th class="py-3">Year</th>
                                <th class="py-3">Date</th>
                                <th class="py-3">Venue</th>
                                <th class="py-3">Name of organization</th>
                                <th class="py-3">Level</th>
                                <th class="py-3">Position</th>
                                <th class="py-3">Remarks</th>
                            </tr>
                        </thead>

                        <tbody id="membershipTable" class="text-gray-700">
                            
                        </tbody>
                    </table>
                </div>

            </div>

            <!-- ADD Membership MODAL -->
            <div id="membershipModal" 
                class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

                <div class="bg-[#2e4e1f] rounded-xl shadow-xl w-full max-w-lg p-6 relative">

                    <button onclick="toggleMembershipModal(false)" 
                            class="absolute top-3 right-3 text-white hover:text-red-700">
                        ✕
                    </button>

                    <h2 class="text-xl font-bold mb-4 text-white text-center">Add Membership</h2>

                    <form id="MembershipForm" class="space-y-4">

                        <div>
                            <label class="text-white font-medium">Year</label>
                            <input type="text" class="w-full border rounded px-3 py-2" 
                                name="year" placeholder="Year">
                        </div>

                        <div>
                            <label class="text-white font-medium">Date</label>
                            <input type="date" class="w-full border rounded px-3 py-2" 
                            name="date" placeholder="Date">
                        </div>

                        <div>
                            <label class="text-white font-medium">Venue</label>
                            <input type="text" class="w-full border rounded px-3 py-2" 
                                name="venue" placeholder="Venue">
                        </div>

                        <div>
                            <label class="text-white font-medium">Name of Organization</label>
                            <input type="text" class="w-full border rounded px-3 py-2" 
                                name="organization" placeholder="Name of Organization">
                        </div>
                        
                        <div>
                            <label class="text-white font-medium">Level</label>
                            <input type="text" class="w-full border rounded px-3 py-2" 
                                name="level" placeholder="Level">
                        </div>

                        <div>
                            <label class="text-white font-medium">Position</label>
                            <input type="text" class="w-full border rounded px-3 py-2" 
                                name="position" placeholder="Position">
                        </div>

                        <div>
                            <label class="text-white font-medium">Remarks</label>
                            <input type="text" class="w-full border rounded px-3 py-2" 
                                name="remark" placeholder="Remarks">
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="bg-green-600 text-white w-full py-2 rounded-lg hover:bg-green-700">
                            Save Record
                        </button>

                    </form> 

                </div> 

            </div> 
        </div>

        <!-- ========================================================================================= -->
        <!-- Coach Seminars Content -->
        <div id="seminars" class="tab-content hidden">
            <div class="space-y-6">

                <!-- PAGE HEADER -->
                <div class="bg-white p-6 shadow flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-800">Seminars</h1>

                    <button onclick="toggleSeminarsModal(true)"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 shadow">
                        + Add Record
                    </button>
                </div>

                <!-- SUBJECT TABLE -->
                <div>
                    <table class="w-full text-left">
                        <thead class="bg-green-600 text-white text-center">
                            <tr>
                                <th class="py-3">Year</th>
                                <th class="py-3">Date</th>
                                <th class="py-3">Venue</th>
                                <th class="py-3">Title of Seminar / Workshop</th>
                                <th class="py-3">Level</th>
                                <th class="py-3">Remarks</th>
                            </tr>
                        </thead>

                        <tbody id="seminarsTable" class="text-gray-700">
                            
                        </tbody>
                    </table>
                </div>

            </div>

            <!-- ADD Membership MODAL -->
            <div id="seminarsModal" 
                class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

                <div class="bg-[#2e4e1f] rounded-xl shadow-xl w-full max-w-lg p-6 relative">

                    <button onclick="toggleSeminarsModal(false)" 
                            class="absolute top-3 right-3 text-white hover:text-red-700">
                        ✕
                    </button>

                    <h2 class="text-xl font-bold mb-4 text-white text-center">Add Seminars</h2>

                    <form id="SeminarsForm" class="space-y-4">

                        <div>
                            <label class="text-white font-medium">Year</label>
                            <input type="text" class="w-full border rounded px-3 py-2" 
                                name="year" placeholder="Seminar Year">
                        </div>

                        <div>
                            <label class="text-white font-medium">Date</label>
                            <input type="date" class="w-full border rounded px-3 py-2" 
                            name="date" placeholder="Seminar Date">
                        </div>

                        <div>
                            <label class="text-white font-medium">Venue</label>
                            <input type="text" class="w-full border rounded px-3 py-2" 
                                name="venue" placeholder="Venue">
                        </div>

                        <div>
                            <label class="text-white font-medium">Title of Seminar / Workshop</label>
                            <input type="text" class="w-full border rounded px-3 py-2" 
                                name="seminar" placeholder="Title of Seminar / Workshop">
                        </div>
                            <label class="text-white font-medium">Level</label>
                            <input type="text" class="w-full border rounded px-3 py-2" 
                                name="level" placeholder="Level">
                        <div>

                        </div>

                        <div>
                            <label class="text-white font-medium">Remarks</label>
                            <input type="text" class="w-full border rounded px-3 py-2" 
                                name="remark" placeholder="Remarks">
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="bg-green-600 text-white w-full py-2 rounded-lg hover:bg-green-700">
                            Save Record
                        </button>

                    </form> 

                </div> 

            </div> 
        </div>

        <!-- ========================================================================================= -->
        <!-- Coach Work History Content -->
        <div id="coach-work-history" class="tab-content hidden">
            <div class="space-y-6">

                <!-- PAGE HEADER -->
                <div class="bg-white p-6 shadow flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-800">Work History</h1>

                    <button onclick="toggleWorkHistoryModal(true)"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 shadow">
                        + Add Record
                    </button>
                </div>

                <!-- SUBJECT TABLE -->
                <div>
                    <table class="w-full text-left">
                        <thead class="bg-green-600 text-white text-center">
                            <tr>
                                <th class="py-3">Year</th>
                                <th class="py-3">Date</th>
                                <th class="py-3">Work position</th>
                                <th class="py-3">Name of Company</th>
                                <th class="py-3">Remarks</th>
                            </tr>
                        </thead>

                        <tbody id="workTable" class="text-gray-700">
                            
                        </tbody>
                    </table>
                </div>

            </div>

            <!-- ADD Work History MODAL -->
            <div id="workModal" 
                class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

                <div class="bg-[#2e4e1f] rounded-xl shadow-xl w-full max-w-lg p-6 relative">

                    <button onclick="toggleWorkHistoryModal(false)" 
                            class="absolute top-3 right-3 text-white hover:text-red-700">
                        ✕
                    </button>

                    <h2 class="text-xl font-bold mb-4 text-white text-center">Add Seminars</h2>

                    <form id="WorkHistoryForm" class="space-y-4">

                        <div>
                            <label class="text-white font-medium">Year</label>
                            <input type="date" class="w-full border rounded px-3 py-2" 
                                name="year" placeholder="Seminar Year">
                        </div>

                        <div>
                            <label class="text-white font-medium">Date</label>
                            <input type="date" class="w-full border rounded px-3 py-2" 
                            name="date" placeholder="Seminar Date">
                        </div>

                        <div>
                            <label class="text-white font-medium">Work Position</label>
                            <input type="text" class="w-full border rounded px-3 py-2" 
                                name="work_position" placeholder="Work Position">
                        </div>

                        <div>
                            <label class="text-white font-medium">Name of Company</label>
                            <input type="text" class="w-full border rounded px-3 py-2" 
                                name="company" placeholder="Name of Company">
                        </div>

                        <div>
                            <label class="text-white font-medium">Remarks</label>
                            <input type="text" class="w-full border rounded px-3 py-2" 
                                name="remark" placeholder="Input Remark">
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="bg-green-600 text-white w-full py-2 rounded-lg hover:bg-green-700">
                            Save Record
                        </button>

                    </form> 

                </div> 

            </div>
        </div>

        <!-- ========================================================================================= -->
        <!-- Coach Attachments Content -->
        <div id="coach-attachments" class="tab-content hidden">
            <p>This is the attachments.</p>
        </div>

        <!-- ========================================================================================= -->
        <!-- Coach's ID Content -->
        <div id="coach-id" class="tab-content hidden">
            <p>This is the coach's ID.</p>
        </div>

    </div>
</div>    

    <script>
        window.currentUserRole = '{{ auth()->check() ? auth()->user()->role : '' }}';
        window.currentCoachId = '{{ auth()->check() ? auth()->user()->coach_id : '' }}';
        window.hasCoachProfile = {{ (auth()->check() && auth()->user()->role === 'coach' && isset($coach) && $coach) ? 'true' : 'false' }};

document.addEventListener('DOMContentLoaded', () => {
    // Helper functions
    const byId = id => document.getElementById(id);
    const log = (label, data) => console.log(`🔍 ${label}:`, JSON.parse(JSON.stringify(data || {})));

    // Load available sports (filter out already assigned ones)
    async function loadAvailableSports() {
        try {
            const response = await fetch('{{ route('coaches.available-sports') }}');
            const data = await response.json();
            const sportSelect = byId('coach_sport_event');
            
            if (sportSelect && !sportSelect.disabled) {
                // Get all existing options except the placeholder
                const allOptions = Array.from(sportSelect.querySelectorAll('option')).slice(1);
                const allSports = allOptions.map(opt => opt.value);
                
                // Update visibility based on available sports
                allOptions.forEach(option => {
                    if (data.available.includes(option.value)) {
                        option.style.display = '';
                    } else {
                        option.style.display = 'none';
                    }
                });
            }
        } catch (error) {
            console.error('Error loading available sports:', error);
        }
    }

    // Call on page load
    loadAvailableSports();

    // Global data store
    window.newCoachData = {
        generalInfo: {},
        achievements: [],
        schedule: [],      
        expenses: [],
        memberships: [],
        seminars: [],
        workHistory: []    
    };

    // Auto-load logged-in coach data for coaches
if (window.currentUserRole === 'coach' && window.currentCoachId) {
    const generalForm = document.getElementById('coachForm');
    const updateBase = '{{ url('/coaches') }}';

    fetch(`${updateBase}/${window.currentCoachId}`, {
        headers: { 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(full => {
        if (!full) return;

        console.log('Coach data loaded:', full); // DEBUG LOG

        // 1. TEXT/NUMBER INPUTS (explicit mapping)
        const fieldMap = {
            'coach_last_name': 'coach_last_name',
            'coach_first_name': 'coach_first_name',
            'coach_middle_initial': 'coach_middle_initial',
            'coach_age': 'coach_age',
            'coach_blood_type': 'coach_blood_type',
            'coach_place_of_birth': 'coach_place_of_birth',
            'coach_email': 'coach_email',
            'coach_facebook': 'coach_facebook',
            'coach_tba': 'coach_tba',
            'coach_contact_number': 'coach_contact_number',
            'coach_address': 'coach_address',
            'coach_city_municipality': 'coach_city_municipality',
            'coach_province_state': 'coach_province_state',
            'coach_zip_code': 'coach_zip_code',
            'coach_emergency_person': 'coach_emergency_person',
            'coach_emergency_contact': 'coach_emergency_contact',
            'post_graduate': 'post_graduate',
            'course_graduated': 'course_graduated',
            'name_collage': 'name_collage',
            'coach_course_graduated': 'coach_course_graduated',
            'coach_highschool': 'coach_highschool',
            'strand_graduated': 'strand_graduated',
            'date_hired': 'date_hired',
            'honorarium_payment': 'honorarium_payment',
            'occupation': 'occupation',
            'coach_current_company': 'coach_current_company',
            'coach_notes': 'coach_notes'
        };

        for (const [dbField, formField] of Object.entries(fieldMap)) {
            const el = generalForm?.querySelector(`[name="${formField}"]`);
            if (el && el.type !== 'file' && el.tagName !== 'SELECT') {
                el.value = full[dbField] ?? '';
            }
        }

        // 2. SELECT DROPDOWNS (gender, marital status, etc.)
        const selectFields = ['coach_gender', 'coach_marital_status', 'coach_sport_event', 'position', 'coach_status'];
        selectFields.forEach(field => {
            const el = generalForm?.querySelector(`[name="${field}"]`);
            if (el && full[field]) {
                el.value = full[field];
                el.dispatchEvent(new Event('change')); // Trigger any event listeners
            }
        });

        // 3. DATE FIELDS (ensure Y-m-d format)
        const dateFields = ['coach_birthdate', 'coach_year_graduated', 'coach_graduated', 'highschool_graduated', 'date_hired', 'date_resigned', 'coach_inactive_date'];
        dateFields.forEach(field => {
            const el = generalForm?.querySelector(`[name="${field}"]`);
            if (el && full[field]) {
                const date = new Date(full[field]);
                if (!isNaN(date.getTime())) {
                    el.value = date.toISOString().split('T')[0];
                } else {
                    el.value = full[field]; // Already formatted
                }
            }
        });

        // 4. PICTURE
        if (full.picture_url) {
            const preview = byId('coach_picturePreview');
            const noPic = byId('coach_noPictureText');
            if (preview) { 
                preview.src = full.picture_url; 
                preview.classList.remove('hidden'); 
            }
            if (noPic) noPic.classList.add('hidden');
        }

        // 5. SELECTED NAME DISPLAY
        const selectedName = byId('coach_selected_name');
        const fullName = full.coach_first_name && full.coach_last_name 
            ? `${full.coach_first_name} ${full.coach_last_name}`.trim() 
            : 'No Coach Selected';
        if (selectedName) selectedName.textContent = fullName;

        // 6. SHOW UPDATE BUTTON
        byId('coach_saveBtn')?.classList.add('hidden');
        byId('coach_updateBtn')?.classList.remove('hidden');
        byId('coach_method').value = 'PUT';
        byId('selected_coach_id').value = window.currentCoachId;

        // 7. POPULATE RELATED TABLES
        window.newCoachData = {
            generalInfo: {},
            achievements: full.achievements || [],
            schedule: full.schedule || [],
            expenses: full.expenses || [],
            memberships: full.memberships || [],
            seminars: full.seminars || [],
            workHistory: full.workHistories || []
        };

        // Populate tables
        populateTable('coach-achievements-tbody', full.achievements, {
            year: 'Year', month_day: 'Month-Day', sports_event: 'Sports Event', 
            venue: 'Venue', award: 'Award', category: 'Category', remarks: 'Remarks'
        });

        populateTable('scheduleTable', full.schedule, {
            term: 'Term', academic_year: 'Academic Year', count_a: 'A',count_b: 'B',count_c: 'C', coachRemark: 'Remarks'
        });

        populateTable('expensesTable', full.expenses, {
            year: 'Year', date: 'Date', title: 'Title of Activity', estimate: 'Estimate Budget',
            actual: 'Actual Budget', variance: 'Variance', remark: 'Remarks'
        });

        populateTable('membershipTable', full.memberships, {
            year: 'Year', date: 'Date', venue: 'Venue',
            organization: 'Name of Organization', level: 'Level', position: 'Position',
            remark: 'Remarks'
        });

        populateTable('seminarsTable', full.seminars, {
            year: 'Year', date: 'Date', venue: 'venue', seminar: 'Title of Seminar / Workshop', level: 'Level', remark: 'Remarks'
        });

        populateTable('workTable', full.workHistories, {
            year: 'Year', date: 'Date', work_position: 'Position', company: 'Company', remark: 'Remarks'
        });
    })
    .catch(err => console.error('❌ Failed to auto-load coach data:', err));
}


    // -----------------------
    // LIVE SEARCH
    // -----------------------
    (function initLiveSearch() {
        const searchInput = byId('coach_search');
        const resultsBox = byId('coach_searchResults');
        if (!searchInput || !resultsBox) return;

        const searchUrl = '{{ route('coaches.search') }}';
        const updateBase = '{{ url('/coaches') }}';
        const generalForm = byId('coachForm');
        const methodInput = byId('coach_method');
        const selectedCoachIdInput = byId('selected_coach_id');
        const saveBtn = byId('coach_saveBtn');
        const updateBtn = byId('coach_updateBtn');
        const defaultAction = generalForm?.getAttribute('action') || '{{ route('coaches.store') }}';

        let timer = null;
        let selectedFromSearch = false;
        let selectedId = null;

        function clearResults() {
            resultsBox.innerHTML = '';
            resultsBox.classList.add('hidden');
        }

        function clearSelection() {
            if (!generalForm) return;

            // Clear form fields
            generalForm.querySelectorAll('input[name], select[name], textarea[name]').forEach(el => {
                if (['_method', '_token', 'selected_coach_id'].includes(el.name)) return;
                if (el.type === 'file') {
                    el.value = '';
                    const preview = byId('coach_picturePreview');
                    if (preview) { preview.src = ''; preview.classList.add('hidden'); }
                    byId('coach_noPictureText')?.classList.remove('hidden');
                } else if (el.tagName === 'SELECT') {
                    el.selectedIndex = 0;
                } else {
                    el.value = '';
                }
            });

            byId('coach_selected_name').textContent = 'No Coach Selected';
            selectedFromSearch = false;
            selectedId = null;
            generalForm?.setAttribute('action', defaultAction);
            if (methodInput) methodInput.value = 'POST';
            if (selectedCoachIdInput) selectedCoachIdInput.value = '';
            saveBtn?.classList.remove('hidden');
            updateBtn?.classList.add('hidden');

            // Clear all tables
            const tableIds = ['coach-achievements-tbody', 'scheduleTable', 'expensesTable', 'membershipTable', 'seminarsTable', 'workTable'];
            tableIds.forEach(id => {
                const tbody = byId(id);
                if (tbody) tbody.innerHTML = `<tr><td colspan="100%" class="text-center py-4 text-gray-500">No data</td></tr>`;
            });

            // Reset global data
            window.newCoachData = {
                generalInfo: {},
                achievements: [],
                schedule: [],
                expenses: [],
                memberships: [],
                seminars: [],
                workHistory: []
            };
        }

        function renderResults(items) {
            if (!items?.length) {
                clearResults();
                return;
            }
            resultsBox.innerHTML = '';
            items.forEach(item => {
                const div = document.createElement('div');
                div.className = 'px-3 py-2 hover:bg-gray-100 cursor-pointer text-sm';
                const name = item.full_name?.trim() || `${item.coach_first_name || ''} ${item.coach_last_name || ''}`.trim();
                div.textContent = name + (item.id ? ` — ID: ${item.id}` : '');
                
                div.addEventListener('click', () => {
                    selectedFromSearch = true;
                    selectedId = item.id || null;
                    if (selectedCoachIdInput) selectedCoachIdInput.value = selectedId;

                    if (generalForm && selectedId) {
                        generalForm.setAttribute('action', `${updateBase}/${selectedId}`);
                        if (methodInput) methodInput.value = 'PUT';
                    }

                    // Fetch full details
                    fetch(`${updateBase}/${selectedId}`, { 
                        headers: { 'Accept': 'application/json' } 
                    })
                    .then(r => {
                        if (!r.ok) throw new Error(`HTTP ${r.status}`);
                        return r.json();
                    })
                    .then(full => {
                        log('✅ Coach data loaded', full); // Debug log

                        // Populate general info
                        for (const key in full) {
                            if (['achievements', 'schedule', 'expenses', 'memberships', 'seminars', 'workHistories'].includes(key)) continue;
                            
                            const el = generalForm?.querySelector(`[name="${key}"]`);
                            if (el && el.tagName !== 'SELECT' && el.type !== 'file') {
                                el.value = full[key] ?? '';
                            }
                        }

                        // Handle picture
                        if (full.picture_url) {
                            const preview = byId('coach_picturePreview');
                            const noPic = byId('coach_noPictureText');
                            if (preview) { 
                                preview.src = full.picture_url; 
                                preview.classList.remove('hidden'); 
                            }
                            if (noPic) noPic.classList.add('hidden');
                        }

                        // Update selected name
                        const selectedName = byId('coach_selected_name');
                        const fullName = full.full_name?.trim() || `${full.coach_first_name || ''} ${full.coach_last_name || ''}`.trim();
                        if (selectedName) selectedName.textContent = fullName || 'No Coach Selected';

                        // Clear tables first
                        const tableIds = ['coach-achievements-tbody', 'scheduleTable', 'expensesTable', 'membershipTable', 'seminarsTable', 'workTable'];
                        tableIds.forEach(id => {
                            const tbody = byId(id);
                            if (tbody) tbody.innerHTML = '';
                        });

                        // CRITICAL FIX: Map relationship names correctly
                        window.newCoachData = {
                            generalInfo: {},
                            achievements: full.achievements || [],
                            schedule: full.schedule || [],      // 'schedule' from model
                            expenses: full.expenses || [],
                            memberships: full.memberships || [],
                            seminars: full.seminars || [],
                            workHistory: full.workHistories || [] // Map plural to singular
                        };

                        log('📊 Global data ready', window.newCoachData);

                        // Populate tables with field mapping
                        populateTable('coach-achievements-tbody', full.achievements, {
                            year: 'Year', month_day: 'Month-Day', sports_event: 'Sports Event', 
                            venue: 'Venue', award: 'Award', category: 'Category', remarks: 'Remarks'
                        });

                        populateTable('scheduleTable', full.schedule, {  // Use 'schedule' not 'schedules'
                            term: 'Term', academic_year: 'Academic Year', count_a: 'A',count_b: 'B',count_c: 'C', coachRemark: 'Remarks'
                        });

                        populateTable('expensesTable', full.expenses, {
                            year: 'Year', date: 'Date', title: 'Title of Activity', estimate: 'Estimate Budget',
                            actual: 'Actual Budget', variance: 'Variance', remark: 'Remarks'
                        });

                        populateTable('membershipTable', full.memberships, {
                            year: 'Year', date: 'Date', venue: 'Venue',
                            organization: 'Name of Organization', level: 'Level', position: 'Position',
                            remark: 'Remarks'
                        });

                        populateTable('seminarsTable', full.seminars, {
                            year: 'Year', date: 'Date', venue: 'venue', seminar: 'Title of Seminar / Workshop', level: 'Level', remark: 'Remarks'
                        });

                        populateTable('workTable', full.workHistories, {  // Use 'workHistories' from model
                            year: 'Year', date: 'Date', work_position: 'Position', company: 'Company', remark: 'Remarks'
                        });

                        saveBtn?.classList.add('hidden');
                        updateBtn?.classList.remove('hidden');
                    })
                    .catch(err => {
                        console.error('❌ Failed to load coach:', err);
                        alert(`Error loading coach: ${err.message}`);
                    });

                clearResults();
            });
            resultsBox.appendChild(div);
        });
        resultsBox.classList.remove('hidden');
    }

    searchInput.addEventListener('input', (e) => {
        const value = e.target.value;
        if (timer) clearTimeout(timer);

        if (!value?.trim()) {
            if (selectedFromSearch) clearSelection();
            clearResults();
            return;
        }

        timer = setTimeout(() => {
            fetch(`${searchUrl}?q=${encodeURIComponent(value.trim())}`, { 
                headers: { 'Accept': 'application/json' } 
            })
            .then(r => r.json())
            .then(data => renderResults(data || []))
            .catch(err => {
                console.error('Search error:', err);
                clearResults();
            });
        }, 300);
    });

    // Click outside to close
    document.addEventListener('click', (e) => {
        if (!searchInput.contains(e.target) && !resultsBox.contains(e.target)) {
            clearResults();
        }
    });
    })();

    // -----------------------
    // TAB SWITCHING
    // -----------------------
    (function initTabs() {
        const tabs = document.querySelectorAll('.tab-link');
        const contents = document.querySelectorAll('.tab-content');

        const defaultTab = document.querySelector('.tab-link[href="#coach-general-info"]');
        if (defaultTab) {
            tabs.forEach(t => t.classList.remove('border-b-2', 'border-green-600', 'text-green-600'));
            contents.forEach(c => c.classList.add('hidden'));
            defaultTab.classList.add('border-b-2', 'border-green-600', 'text-green-600');
            document.querySelector('#coach-general-info')?.classList.remove('hidden');
        }

        tabs.forEach(tab => {
            tab.addEventListener('click', e => {
                e.preventDefault();
                tabs.forEach(t => t.classList.remove('border-b-2', 'border-green-600', 'text-green-600'));
                contents.forEach(c => c.classList.add('hidden'));
                tab.classList.add('border-b-2', 'border-green-600', 'text-green-600');
                document.querySelector(tab.getAttribute('href'))?.classList.remove('hidden');
            });
        });
    })();

    // -----------------------
    // MODAL TOGGLES
    // -----------------------
    window.toggleCoachAchievementModal = (show) => byId('coach-AchievementModal')?.classList.toggle('hidden', !show);
    window.toggleScheduleModal = (show) => byId('scheduleModal')?.classList.toggle('hidden', !show);
    window.toggleExpensesModal = (show) => byId('expensesModal')?.classList.toggle('hidden', !show);
    window.toggleMembershipModal = (show) => byId('membershipModal')?.classList.toggle('hidden', !show);
    window.toggleSeminarsModal = (show) => byId('seminarsModal')?.classList.toggle('hidden', !show);
    window.toggleWorkHistoryModal = (show) => byId('workModal')?.classList.toggle('hidden', !show);

    // -----------------------
    // TABLE POPULATOR
    // -----------------------
    function populateTable(tableId, dataArray, fieldMap) {
        const tbody = byId(tableId);
        if (!tbody) {
            console.error(`❌ Table body not found: ${tableId}`);
            return;
        }

        tbody.innerHTML = ''; // Clear existing

        if (!Array.isArray(dataArray) || dataArray.length === 0) {
            console.warn(`⚠️ No data for ${tableId}`);
            const colCount = Object.keys(fieldMap).length;
            tbody.innerHTML = `<tr><td colspan="${colCount}" class="text-center py-4 text-gray-500">No records found</td></tr>`;
            return;
        }

        dataArray.forEach((item, index) => {
            const row = document.createElement('tr');
            row.className = 'border-b hover:bg-gray-50 text-center';
            
            const cells = Object.entries(fieldMap).map(([key, label]) => {
                // Try multiple casing variations to handle different field names
                let value = item[key] ?? 
                           item[key.toLowerCase()] ?? 
                           item[key.replace(/([A-Z])/g, '_$1').toLowerCase()] ?? 
                           '-';
                return `<td class="border px-4 py-2 text-sm">${value}</td>`;
            }).join('');
            
            row.innerHTML = cells;
            tbody.appendChild(row);
        });

        console.log(`✅ Populated ${tableId} with ${dataArray.length} records`);
    }

    // -----------------------
    // MODULE FORM HANDLERS
    // -----------------------
    function handleModuleForm(formId, tbodyId, dataKey, fieldMap) {
        const form = byId(formId);
        const tbody = byId(tbodyId);
        if (!form || !tbody) return;

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            
            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData.entries());
            
            // Validate required fields (first field in map)
            const firstRequiredField = Object.keys(fieldMap)[0];
            if (!data[firstRequiredField]?.trim()) {
                alert('Please fill in all required fields.');
                return;
            }
            
            window.newCoachData[dataKey].push(data);
            
            const row = document.createElement('tr');
            row.className = 'border-b hover:bg-gray-50';
            const cells = Object.keys(fieldMap).map(key => 
                `<td class="border px-4 py-2 text-sm">${data[key] || '-'}</td>`
            ).join('');
            row.innerHTML = cells;
            tbody.appendChild(row);
            
            e.target.reset();
            
            // Close corresponding modal
            const modalMap = {
                achievements: 'coach-AchievementModal',
                schedule: 'scheduleModal',
                expenses: 'expensesModal',
                memberships: 'membershipModal',
                seminars: 'seminarsModal',
                workHistory: 'workModal'
            };
            const modalId = modalMap[dataKey];
            if (modalId) byId(modalId)?.classList.add('hidden');
        });
    }

    // Initialize all module forms
    handleModuleForm('coach-achievementForm', 'coach-achievements-tbody', 'achievements', {
        year: 'Year', month_day: 'Month-Day', sports_event: 'Sports Event', 
        venue: 'Venue', award: 'Award', category: 'Category', remarks: 'Remarks'
    });

    handleModuleForm('ScheduleForm', 'scheduleTable', 'schedule', {
        term: 'Term', academic_year: 'Academic Year', count_a: 'A',count_b: 'B',count_c: 'C', remarks: 'Remarks'
    });

    handleModuleForm('ExpensesForm', 'expensesTable', 'expenses', {
        year: 'Year', date: 'Date', title: 'Title of Activity', estimate: 'Estimate Budget',
        actual: 'Actual Budget', variance: 'Variance', remark: 'Remarks'
    });

    handleModuleForm('MembershipForm', 'membershipTable', 'memberships', {
        year: 'Year', date: 'Date', venue: 'Venue',
        organization: 'Name of Organization', level: 'Level', position: 'Position',
        remark: 'Remarks'
    });

    handleModuleForm('SeminarsForm', 'seminarsTable', 'seminars', {
        year: 'Year', date: 'Date', venue: 'venue', seminar: 'Title of Seminar / Workshop', level: 'Level', remark: 'Remarks'
    });

    handleModuleForm('WorkHistoryForm', 'workTable', 'workHistory', {
        year: 'Year', date: 'Date', work_position: 'Position', company: 'Company', remark: 'Remarks'
    });

    // -----------------------
    // SAVE/UPDATE COACH
    // -----------------------
    function performFinalSave(e) {
        if (e) e.preventDefault();
        
        // Collect general info from form
        const form = byId('coachForm');
        if (form) {
            form.querySelectorAll('input[name], select[name], textarea[name]').forEach(input => {
                if (input.name && !['_method', '_token'].includes(input.name)) {
                    window.newCoachData.generalInfo[input.name] = input.value;
                }
            });
        }

        const selectedId = byId('selected_coach_id')?.value;
        const updateBase = '{{ url('/coaches') }}';
        const endpoint = selectedId ? `${updateBase}/${selectedId}` : updateBase;
        const method = selectedId ? 'PUT' : 'POST';
        
        const button = e?.target;
        if (button) {
            button.disabled = true;
            button.textContent = 'Saving...';
        }
        
        log('Sending data to server', { endpoint, method, data: window.newCoachData });

        fetch(endpoint, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify(window.newCoachData)
        })
        .then(async r => {
            const text = await r.text();
            log('Raw server response', text);
            let data = null;
            try { data = JSON.parse(text); } catch (e) {}
            if (!r.ok) throw new Error(r.status === 422 && data?.errors ? 
                'Validation: ' + JSON.stringify(data.errors) : 
                `Server ${r.status}: ${text}`);
            return data;
        })
        .then(data => {
            try {
                const coachId = data?.coach?.id || data?.id;
                
                // For coach users, update UI without redirect
                if (window.currentUserRole === 'coach') {
                    if (coachId) {
                        // Update form for future updates
                        const updateBase = '{{ url('/coaches') }}';
                        byId('coachForm')?.setAttribute('action', `${updateBase}/${coachId}`);
                        byId('coach_method').value = 'PUT';
                        byId('selected_coach_id').value = coachId;
                        
                        // Swap buttons: hide Save/Edit, show Update
                        byId('coach_saveBtn')?.classList.add('hidden');
                        byId('coach_editBtn')?.classList.add('hidden');
                        byId('coach_updateBtn')?.classList.remove('hidden');
                        
                        // Update global coach ID
                        window.currentCoachId = coachId;
                        
                        // Re-enable form controls after save
                        byId('coachForm')?.querySelectorAll('input,select,textarea').forEach(el => {
                            if (el.type !== 'hidden') el.disabled = false;
                        });
                        
                        alert('✅ Profile saved successfully!');
                        return; // Don't reload or redirect
                    }
                } else {
                    // For admin users, redirect to show page if coach created
                    if (coachId) {
                        const target = '{{ url('/coach') }}' + '?coach_id=' + coachId;
                        window.location.href = target;
                        return;
                    }
                }
            } catch (e) {
                console.error('Error handling success response:', e);
            }
            
            // Fallback: reload page
            alert('✅ Coach saved successfully!');
            location.reload();
        })
        .catch(err => {
            console.error('❌ Save error:', err);
            alert(`Save failed: ${err.message}`);
        })
        .finally(() => {
            if (button) {
                button.disabled = false;
                button.textContent = selectedId ? 'Update Coach' : 'Save Coach';
            }
        });
    }

    byId('coach_saveBtn')?.addEventListener('click', performFinalSave);
    byId('coach_updateBtn')?.addEventListener('click', performFinalSave);
});
</script>

@endsection
