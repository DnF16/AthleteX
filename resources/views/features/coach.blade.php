@extends('layouts.app')

@section('title', 'Coaches')

@section('content')
    <div class="space-y-6 w-full">

        <!-- Page Header -->
        <div class="bg-white p-6 relative">
            <!-- Centered Title -->
            <div class="absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 flex items-center gap-2">
                <i class="bi bi-person text-3xl text-gray-800"></i>
                <h1 class="text-3xl font-bold text-gray-800 mb-0">Coaches</h1>
            </div>

            <!-- Right Button -->
            <div class="flex justify-end">
                <a href="{{ route('coaches.index') }}" 
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                    List of Coaches
                </a>
            </div>
        </div>

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
            <!-- Save All Button -->
            <div class="flex justify-center space-x-2 mt-4">
                <button id="coach_saveBtn" type="submit" form="coachForm" class="px-4 py-2 rounded bg-green-600 text-white bg-green-700 hover:bg-green-700 transition">
                    Save Coach
                </button>

                <button id="coach_updateBtn" type="button" form="coachForm" class="{{ isset($coach) ? '' : 'hidden' }} px-4 py-2 rounded bg-blue-600 text-white bg-green-700 hover:bg-blue-700 transition">
                    Update Coach
                </button>

                <button type="button" onclick="resetCoachForm()" class="px-4 py-2 rounded bg-gray-300 text-gray-800 hover:bg-gray-400 transition">
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
                <form id="coachForm" method="POST" action="{{ route('coaches.store') }}" class="coach-form flex items-stretch gap-6 w-full" autocomplete="off" enctype="multipart/form-data">
                    @csrf

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
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <!-- Middle Initial -->
                            <div class="flex items-center">
                                <label for="coach_middle_initial" class="w-1/3 text-gray-700 font-medium">Middle Initial</label>
                                <input type="text" id="coach_middle_initial" name="coach_middle_initial" placeholder="Enter middle initial"
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
                                <option value="Male" >Male</option>
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
                                    <select name="coach_sport_event" class="w-2/3 bg-blue-100 border border-gray-300 rounded px-2 py-1">
                                        <option value="">-- Select Sport Event --</option>
                                        <option value="Basketball">Basketball</option>
                                        <option value="Volleyball">Volleyball</option>
                                        <option value="Athletics">Athletics</option>
                                        <option value="Swimming">Swimming</option>
                                        <option value="Taekwondo" >Taekwondo</option>
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
                                <th class="py-3">Event</th>
                                <th class="py-3">Date</th>
                                <th class="py-3">List of AThletes</th>
                                <th class="py-3">Remarks</th>
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

                        <div>
                            <label class="text-white font-medium">Event</label>
                            <input type="text" class="w-full border rounded px-3 py-2" 
                                name="Event" placeholder="Event">
                        </div>

                        <div>
                            <label class="text-white font-medium">Date</label>
                            <input type="date" class="w-full border rounded px-3 py-2" 
                                name="Date" placeholder="Date">
                        </div>

                        <div>
                            <label class="text-white font-medium">List of Athletes</label>
                            <select name="List" class="w-full border rounded px-3 py-2">
                                <option value="">Select Class</option>
                                <option value="Class A">Class A</option>
                                <option value="Class B">Class B</option>
                                <option value="Class C">Class C</option>
                                <!-- Add more classes as needed -->
                            </select>
                        </div>

                        <div>
                            <label class="text-white font-medium">Remark</label>
                            <input type="text" class="w-full border rounded px-3 py-2" 
                                name="coachRemark" placeholder="Input Remark">
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
                                <th class="py-3">Academic Year</th>
                                <th class="py-3">Term</th>
                                <th class="py-3">Type</th>
                                <th class="py-3">Amount</th>
                                <th class="py-3">Event / Athlete</th>
                                <th class="py-3">Notes</th>
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

                    <h2 class="text-xl font-bold mb-4 text-white">Add Schedule an Athlete</h2>

                    <form id="ExpensesForm" class="space-y-4">

                        <div>
                            <label class="text-white font-medium">Academic Year</label>
                            <input type="text" class="w-full border rounded px-3 py-2" 
                                name="Academic" placeholder="Academic Year">
                        </div>

                        <div>
                            <label class="text-white font-medium">Term</label>
                            <input type="text" class="w-full border rounded px-3 py-2" 
                                name="Term" placeholder="Term">
                        </div>

                        <div>
                            <label class="text-white font-medium">Type</label>
                            <input type="text" class="w-full border rounded px-3 py-2" 
                                name="Type" placeholder="Type">
                        </div>

                        <div>
                            <label class="text-white font-medium">Amount</label>
                            <input type="number" class="w-full border rounded px-3 py-2" 
                                name="Amount" placeholder="Amount">
                        </div>
                        
                        <div>
                            <label class="text-white font-medium">Event / Athlete</label>
                            <input type="text" class="w-full border rounded px-3 py-2" 
                                name="EventAthlete" placeholder="Event / Athlete">
                        </div>

                        <div>
                            <label class="text-white font-medium">Notes</label>
                            <input type="text" class="w-full border rounded px-3 py-2" 
                                name="notes" placeholder="Notes">
                        </div>

                        <div>
                            <label class="text-white font-medium">Remarks</label>
                            <input type="text" class="w-full border rounded px-3 py-2" 
                                name="coachRemark" placeholder="Input Remark">
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
                                <th class="py-3">Academic Term and Year</th>
                                <th class="py-3">Total Units Enrolled</th>
                                <th class="py-3">Tuition Fee</th>
                                <th class="py-3">Miscellaneous Fee</th>
                                <th class="py-3">Other Charges</th>
                                <th class="py-3">Total Assessment</th>
                                <th class="py-3">Total Discount</th>
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
                            <label class="text-white font-medium">Academic Term and Year</label>
                            <input type="text" class="w-full border rounded px-3 py-2" 
                                name="AcademicTerm" placeholder="Academic Term and Year">
                        </div>

                        <div>
                            <label class="text-white font-medium">Total Units Enrolled</label>
                            <input type="number" class="w-full border rounded px-3 py-2" 
                                step="0.01" name="UnitsEnrolled" placeholder="Total Units Enrolled">
                        </div>

                        <div>
                            <label class="text-white font-medium">Tuition Fee</label>
                            <input type="number" class="w-full border rounded px-3 py-2" 
                                name="CoachTuition" placeholder="Tuition Fee">
                        </div>

                        <div>
                            <label class="text-white font-medium">Miscellaneous Fee</label>
                            <input type="number" class="w-full border rounded px-3 py-2" 
                                name="CoachMiscellaneous" placeholder="Miscellaneous Fee">
                        </div>
                        
                        <div>
                            <label class="text-white font-medium">Other Charges</label>
                            <input type="number" class="w-full border rounded px-3 py-2" 
                                name="CoachOtherCharges" placeholder="Other Charges">
                        </div>

                        <div>
                            <label class="text-white font-medium">Total Assessment</label>
                            <input type="text" class="w-full border rounded px-3 py-2" 
                                name="CoachAssessment" placeholder="Total Assessment">
                        </div>

                        <div>
                            <label class="text-white font-medium">Total Discount</label>
                            <input type="number" class="w-full border rounded px-3 py-2" 
                                name="CoachTotalDiscount" placeholder="Total Discount">
                        </div>

                        <div>
                            <label class="text-white font-medium">Remarks</label>
                            <input type="text" class="w-full border rounded px-3 py-2" 
                                name="coachRemark" placeholder="Input Remark">
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
                                <th class="py-3">Work position</th>
                                <th class="py-3">Name of Company</th>
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
                            <input type="date" class="w-full border rounded px-3 py-2" 
                                name="Year" placeholder="Seminar Year">
                        </div>

                        <div>
                            <label class="text-white font-medium">Date</label>
                            <input type="date" class="w-full border rounded px-3 py-2" 
                            name="date" placeholder="Seminar Date">
                        </div>

                        <div>
                            <label class="text-white font-medium">Work Position</label>
                            <input type="text" class="w-full border rounded px-3 py-2" 
                                name="WorkPosition" placeholder="Work Position">
                        </div>

                        <div>
                            <label class="text-white font-medium">Name of Company</label>
                            <input type="text" class="w-full border rounded px-3 py-2" 
                                name="NameCompany" placeholder="Name of Company">
                        </div>

                        <div>
                            <label class="text-white font-medium">Remarks</label>
                            <input type="text" class="w-full border rounded px-3 py-2" 
                                name="coachRemark" placeholder="Input Remark">
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
                                name="company_name" placeholder="Name of Company">
                        </div>

                        <div>
                            <label class="text-white font-medium">Remarks</label>
                            <input type="text" class="w-full border rounded px-3 py-2" 
                                name="coachRemark" placeholder="Input Remark">
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

    <script>
       document.addEventListener('DOMContentLoaded', () => {
    // -----------------------
    // Helpers
    // -----------------------
    const byId = id => document.getElementById(id);
    const q = sel => document.querySelector(sel);

    // -----------------------
    // Globals (collect all coach data)
    // -----------------------
    window.newCoachData = {
        generalInfo: {},
        achievements: [],
        schedules: [],
        expenses: [],
        memberships: [],
        seminars: [],
        workHistory: []
    };

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
            document.querySelector('#coach-general-info').classList.remove('hidden');
        }

        tabs.forEach(tab => {
            tab.addEventListener('click', e => {
                e.preventDefault();
                tabs.forEach(t => t.classList.remove('border-b-2', 'border-green-600', 'text-green-600'));
                contents.forEach(c => c.classList.add('hidden'));
                tab.classList.add('border-b-2', 'border-green-600', 'text-green-600');
                const target = document.querySelector(tab.getAttribute('href'));
                if (target) target.classList.remove('hidden');
            });
        });
    })();

    // -----------------------
    // MODAL TOGGLES (fix your HTML typos)
    // -----------------------
    window.toggleCoachAchievementModal = (show) => {
        byId('coach-AchievementModal')?.classList.toggle('hidden', !show);
    };
    window.toggleScheduleModal = (show) => {
        byId('scheduleModal')?.classList.toggle('hidden', !show);
    };
    window.toggleExpensesModal = (show) => {
        byId('expensesModal')?.classList.toggle('hidden', !show);
    };
    window.toggleMembershipModal = (show) => {
        byId('membershipModal')?.classList.toggle('hidden', !show);
    };
    window.toggleSeminarsModal = (show) => { // Fixed typo
        byId('seminarsModal')?.classList.toggle('hidden', !show);
    };
    window.toggleWorkHistoryModal = (show) => { // Fixed typo
        byId('workModal')?.classList.toggle('hidden', !show);
    };

    // -----------------------
    // ACHIEVEMENTS MODULE
    // -----------------------
    (function achievementsModule() {
        const form = byId('coach-achievementForm');
        const tbody = byId('coach-achievements-tbody');
        if (!form || !tbody) return;

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            
            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData.entries());
            
            // Validate required fields
            if (!data.year || !data.month_day || !data.sports_event || !data.venue || !data.award) {
                alert('Please fill in all required fields.');
                return;
            }
            
            // Add to local data
            window.newCoachData.achievements.push(data);
            
            // Add row to table
            const row = document.createElement('tr');
            row.className = 'border-b hover:bg-gray-50 text-center';
            row.innerHTML = `
                <td class="px-6 py-4 text-sm">${data.year || '-'}</td>
                <td class="px-6 py-4 text-sm">${data.month_day || '-'}</td>
                <td class="px-6 py-4 text-sm">${data.sports_event || '-'}</td>
                <td class="px-6 py-4 text-sm">${data.venue || '-'}</td>
                <td class="px-6 py-4 text-sm">${data.award || '-'}</td>
                <td class="px-6 py-4 text-sm">${data.category || '-'}</td>
                <td class="px-6 py-4 text-sm">${data.remarks || '-'}</td>
            `;
            tbody.appendChild(row);
            
            // Reset and close
            e.target.reset();
            toggleCoachAchievementModal(false);
        });
    })();

    // -----------------------
    // SCHEDULE MODULE
    // -----------------------
    (function scheduleModule() {
        const form = byId('ScheduleForm');
        const tbody = byId('scheduleTable');
        if (!form || !tbody) return;

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            
            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData.entries());
            
            window.newCoachData.schedules.push(data);
            
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="border px-4 py-2">${data.Event || '-'}</td>
                <td class="border px-4 py-2">${data.Date || '-'}</td>
                <td class="border px-4 py-2">${data.List || '-'}</td>
                <td class="border px-4 py-2">${data.coachRemark || '-'}</td>
            `;
            tbody.appendChild(row);
            
            e.target.reset();
            toggleScheduleModal(false);
        });
    })();

    // -----------------------
    // EXPENSES MODULE
    // -----------------------
    (function expensesModule() {
        const form = byId('ExpensesForm');
        const tbody = byId('expensesTable');
        if (!form || !tbody) return;

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            
            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData.entries());
            
            window.newCoachData.expenses.push(data);
            
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="border px-4 py-2">${data.Academic || '-'}</td>
                <td class="border px-4 py-2">${data.Term || '-'}</td>
                <td class="border px-4 py-2">${data.Type || '-'}</td>
                <td class="border px-4 py-2">${data.Amount || '-'}</td>
                <td class="border px-4 py-2">${data.EventAthlete || '-'}</td>
                <td class="border px-4 py-2">${data.notes || '-'}</td>
                <td class="border px-4 py-2">${data.coachRemark || '-'}</td>
            `;
            tbody.appendChild(row);
            
            e.target.reset();
            toggleExpensesModal(false);
        });
    })();

    // -----------------------
    // MEMBERSHIP MODULE
    // -----------------------
    (function membershipModule() {
        const form = byId('MembershipForm');
        const tbody = byId('membershipTable');
        if (!form || !tbody) return;

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            
            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData.entries());
            
            window.newCoachData.memberships.push(data);
            
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="border px-4 py-2">${data.AcademicTerm || '-'}</td>
                <td class="border px-4 py-2">${data.UnitsEnrolled || '-'}</td>
                <td class="border px-4 py-2">${data.CoachTuition || '-'}</td>
                <td class="border px-4 py-2">${data.CoachMiscellaneous || '-'}</td>
                <td class="border px-4 py-2">${data.CoachOtherCharges || '-'}</td>
                <td class="border px-4 py-2">${data.CoachAssessment || '-'}</td>
                <td class="border px-4 py-2">${data.CoachTotalDiscount || '-'}</td>
                <td class="border px-4 py-2">${data.coachRemark || '-'}</td>
            `;
            tbody.appendChild(row);
            
            e.target.reset();
            toggleMembershipModal(false);
        });
    })();

    // -----------------------
    // SEMINARS MODULE
    // -----------------------
    (function seminarsModule() {
        const form = byId('SeminarsForm');
        const tbody = byId('seminarsTable');
        if (!form || !tbody) return;

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            
            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData.entries());
            
            window.newCoachData.seminars.push(data);
            
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="border px-4 py-2">${data.Year || '-'}</td>
                <td class="border px-4 py-2">${data.date || '-'}</td>
                <td class="border px-4 py-2">${data.WorkPosition || '-'}</td>
                <td class="border px-4 py-2">${data.NameCompany || '-'}</td>
                <td class="border px-4 py-2">${data.coachRemark || '-'}</td>
            `;
            tbody.appendChild(row);
            
            e.target.reset();
            toggleSeminarsModal(false);
        });
    })();

    // -----------------------
    // WORK HISTORY MODULE
    // -----------------------
    (function workHistoryModule() {
        const form = byId('WorkHistoryForm');
        const tbody = byId('workTable');
        if (!form || !tbody) return;

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            
            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData.entries());
            
            window.newCoachData.workHistory.push(data);
            
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="border px-4 py-2">${data.year || '-'}</td>
                <td class="border px-4 py-2">${data.date || '-'}</td>
                <td class="border px-4 py-2">${data.work_position || '-'}</td>
                <td class="border px-4 py-2">${data.company_name || '-'}</td>
                <td class="border px-4 py-2">${data.coachRemark || '-'}</td>
            `;
            tbody.appendChild(row);
            
            e.target.reset();
            toggleWorkHistoryModal(false);
        });
    })();

    // -----------------------
    // GENERAL INFO COLLECTION
    // -----------------------
    function collectGeneralInfo() {
        const form = byId('coachForm');
        if (!form) return;
        
        const inputs = form.querySelectorAll('input[name], select[name], textarea[name]');
        inputs.forEach(input => {
            if (input.name && input.name !== '_method' && input.name !== '_token') {
                window.newCoachData.generalInfo[input.name] = input.value;
            }
        });
    }

    // -----------------------
    // FINAL SAVE (Create/Update)
    // -----------------------
    const saveBtn = byId('coach_saveBtn');
    const updateBtn = byId('coach_updateBtn');
    
    function performFinalSave(e) {
        if (e) e.preventDefault();
        
        collectGeneralInfo();
        
        const selectedId = byId('selected_coach_id')?.value;
        const updateBase = '{{ url('/coaches') }}';
        const endpoint = selectedId ? `${updateBase}/${selectedId}` : updateBase;
        const method = selectedId ? 'PUT' : 'POST';
        
        // Show loading state
        const button = e?.target;
        if (button) {
            button.disabled = true;
            button.textContent = 'Saving...';
        }
        
        fetch(endpoint, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}', // ✅ FIXED: Direct Blade injection
                'Accept': 'application/json'
            },
            body: JSON.stringify(window.newCoachData)
        })
        .then(async r => {
            const text = await r.text();
            let data = null;
            try { data = JSON.parse(text); } catch (e) {}
            if (!r.ok) {
                console.error('Server error', r.status, data || text);
                throw new Error(r.status === 422 && data?.errors ? 
                    'Validation error: ' + JSON.stringify(data.errors) : 
                    'Server returned ' + r.status);
            }
            return data;
        })
        .then(data => {
            alert('✅ Coach saved successfully!');
            location.reload();
        })
        .catch(err => {
            console.error('Save error:', err);
            alert('❌ Failed to save: ' + err.message);
        })
        .finally(() => {
            if (button) {
                button.disabled = false;
                button.textContent = selectedId ? 'Update Coach' : 'Save Coach';
            }
        });
    }

    if (saveBtn) saveBtn.addEventListener('click', performFinalSave);
    if (updateBtn) updateBtn.addEventListener('click', performFinalSave);
});
        

    </script>

@endsection
