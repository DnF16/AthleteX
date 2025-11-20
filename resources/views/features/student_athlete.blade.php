@extends('layouts.app')

@section('title', 'Student Athletes')

@section('content')
    <div class="space-y-6 w-full">
    <!-- Page Header -->
    <div class="bg-white p-6 flex items-center justify-between">
        <div class="flex-1 text-center">
            <h1 class="text-3xl font-bold text-gray-800 mb-0">Student Athlete</h1>
        </div>
        <div>
            <a href="{{ route('student.athletes') }}" 
            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                Student Athlete List
            </a>
        </div>
    </div>

    <div class="flex items-end space-x-2">
        <!-- Search -->
        <div class="">
            <label class=" text-gray-700 font-medium mb-1" for="search">Search</label>
            <input type="text" id="search" name="search" placeholder="Enter full name"
                class="w-64 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600"
                autocomplete="off">
            <!-- Live search results -->
            <div id="searchResults" class="mt-2 w-64 bg-white border border-gray-200 rounded shadow-sm hidden"></div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <nav class="mb-6 w-full overflow-x-auto h-8">
            <ul class="flex space-x-2 min-w-max">
                <li>
                    <a href="#general-info" 
                    class="tab-link whitespace-nowrap px-4 py-2 text-gray-700 font-medium border-b-2 border-transparent hover:border-green-600 hover:text-green-600 transition">
                        General Information
                    </a>
                </li>
                <li>
                    <a href="#achievements" 
                    class="tab-link whitespace-nowrap px-4 py-2 text-gray-700 font-medium border-b-2 border-transparent hover:border-green-600 hover:text-green-600 transition">
                        Achievements
                    </a>
                </li>
                <li>
                    <a href="#academic-evolution" 
                    class="tab-link whitespace-nowrap px-4 py-2 text-gray-700 font-medium border-b-2 border-transparent hover:border-green-600 hover:text-green-600 transition">
                        Academic Evaluation
                    </a>
                </li>
                <li>
                    <a href="#fees-discounts" 
                    class="tab-link whitespace-nowrap px-4 py-2 text-gray-700 font-medium border-b-2 border-transparent hover:border-green-600 hover:text-green-600 transition">
                        Fees and Discounts
                    </a>
                </li>
                <li>
                    <a href="#work-history" 
                    class="tab-link whitespace-nowrap px-4 py-2 text-gray-700 font-medium border-b-2 border-transparent hover:border-green-600 hover:text-green-600 transition">
                        Work History
                    </a>
                </li>
                <li>
                    <a href="#student-id" 
                    class="tab-link whitespace-nowrap px-4 py-2 text-gray-700 font-medium border-b-2 border-transparent hover:border-green-600 hover:text-green-600 transition">
                        Student ID
                    </a>
                </li>
            </ul>
        </nav>

    <hr class="border-t-2 border-gray-400 my-2 w-[100%]">

    <!-- Content Area -->
    <div id="tab-content" class="bg-white p-6 rounded shadow w-full">

        <!-- General Information Tab -->
        <div id="general-info" class="tab-pane">
            <div class="flex items-stretch gap-6">
                <form id="athleteForm" method="POST" action="{{ route('athletes.store') }}" class="student-form flex items-stretch gap-6 w-full" autocomplete="off">
                    @csrf

                    <!-- method spoofing input: stay POST by default, switched to PUT when updating -->
                    <input type="hidden" name="_method" id="_method" value="POST">
                    <!-- selected athlete id (for reference) -->
                    <input type="hidden" name="selected_athlete_id" id="selected_athlete_id" value="">

                    <!-- LEFT SIDE: Main Form -->
                    <div class="gap-4 mb-6">

                        <!-- 1st Row -->
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <!-- Last Name -->
                            <div class="flex items-center">
                                <label for="last_name" class="w-1/3 text-gray-700 font-medium">Last Name</label>
                                <input type="text" id="last_name" name="last_name" placeholder="Enter last name"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <!-- First Name -->
                            <div class="flex items-center">
                                <label for="first_name" class="w-1/3 text-gray-700 font-medium">First Name & MI</label>
                                <input type="text" id="first_name" name="first_name" placeholder="Enter first name"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <!-- Student ID -->
                            <div class="flex items-center">
                                <label for="student_id" class="w-1/3 text-gray-700 font-medium">Student ID</label>
                                <input type="text" id="student_id" name="student_id" placeholder="Enter student ID"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>
                        </div>

                        <!-- 2nd Row -->
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div class="flex items-center">
                            <label class="w-1/3 text-gray-700 font-medium">Gender</label>

                            <select id="gender" name="gender"
                                class="w-2/3 border border-gray-300 rounded px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-green-600">
                                <option value="Select Gender">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>


                            <div class="flex items-center">
                                <label class="w-1/3 text-gray-700 font-medium">Birthdate</label>
                                <input type="date" id="birthdate" name="birthdate"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="flex items-center">
                                <label class="w-1/3 text-gray-700 font-medium">Age</label>
                                <input type="number" id="age" name="age" placeholder="Enter Age"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>
                        </div>

                        <!-- 3rd Row -->
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div class="flex items-center">
                                <label class="w-1/3 text-gray-700 font-medium">Blood Type</label>
                                <input type="text" id="blood_type" name="blood_type" placeholder="Enter Blood Type"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="flex items-center">
                                <label class="w-1/3 text-gray-700 font-medium">Course</label>
                                <input type="text" id="course" name="course" placeholder="Enter Course"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="flex items-center">
                                <label class="w-1/3 text-gray-700 font-medium">Year/Level</label>
                                <input type="text" id="year_level" name="year_level" placeholder="Enter Year/Level"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>
                        </div>

                        <!-- 4th Row -->
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div class="flex items-center">
                                <label for="email" class="w-1/3 text-gray-700 font-medium">Email Address</label>
                                <input type="text" id="email" name="email" placeholder="Enter Email Address"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="flex items-center">
                                <label for="facebook" class="w-1/3 text-gray-700 font-medium">Facebook Link</label>
                                <input type="text" id="facebook" name="facebook" placeholder="Enter Facebook Account Link"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="flex items-center">
                                <label for="marital_status" class="w-1/3 text-gray-700 font-medium">Marital Status</label>
                                <select id="marital_status" name="marital_status"
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

                        <!-- 5th Row -->
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div class="flex items-center">
                                <label for="contact_number" class="w-1/3 text-gray-700 font-medium">Contact No.</label>
                                <input type="text" id="contact_number" name="contact_number" placeholder="Enter Contact Number"
                                    class="contact-number w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="col-span-2 flex items-center">
                                <label for="address" class="w-1/6 text-gray-700 font-medium">Address</label>
                                <input type="text" id="address" name="address" placeholder="Enter Address"
                                    class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>
                        </div>

                        <!-- 6th Row -->
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div class="flex items-center">
                                <label for="city_municipality" class="w-1/3 text-gray-700 font-medium">City / Municipality</label>
                                <input type="text" id="city_municipality" name="city_municipality" placeholder="Enter City/Municipality"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="flex items-center">
                                <label for="province_state" class="w-1/3 text-gray-700 font-medium">Province / State</label>
                                <input type="text" id="province_state" name="province_state" placeholder="Enter Province/State"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="flex items-center">
                                <label for="zip_code" class="w-1/3 text-gray-700 font-medium">Zip Code</label>
                                <input type="text" id="zip_code" name="zip_code" placeholder="Enter Zip Code"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>
                        </div>

                        <hr class="border-t-2 border-gray-400 my-2 w-[100%]">

                        <!-- 7th Row -->
                        <div class="grid grid-cols-2 gap-4 mb-4">

                            <div class="flex items-center gap-2">
                                <label for="emergency_person" class="w-24 text-gray-700 font-medium">
                                    Emergency Contact Person
                                </label>
                                <input type="text" id="emergency_person" name="emergency_person"
                                    placeholder="Enter Contact Person"
                                    class="flex-1 border border-gray-300 rounded px-3 py-2 
                                        focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="flex items-center gap-2">
                                <label for="emergency_contact" class="w-24 text-gray-700 font-medium">
                                    Contact No.
                                </label>
                                <input type="text" id="emergency_contact" name="emergency_contact"
                                    placeholder="Enter Contact Number"
                                    class="contact-number flex-1 border border-gray-300 rounded px-3 py-2 
                                        focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                        </div>


                        <hr class="border-t-2 border-gray-400 my-2 w-[100%]">

                        <!-- 8th Row -->
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div class="flex items-center">
                                <label for="coach_name" class="w-1/3 text-gray-700 font-medium">Coach’s Name</label>
                                <input type="text" id="coach_name" name="coach_name" placeholder="Enter Coach’s Name"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="flex items-center">
                                <label for="date_joined" class="w-1/3 text-gray-700 font-medium">Date Joined (Varsity)</label>
                                <input type="date" id="date_joined" name="date_joined"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="flex items-center">
                                <label for="term_graduated" class="w-1/3 text-gray-700 font-medium">Term Graduated</label>
                                <input type="text" id="term_graduated" name="term_graduated" placeholder="Enter Term Graduated"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>
                        </div>

                        <!-- 9th Row -->
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div class="flex items-center">
                                <label for="asst_coach" class="w-1/3 text-gray-700 font-medium">Asst. Coach</label>
                                <input type="text" id="asst_coach" name="asst_coach" placeholder="Enter Asst. Coach’s Name"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="flex items-center">
                                <label for="total_unit" class="w-1/3 text-gray-700 font-medium">Total Units</label>
                                <input type="text" id="total_unit" name="total_unit" placeholder="Enter Units Enrolled"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="flex items-center">
                                <label for="year_graduated" class="w-1/3 text-gray-700 font-medium">Year Graduated</label>
                                <input type="date" id="year_graduated" name="year_graduated" placeholder="Enter Year Graduated"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>
                        </div>

                        <hr class="border-t-2 border-gray-400 my-2 w-[100%]">

                        <!-- 10th Row -->
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div class="flex items-center">
                                <label for="tuition_fee" class="w-1/3 text-gray-700 font-medium">Tuition Fee</label>
                                <input type="text" id="tuition_fee" name="tuition_fee" placeholder="Enter Tuition Fee"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="flex items-center">
                                <label for="misc_fee" class="w-1/3 text-gray-700 font-medium">Misc. Fee</label>
                                <input type="text" id="misc_fee" name="misc_fee" placeholder="Enter Miscellaneous Fee"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="flex items-center">
                                <label for="other_charges" class="w-1/3 text-gray-700 font-medium">Other Charges</label>
                                <input type="text" id="other_charges" name="other_charges" placeholder="Enter Other Charges"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>
                        </div>

                        <!-- 11th Row -->
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div class="flex items-center">
                                <label for="total_assessment" class="w-1/3 text-gray-700 font-medium">Total Assessment</label>
                                <input type="text" id="total_assessment" name="total_assessment" placeholder="Enter Total Assessment"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="flex items-center">
                                <label for="total_discount" class="w-1/3 text-gray-700 font-medium">Total Discount</label>
                                <input type="text" id="total_discount" name="total_discount" placeholder="Enter Total Discount"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="flex items-center">
                                <label for="balance" class="w-1/3 text-gray-700 font-medium">Balance</label>
                                <input type="text" id="balance" name="balance" placeholder="Enter Balance"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>
                        </div>

                        <hr class="border-t-2 border-gray-400 my-2 w-[100%]">

                        <!-- 12th Row -->
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="flex items-center">
                                <label for="current_work" class="w-1/3 text-gray-700 font-medium">Current Work</label>
                                <input type="text" id="current_work" name="current_work" placeholder="Enter Current Work"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="flex items-center">
                                <label for="current_company" class="w-1/3 text-gray-700 font-medium">Current Company</label>
                                <input type="text" id="current_company" name="current_company" placeholder="Enter Current Company"
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
                                <span id="selected_name" class="mt-2 text-gray-800 font-semibold">
                                    {{ $selectedAthlete->name ?? 'No athlete selected' }}
                                </span>
                            </div>
                            
                            <!-- Picture Preview Section -->
                            <div class="flex flex-col items-center border border-dashed border-gray-400 rounded-lg p-3 bg-white mb-4">
                                <div class="w-80 h-96 bg-gray-200 rounded-lg flex items-center justify-center text-gray-500 text-sm relative overflow-hidden">
                                    <img id="picturePreview" class="absolute inset-0 w-full h-full object-cover hidden" />
                                    <span id="noPictureText" class="text-gray-500 text-sm">No Picture</span>
                                </div>
                            </div>

                            <!-- Sports Event Form (Middle) -->
                            <div class="space-y-3 flex-1">
                                <div class="flex items-center">
                                    <label class="w-1/3 text-sm font-medium text-gray-700">Sports Event</label>
                                    <select name="sport_event" class="w-2/3 bg-blue-100 border border-gray-300 rounded px-2 py-1">
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
                                    <label class="w-1/3 text-sm font-medium text-gray-700">Status</label>
                                    <select name="status" class="w-2/3 bg-blue-100 border border-gray-300 rounded px-2 py-1">
                                        <option value="">-- Select Status --</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                        <option value="Transfered">Transfered</option>
                                        <option value="Graduated">Graduated</option>
                                    </select>
                                </div>

                                <div class="flex items-center mt-2">
                                    <label class="w-1/3 text-sm font-medium text-gray-700">Classification</label>
                                    <select name="classification" class="w-2/3 bg-blue-100 border border-gray-300 rounded px-2 py-1">
                                        <option value="">-- Select Classification --</option>
                                        <option value="Class_A">Class A</option>
                                        <option value="Class_B">Class B</option>
                                        <option value="Class_C">Class C</option>
                                    </select>
                                </div>

                                <div class="flex justify-between mt-6">
                                    <input type="file" id="pictureInput" accept="image/*" class="hidden">

                                    <button type="button" id="addPictureBtn"
                                        class="bg-green-700 text-white font-semibold rounded px-3 py-1 flex items-center gap-1 hover:bg-green-800 transition">
                                        <i class="bi bi-person-plus"></i> Add Picture
                                    </button>

                                    <button type="button" id="clearPictureBtn"
                                        class="bg-green-700 text-white font-semibold rounded px-3 py-1 flex items-center gap-1 hover:bg-green-800 transition">
                                        <i class="bi bi-person-x"></i> Clear Picture
                                    </button>
                                </div>

                                <div class="flex items-center mt-4">
                                    <label class="w-1/3 text-sm font-medium text-gray-700">Date Inactive</label>
                                    <input type="date" name="inactive_date" class="w-2/3 border border-gray-300 rounded px-2 py-1" autocomplete="off">
                                </div>
                            </div>

                            <!-- CENTERED BUTTONS BELOW THE RIGHT SIDE PANEL -->
                            <div class="flex justify-center space-x-2 mt-4">
                                <button id="saveBtn" type="submit" class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700 transition">
                                    Save Athlete
                                </button>

                                <button id="updateBtn" type="submit" class="hidden px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 transition">
                                    Update Athlete
                                </button>

                                <button type="button" onclick="resetForm()" class="px-4 py-2 rounded bg-gray-300 text-gray-800 hover:bg-gray-400 transition">
                                    Cancel New
                                </button>
                            </div>
                        </div>

                    </form>

                </div>

            </div>
            <!-- Note Section -->
            <div id="tab-content" >
                <div class="bg-white p-6 flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-3xl font-bold text-gray-800 mb-0">Notes</p>
                        <hr class="border-t-2 border-gray-400 my-2  w-[100%]">
                        <textarea type="text" class="w-2/3 border border-gray-300 rounded px-2 py-1 h-52 w-full" autocomplete="off"></textarea>
                    </div>
                </div>
            </div>

        </div>

        <!-- ============================================================================================================================= -->
        
        <!-- Achievements Tab -->
        <div id="achievements" class="tab-pane hidden">
            <div class="space-y-6 w-full">

                <!-- Header -->
                <div class="bg-white p-6 flex items-center justify-between rounded shadow">
                    <h1 class="text-3xl font-bold text-gray-800">🏅 Achievements</h1>
                    <button onclick="toggleModal(true)" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                        + Add Achievement
                    </button>
                </div>

                <!-- Stats Overview -->
                <div class="grid grid-cols-4 gap-4">
                    <div id="goldCount" class="bg-green-100 border border-green-300 p-4 rounded-lg shadow-sm text-center">
                        <p class="text-2xl font-bold text-green-800">0</p>
                        <p class="text-sm text-green-700">Gold Medals</p>
                    </div>
                    <div id="silverCount" class="bg-yellow-100 border border-yellow-300 p-4 rounded-lg shadow-sm text-center">
                        <p class="text-2xl font-bold text-yellow-800">0</p>
                        <p class="text-sm text-yellow-700">Silver Medals</p>
                    </div>
                    <div id="bronzeCount" class="bg-gray-100 border border-gray-300 p-4 rounded-lg shadow-sm text-center">
                        <p class="text-2xl font-bold text-gray-800">0</p>
                        <p class="text-sm text-gray-700">Bronze Medals</p>
                    </div>
                    <div id="totalCount" class="bg-blue-100 border border-blue-300 p-4 rounded-lg shadow-sm text-center">
                        <p class="text-2xl font-bold text-blue-800">0</p>
                        <p class="text-sm text-blue-700">Total Awards</p>
                    </div>
                </div>

                <!-- Achievements Table -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table id="achievementsTable" class="min-w-full text-sm text-left">
                        <thead class="bg-green-600 text-white">
                            <tr>
                                <th class="px-6 py-3 font-medium">#</th>
                                <th class="px-6 py-3 font-medium">Event Name</th>
                                <th class="px-6 py-3 font-medium">Category</th>
                                <th class="px-6 py-3 font-medium">Rank</th>
                                <th class="px-6 py-3 font-medium">Date</th>
                                <th class="px-6 py-3 font-medium">Remarks</th>
                                <th class="px-6 py-3 font-medium text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="achievementBody" class="divide-y divide-gray-200">
                            <tr id="noDataRow">
                                <td colspan="7" class="px-6 py-6 text-center text-gray-400">
                                    No achievements added yet.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Modal Background -->
                <div id="addAchievementModal" class="hidden fixed inset-0 flex items-start sm:items-center justify-center z-50 overflow-y-auto bg-gray-200 bg-opacity-20">
                    <div class="bg-[#2e4e1f] rounded-xl shadow-xl w-full max-w-lg p-6 mx-4 my-6 sm:my-0 relative">
                        <button id="closeModalBtn" class="absolute top-3 right-3 text-white hover:text-gray-700 text-xl">&times;</button>
                        <h2 class="text-2xl font-semibold text-white mb-4">Add Achievement</h2>
                        <form id="achievementForm">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="title" class="block text-sm font-medium text-white mb-1">Title</label>
                                    <input type="text" id="title" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-green-600 outline-none">
                                </div>
                                <div>
                                    <label for="sport" class="block text-sm font-medium text-white mb-1">Sport</label>
                                    <input type="text" id="sport" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-green-600 outline-none">
                                </div>
                                <div>
                                    <label for="rank" class="block text-sm font-medium text-white mb-1">Rank</label>
                                    <input type="text" id="rank" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-green-600 outline-none">
                                </div>
                                <div>
                                    <label for="date" class="block text-sm font-medium text-white mb-1">Date</label>
                                    <input type="date" id="date" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-green-600 outline-none">
                                </div>
                            </div>
                            <div class="mt-4">
                                <label for="remarks" class="block text-sm font-medium text-white mb-1">Remarks</label>
                                <textarea id="remarks" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-green-600 outline-none"></textarea>
                            </div>
                            <div class="mt-6 flex justify-end space-x-3">
                                <button type="button" id="cancelModalBtn" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Cancel</button>
                                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Save</button>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </div>

        <!-- ============================================================================================================================= -->

        <!-- Academic Evolution Tab -->
        <div id="academic-evolution" class="tab-pane hidden">
            <div class="space-y-6">

                <!-- PAGE HEADER -->
                <div class="bg-white p-6 shadow flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-800">Academic Evaluation</h1>

                    <button onclick="toggleModal(true)"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 shadow">
                        + Add Record
                    </button>
                </div>

                <!-- SUBJECT TABLE -->
                <div>
                    <table class="w-full text-left">
                        <thead class="border-b text-gray-600">
                            <tr>
                                <th class="py-3">Units Passed</th>
                                <th class="py-3">Units Enrolled</th>
                                <th class="py-3">Percentage</th>
                                <th class="py-3 text-right">Remarks</th>
                            </tr>
                        </thead>

                        <tbody id="gradesTable" class="text-gray-700">
                            <!-- Dynamic Records Here -->
                        </tbody>
                    </table>

                    <!-- IF EMPTY -->
                    <p id="emptyMsg" class="text-center py-6 text-gray-500">
                        No academic records yet.
                    </p>
                </div>

            </div>

            <!-- ADD SUBJECT MODAL -->
            <div id="addModal" 
                class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

                <div class="bg-white rounded-xl shadow-xl w-full max-w-lg p-6 relative">

                    <button onclick="toggleModal(false)" 
                            class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                        ✕
                    </button>

                    <h2 class="text-xl font-bold mb-4">Add Academic Record</h2>

                    <form id="academicForm" class="space-y-4">

                        <!-- Subject -->
                        <div>
                            <label class="text-gray-700 font-medium">Subject</label>
                            <input type="text" class="w-full border rounded px-3 py-2" 
                                name="subject" placeholder="Ex: NSTP 1">
                        </div>

                        <!-- Grade -->
                        <div>
                            <label class="text-gray-700 font-medium">Grade</label>
                            <input type="number" class="w-full border rounded px-3 py-2" 
                                step="0.01" min="1.00" max="5.00" name="grade" placeholder="Ex: 1.75">
                        </div>

                        <!-- Remarks -->
                        <div>
                            <label class="text-gray-700 font-medium">Remark</label>
                            <select name="remark" class="w-full border rounded px-3 py-2">
                                <option value="">Select</option>
                                <option>Passed</option>
                                <option>Failed</option>
                                <option>Incomplete</option>
                                <option>Dropped</option>
                            </select>
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="bg-green-600 text-white w-full py-2 rounded-lg hover:bg-green-700">
                            Save Record
                        </button>

                    </form> 

                </div> 

            </div> 

        </div> 


        <!-- ============================================================================= -->
        <!-- Fees and Discounts Tab -->
        <div id="fees-discounts" class="tab-pane hidden">
            <div class="bg-white rounded-lg shadow p-4">
               <div class="bg-white p-6 shadow flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-800">Fees and Discounts</h1>

                    <!-- ADD BUTTON -->
                    <button onclick="toggleFeeModal(true)"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 shadow">
                        + Add Fee / Discount
                    </button>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-300 text-sm text-gray-700">
                        <thead class="bg-green-100">
                            <tr>
                                <th class="border border-gray-300 px-4 py-2 text-left">Academic Term and Year</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Total Units Enrolled</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Tuition Fee</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Miscellaneous Fee</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Other Charges</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Total Assessment</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Total Discount</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- 20 Empty Rows -->
                            @for ($i = 0; $i < 20; $i++)
                            <tr class="{{ $i % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                <td class="border border-gray-300 px-4 py-2"></td>
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

            <!-- ADD FEE / DISCOUNT MODAL -->
            <div id="feeModal" 
                class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

                <div class="bg-white rounded-xl shadow-xl w-full max-w-lg p-6 relative">

                    <!-- CLOSE BUTTON -->
                    <button type="button" onclick="toggleFeeModal(false)" 
                            class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                        ✕
                    </button>

                    <h2 class="text-xl font-bold mb-4">Add Fee / Discount</h2>

                    <form id="feeForm" class="space-y-4">

                        <!-- Academic Year -->
                        <div>
                            <label class="text-gray-700 font-medium">Academic Year</label>
                            <input type="text" name="academic_year" placeholder="Ex: 2025-2026"
                                class="w-full border rounded px-3 py-2">
                        </div>

                        <!-- Term -->
                        <div>
                            <label class="text-gray-700 font-medium">Term</label>
                            <input type="text" name="term" placeholder="Ex: 1st Term"
                                class="w-full border rounded px-3 py-2">
                        </div>

                        <!-- Fee Type -->
                        <div>
                            <label class="text-gray-700 font-medium">Fee Type</label>
                            <input type="text" name="fee_type" placeholder="Ex: Tuition Fee"
                                class="w-full border rounded px-3 py-2">
                        </div>

                        <!-- Discount Type -->
                        <div>
                            <label class="text-gray-700 font-medium">Discount Type</label>
                            <input type="text" name="discount_type" placeholder="Ex: Scholarship"
                                class="w-full border rounded px-3 py-2">
                        </div>

                        <!-- Amount -->
                        <div>
                            <label class="text-gray-700 font-medium">Amount</label>
                            <input type="number" name="amount" placeholder="Ex: 5000"
                                class="w-full border rounded px-3 py-2">
                        </div>

                        <!-- Notes -->
                        <div>
                            <label class="text-gray-700 font-medium">Notes</label>
                            <textarea name="notes" class="w-full border rounded px-3 py-2" rows="2"></textarea>
                        </div>

                        <!-- Remarks -->
                        <div>
                            <label class="text-gray-700 font-medium">Remarks</label>
                            <select name="remarks" class="w-full border rounded px-3 py-2">
                                <option value="">Select</option>
                                <option>Paid</option>
                                <option>Pending</option>
                                <option>Waived</option>
                            </select>
                        </div>

                        <!-- Submit -->
                        <button type="submit" 
                            class="bg-green-600 text-white w-full py-2 rounded-lg hover:bg-green-700">
                            Save Record
                        </button>

                    </form>

                </div>
            </div>

        </div>

        <!-- ========================================================================================== -->
        <!-- Work History Tab -->
        <div id="work-history" class="tab-pane hidden">
            <div class="bg-white rounded-lg shadow p-4">
                <div class="bg-white p-6 shadow flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-800">Work History</h1>

                    <!-- ADD BUTTON -->
                    <button onclick="toggleWorkModal(true)"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 shadow">
                        + Add Work History
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-300 text-sm text-gray-700">
                        <thead class="bg-green-100">
                            <tr>
                                <th class="border border-gray-300 px-4 py-2 text-left">Year</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Date</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Work Position</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Name of Company</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- 20 Empty Rows -->
                            @for ($i = 0; $i < 20; $i++)
                            <tr class="{{ $i % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
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

            <!-- ADD WORK HISTORY MODAL -->
            <div id="workModal" 
                class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

                <div class="bg-white rounded-xl shadow-xl w-full max-w-lg p-6 relative">

                    <button type="button" onclick="toggleWorkModal(false)" 
                            class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                        ✕
                    </button>

                    <h2 class="text-xl font-bold mb-4">Add Work History</h2>

                    <form id="workForm" class="space-y-4">

                        
                        <div>
                            <label class="text-gray-700 font-medium">Year</label>
                            <input type="text" name="year" placeholder="Ex: 2025"
                                class="w-full border rounded px-3 py-2">
                        </div>

                        
                        <div>
                            <label class="text-gray-700 font-medium">Date</label>
                            <input type="date" name="date" class="w-full border rounded px-3 py-2">
                        </div>

                        
                        <div>
                            <label class="text-gray-700 font-medium">Work Position</label>
                            <input type="text" name="position" placeholder="Ex: Coach"
                                class="w-full border rounded px-3 py-2">
                        </div>

                        
                        <div>
                            <label class="text-gray-700 font-medium">Name of Company</label>
                            <input type="text" name="company" placeholder="Ex: ABC Sports Academy"
                                class="w-full border rounded px-3 py-2">
                        </div>

                        
                        <div>
                            <label class="text-gray-700 font-medium">Remarks</label>
                            <select name="remarks" class="w-full border rounded px-3 py-2">
                                <option value="">Select</option>
                                <option>Active</option>
                                <option>Resigned</option>
                                <option>Retired</option>
                                <option>Other</option>
                            </select>
                        </div>

                        
                        <button type="submit" 
                            class="bg-green-600 text-white w-full py-2 rounded-lg hover:bg-green-700">
                            Save Record
                        </button>

                    </form>

                </div>
            </div>

        </div>
        <!-- ================================================================================================ -->
        <!-- Student ID Tab -->
        <div id="student-id" class="tab-pane hidden">
            <!-- Add Achievements form or table here -->
            <p>Stuydents ID content goes here...</p>
        </div>

    </div> <!-- End of Content Area -->

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tabs = document.querySelectorAll('.tab-link');
            const contents = document.querySelectorAll('.tab-pane');

            // --- Default active tab setup ---
            const defaultTab = document.querySelector('.tab-link[href="#general-info"]');
            const defaultContent = document.querySelector('#general-info');

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

        // ==============================================================================

        // script for the student athlete general info
        let achievementCount = 0;
        let gold = 0, silver = 0, bronze = 0;

        // Modal toggle
        function toggleModal(show) {
            document.getElementById('addAchievementModal').classList.toggle('hidden', !show);
        }

        // Open modal
        document.querySelector('button[onclick="toggleModal(true)"]').addEventListener('click', () => toggleModal(true));

        // Close modal buttons
        document.getElementById('closeModalBtn').addEventListener('click', () => toggleModal(false));
        document.getElementById('cancelModalBtn').addEventListener('click', () => toggleModal(false));

        // Form submission
        document.getElementById('achievementForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const eventName = document.getElementById('title').value;
            const category = document.getElementById('sport').value;
            const rank = document.getElementById('rank').value;
            const date = document.getElementById('date').value;
            const remarks = document.getElementById('remarks').value;

            if (!eventName || !category || !rank || !date) {
                alert('Please fill in all required fields.');
                return;
            }

            // Update medal counters
            if (rank.includes('1st')) gold++;
            else if (rank.includes('2nd')) silver++;
            else if (rank.includes('3rd')) bronze++;

            // Hide "No Data" message
            const noDataRow = document.getElementById('noDataRow');
            if (noDataRow) noDataRow.remove();

            // Add new row
            achievementCount++;
            const tbody = document.getElementById('achievementBody');
            const tr = document.createElement('tr');
            tr.className = 'hover:bg-gray-50';
            tr.innerHTML = `
                <td class="px-6 py-3">${achievementCount}</td>
                <td class="px-6 py-3 font-semibold text-gray-800">${eventName}</td>
                <td class="px-6 py-3">${category}</td>
                <td class="px-6 py-3 text-green-700 font-bold">${rank}</td>
                <td class="px-6 py-3">${date}</td>
                <td class="px-6 py-3 text-gray-600">${remarks}</td>
                <td class="px-6 py-3 text-center space-x-2">
                    <button class="text-blue-600 hover:text-blue-800 font-medium" onclick="editRow(this)">Edit</button>
                    <button class="text-red-600 hover:text-red-800 font-medium" onclick="deleteRow(this)">Delete</button>
                </td>
            `;
            tbody.appendChild(tr);

            // Update stats
            updateStats();

            // Reset form and close modal
            e.target.reset();
            toggleModal(false);
        });

        function updateStats() {
            document.querySelector('#goldCount p').textContent = gold;
            document.querySelector('#silverCount p').textContent = silver;
            document.querySelector('#bronzeCount p').textContent = bronze;
            document.querySelector('#totalCount p').textContent = achievementCount;
        }

        function deleteRow(btn) {
            const row = btn.closest('tr');
            const rank = row.children[3].textContent;

            if (rank.includes('1st')) gold--;
            else if (rank.includes('2nd')) silver--;
            else if (rank.includes('3rd')) bronze--;
            achievementCount--;

            row.remove();
            updateStats();

            const tbody = document.getElementById('achievementBody');
            if (tbody.children.length === 0) {
                tbody.innerHTML = `
                    <tr id="noDataRow">
                        <td colspan="7" class="px-6 py-6 text-center text-gray-400">
                            No achievements added yet.
                        </td>
                    </tr>
                `;
            }
        }

        function editRow(btn) {
            alert("Edit feature coming soon!");
        }

        // add picture js
        const pictureInput = document.getElementById('pictureInput');
        const addPictureBtn = document.getElementById('addPictureBtn');
        const clearPictureBtn = document.getElementById('clearPictureBtn');
        const preview = document.getElementById('picturePreview');

        // Open file dialog
        addPictureBtn.addEventListener('click', () => {
            pictureInput.click();
        });

        // Show preview
        pictureInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
            }
        });

        // Clear picture
        clearPictureBtn.addEventListener('click', () => {
            pictureInput.value = "";
            preview.src = "";
            preview.classList.add('hidden');
            const noPicture = document.getElementById('noPictureText');
            if (noPicture) noPicture.classList.remove('hidden');
        });

        // contact number limits 11 digits
        document.querySelectorAll('.contact-number').forEach(function(input) {
            input.addEventListener('input', function() {
                this.value = this.value.replace(/\D/g, '').slice(0, 11);
            });
        });

        // Reset the entire athlete form and UI elements
        function resetForm() {
            const form = document.getElementById('athleteForm');
            if (form) form.reset();

            // clear picture preview
            const picInput = document.getElementById('pictureInput');
            const picPreview = document.getElementById('picturePreview');
            const noPictureText = document.getElementById('noPictureText');
            if (picInput) picInput.value = '';
            if (picPreview) { picPreview.src = ''; picPreview.classList.add('hidden'); }
            if (noPictureText) noPictureText.classList.remove('hidden');
        }
