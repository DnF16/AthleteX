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
            <!-- Search -->
            <div class="">
                <label class=" text-gray-700 font-medium mb-1" for="coach_search">Search</label>
                <input type="text" id="coach_search" name="coach_search" placeholder="Enter full name"
                    class="w-64 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600"
                    autocomplete="off">
                <!-- Live search results -->
                <div id="coach_searchResults" class="mt-2 w-64 bg-white border border-gray-200 rounded shadow-sm hidden"></div>
            </div>
            <!-- Save All Button -->
            <div class="flex justify-center space-x-2 mt-4">
                <button id="coach_saveBtn" type="submit" class="px-4 py-2 rounded bg-green-600 text-white bg-green-700 hover:bg-green-700 transition">
                    Save Coach
                </button>

                <button id="coach_updateBtn" type="button" class="hidden px-4 py-2 rounded bg-blue-600 text-white bg-green-700 hover:bg-blue-700 transition">
                    Update Coach
                </button>

                <button type="button" onclick="resetForm()" class="px-4 py-2 rounded bg-gray-300 text-gray-800 hover:bg-gray-400 transition">
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
        <div id="coach-general-info" class="tab-content hidden">
            <div class="flex items-stretch gap-6">
                <form id="coachForm" method="POST" action="{{ route('athletes.store') }}" class="coach-form flex items-stretch gap-6 w-full" autocomplete="off">
                    @csrf

                    <!-- method spoofing input: stay POST by default, switched to PUT when updating -->
                    <input type="hidden" name="coach_method" id="coach_method" value="POST">
                    <!-- selected athlete id (for reference) -->
                    <input type="hidden" name="selected_coach_id" id="selected_coach_id" value="">

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
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <!-- Student ID -->
                            <div class="flex items-center">
                                <label for="coach_middle_initial" class="w-1/3 text-gray-700 font-medium">Middle Initial</label>
                                <input type="text" id="coach_middle_initial" name="coach_middle_initial" placeholder="Enter student ID"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>
                        </div>

                        <!-- 2nd Row -->
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div class="flex items-center">
                            <label class="w-1/3 text-gray-700 font-medium">Gender</label>

                            <select id="coach_gender" name="coach_gender"
                                class="w-2/3 border border-gray-300 rounded px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-green-600">
                                <option value="Select Gender">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>


                            <div class="flex items-center">
                                <label class="w-1/3 text-gray-700 font-medium">Birthdate</label>
                                <input type="date" id="coach_birthdate" name="coach_birthdate"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="flex items-center">
                                <label class="w-1/3 text-gray-700 font-medium">Age</label>
                                <input type="number" id="coach_age" name="coach_age" placeholder="Enter Age"
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
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-green-600">>
                                    <option value="Select Marital Status">Select Marital Status</option>
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
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="flex items-center">
                                <label for="coach_facebook" class="w-1/3 text-gray-700 font-medium">Facebook Link</label>
                                <input type="text" id="coach_facebook" name="coach_facebook" placeholder="Enter Facebook Account Link"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="flex items-center">
                                <label for="coach_tba" class="w-1/3 text-gray-700 font-medium">TBA</label>
                                <input type="text" id="coach_tba" placeholder="TO BE ANNOUNCE" 
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600"></input>
                            </div>
                        </div>

                        <!-- 5th Row -->
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div class="flex items-center">
                                <label for="coach_contact_number" class="w-1/3 text-gray-700 font-medium">Contact No.</label>
                                <input type="text" id="coach_contact_number" name="coach_contact_number" placeholder="Enter Contact Number"
                                    class="contact-number w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="col-span-2 flex items-center">
                                <label for="coach_address" class="w-1/6 text-gray-700 font-medium">Address</label>
                                <input type="text" id="coach_address" name="coach_address" placeholder="Enter Address"
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
                                    {{ $selectedAthlete->name ?? 'No athlete selected' }}
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
                                    <select name="coach_sport_event" class="w-2/3 bg-blue-100 border border-gray-300 rounded px-2 py-1">
                                        <option value="">-- Select Sport Event --</option>
                                        <option value="Basketball">Basketball</option>
                                        <option value="Volleyball">Volleyball</option>
                                        <option value="Athletics">Athletics</option>
                                        <option value="Swimming">Swimming</option>
                                        <option value="Taekwondo">Taekwondo</option>
                                        <option value="Chess">Chess</option>
                                        <option value="Football">Football</option>
                                        <option value="Boxing">Boxing</option>
                                    </select>
                                </div>

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
                                    <input type="file" id="coach_pictureInput" accept="image/*" class="hidden">

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
                        <textarea type="text" class="w-2/3 border border-gray-300 rounded px-2 py-1 h-52 w-full" autocomplete="off"></textarea>
                    </div>
                </div>
            </div>

        </div>

        <!-- ========================================================================================= -->
        <!-- Coach Achievements Content -->
        <div id="coach-achievements" class="tab-content hidden">
            <p>This is the Achievements content.</p>
        </div>

        <!-- ========================================================================================= -->
        <!-- Coach Assigned Schedule / Atheletes Content -->
        <div id="assigned-schedule-athletes" class="tab-content hidden">
            <p>This is the Assigned Schedule / Athletes.</p>
        </div>

        <!-- ========================================================================================= -->
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

        <!-- ========================================================================================= -->
        <!-- Coach Membership Content -->
        <div id="membership" class="tab-content hidden">
            <p>This is the membership.</p>
        </div>

        <!-- ========================================================================================= -->
        <!-- Coach Seminars Content -->
        <div id="seminars" class="tab-content hidden">
            <p>This is the seminars.</p>
        </div>

        <!-- ========================================================================================= -->
        <!-- Coach Work History Content -->
        <div id="coach-work-history" class="tab-content hidden">
            <p>This is the work history.</p>
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