// ===============================================================================

        // --- Live search (debounced) ---
        (function () {
            const searchInput = document.getElementById('search');
            const resultsBox = document.getElementById('searchResults');
            const searchUrl = '{{ route('athletes.search') }}';

            if (!searchInput || !resultsBox) return;

            let timer = null;
            let selectedFromSearch = false;
            let selectedId = null;

            // form and action helpers
            const form = document.getElementById('athleteForm');
            const defaultAction = form ? form.getAttribute('action') : '{{ route('athletes.store') }}';
            const methodInput = document.getElementById('_method');
            const selectedIdInput = document.getElementById('selected_athlete_id');
            const saveBtn = document.getElementById('saveBtn');
            const updateBtn = document.getElementById('updateBtn');
            const updateBase = '{{ url('/athletes') }}';

            function clearResults() {
                resultsBox.innerHTML = '';
                resultsBox.classList.add('hidden');
            }

            function clearSelection() {
                // only clear fields that were populated by the search
                const last = document.getElementById('last_name');
                const first = document.getElementById('first_name');
                const sid = document.getElementById('student_id');
                const selectedName = document.getElementById('selected_name');
                const sportSel = document.querySelector('select[name="sport_event"]');

                if (last) last.value = '';
                if (first) first.value = '';
                if (sid) sid.value = '';
                if (selectedName) selectedName.textContent = 'No athlete selected';
                if (sportSel) sportSel.selectedIndex = 0;

                selectedFromSearch = false;
                selectedId = null;

                // restore form to create mode
                if (form) form.setAttribute('action', defaultAction);
                if (methodInput) methodInput.value = 'POST';
                if (selectedIdInput) selectedIdInput.value = '';
                if (saveBtn) saveBtn.classList.remove('hidden');
                if (updateBtn) updateBtn.classList.add('hidden');
            }

            function renderResults(items) {
                if (!items || items.length === 0) {
                    clearResults();
                    return;
                }

                resultsBox.innerHTML = '';
                items.forEach(item => {
                    const div = document.createElement('div');
                    div.className = 'px-3 py-2 hover:bg-gray-100 cursor-pointer text-sm';
                    const name = (item.full_name && item.full_name.trim() !== '') ? item.full_name : (item.first_name + ' ' + item.last_name);
                    div.textContent = name + (item.student_id ? ' — ' + item.student_id : '');
                    div.addEventListener('click', () => {
                        // fill basic fields on the form
                        if (item.last_name) document.getElementById('last_name').value = item.last_name;
                        if (item.first_name) document.getElementById('first_name').value = item.first_name;
                        if (item.student_id) document.getElementById('student_id').value = item.student_id;
                        if (item.sport) {
                            const sel = document.querySelector('select[name="sport_event"]');
                            if (sel) {
                                for (let i = 0; i < sel.options.length; i++) {
                                    if (sel.options[i].value.toLowerCase() === item.sport.toLowerCase()) { sel.selectedIndex = i; break; }
                                }
                            }
                        }
                        const selectedName = document.getElementById('selected_name');
                        if (selectedName) selectedName.textContent = name;

                        // mark that the current populated fields came from a search selection
                        selectedFromSearch = true;
                        selectedId = item.id || null;

                        if (selectedIdInput) selectedIdInput.value = selectedId;

                        // switch form into update mode
                        if (form && selectedId) {
                            form.setAttribute('action', updateBase + '/' + selectedId);
                            if (methodInput) methodInput.value = 'PUT';
                        }
                        if (saveBtn) saveBtn.classList.add('hidden');
                        if (updateBtn) updateBtn.classList.remove('hidden');

                        clearResults();
                    });
                    resultsBox.appendChild(div);
                });
                resultsBox.classList.remove('hidden');
            }

            function doSearch(q) {
                if (!q || q.trim().length < 1) { clearResults(); return; }
                fetch(searchUrl + '?q=' + encodeURIComponent(q), { headers: { 'Accept': 'application/json' } })
                    .then(r => r.json())
                    .then(data => renderResults(data))
                    .catch(() => clearResults());
            }

            searchInput.addEventListener('input', (e) => {
                const v = e.target.value;
                if (timer) clearTimeout(timer);

                // if user erased the search input and the form was populated from a search, clear selection
                if (!v || v.trim() === '') {
                    if (selectedFromSearch) {
                        clearSelection();
                    }
                    clearResults();
                    return;
                }

                timer = setTimeout(() => doSearch(v), 300);
            });

        })();

        // script for the student athlete classes nav
        function toggleModal(show) {
            document.getElementById('classModal').classList.toggle('hidden', !show);
        }

        //student athlete Work and fee modal
        function toggleFeeModal(show) {
            const modal = document.getElementById('feeModal');
            if(show) {
                modal.classList.remove('hidden');
            } else {
                modal.classList.add('hidden');
            }
        }

        //student athlete Work and fee modal
        function toggleWorkModal(show) {
            const modal = document.getElementById('workModal');
            if(show) {
                modal.classList.remove('hidden');
            } else {
                modal.classList.add('hidden');
            }
        }

    </script>

@endsection
