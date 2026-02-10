@extends('layouts.app')

@section('title', 'Student Athletes')

@section('content')
    <div class="space-y-6 w-full">
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
        <div class="">
            <label class=" text-gray-700 font-medium mb-1" for="search">Search</label>
            <input type="text" id="search" name="search" placeholder="Enter full name"
                class="w-64 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600"
                autocomplete="off">
            <div id="searchResults" class="mt-2 w-64 bg-white border border-gray-200 rounded shadow-sm hidden"></div>
        </div>
        <div class="flex justify-center space-x-2 mt-4">
            <button id="saveBtn" type="submit" class="px-4 py-2 rounded bg-green-600 text-white bg-green-700 hover:bg-green-700 transition">
                Save Athlete
            </button>

            <button id="updateBtn" type="button" class="hidden px-4 py-2 rounded bg-blue-600 text-white bg-green-700 hover:bg-blue-700 transition">
                Update Athlete
            </button>

            <button type="button" onclick="resetForm()" class="px-4 py-2 rounded bg-gray-300 text-gray-800 hover:bg-gray-400 transition">
                Cancel New
            </button>
        </div>
    </div>

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

    <div id="tab-content" class="bg-white p-6 rounded shadow w-full">

        <div id="general-info" class="tab-pane">
            <div class="flex items-stretch gap-6">
                <form id="athleteForm" method="POST" action="{{ route('athletes.store') }}" class="student-form flex items-stretch gap-6 w-full" autocomplete="off">
                    @csrf

                    <input type="hidden" name="_method" id="_method" value="POST">
                    <input type="hidden" name="selected_athlete_id" id="selected_athlete_id" value="">

                    <div class="gap-4 mb-6">

                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div class="flex items-center">
                                <label for="last_name" class="w-1/3 text-gray-700 font-medium">Last Name</label>
                                <input type="text" id="last_name" name="last_name" placeholder="Enter last name"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="flex items-center">
                                <label for="first_name" class="w-1/3 text-gray-700 font-medium">First Name & MI</label>
                                <input type="text" id="first_name" name="first_name" placeholder="Enter first name"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>

                            <div class="flex items-center">
                                <label for="student_id" class="w-1/3 text-gray-700 font-medium">Student ID</label>
                                <input type="text" id="student_id" name="student_id" placeholder="Enter student ID"
                                    class="w-2/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
                            </div>
                        </div>

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

                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div class="mb-4">
                                <label class="block text-gray-700 font-bold mb-2">Coach</label>
                                <div class="p-2 border rounded bg-gray-100 text-gray-700">
                                    @php
                                        // Safety check: Ensure User exists AND Coach relationship exists
                                        $currentCoach = optional(Auth::user())->coach; 
                                    @endphp
                                    
                                    {{ $currentCoach ? $currentCoach->coach_first_name . ' ' . $currentCoach->coach_last_name : 'No coach assigned' }}
                                </div>
                            </div>
                            
                            <input type="hidden" name="coach_id" value="{{ $currentCoach ? $currentCoach->id : '' }}">
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

                    <div class="w-1/4 flex flex-col">

                        <div class="bg-gray-100 rounded-lg p-4 shadow-inner flex flex-col h-full">

                            <div class="flex flex-col items-center border border-dashed border-gray-400 rounded-lg p-3 bg-white mb-4">  
                                <span id="selected_name" class="mt-2 text-gray-800 font-semibold">
                                    {{ $selectedAthlete->full_name ?? 'No athlete selected' }}

                                </span>
                            </div>
                            
                            <div class="flex flex-col items-center border border-dashed border-gray-400 rounded-lg p-3 bg-white mb-4">
                                <div class="w-80 h-96 bg-gray-200 rounded-lg flex items-center justify-center text-gray-500 text-sm relative overflow-hidden">
                                    <img id="picturePreview" class="absolute inset-0 w-full h-full object-cover hidden" />
                                    <span id="noPictureText" class="text-gray-500 text-sm">No Picture</span>
                                </div>
                            </div>

                            <div class="space-y-3 flex-1">
                                <div class="flex items-center">
                                    <label class="w-1/3 text-sm font-medium text-gray-700">Sports Event</label>
                                    <select name="sport_event" class="w-2/3 bg-blue-100 border border-gray-300 rounded px-2 py-1">
                                        <option value="">-- Select Sport Event --</option>
                                        <option value="Basketball_Men">Basketball Men</option>
                                        <option value="Basketball_Women">Basketball Women</option>
                                        <option value="Volleyball_Men">Volleyball Men</option>
                                        <option value="Volleyball_Women">Volleyball Women</option>
                                        <option value="Archery_Men">Archery Men</option>
                                        <option value="Archery_Women">Archery Women</option>
                                        <option value="Arnis_Men">Arnis Men</option>
                                        <option value="Arnis_Women">Arnis Women</option>
                                        <option value="Athletics">Athletics</option>
                                        <option value="Badminton_Men">Badminton Men</option>
                                        <option value="Badminton_Women">Badminton Women</option>
                                        <option value="Baseball">Baseball</option>
                                        <option value="Table_Tennis_Men">Table Tennis Men</option>
                                        <option value="Table_Tennis_Women">Table Tennis Women</option>
                                        <option value="Tennis_Men">Tennis Men</option>
                                        <option value="Tennis_Women">Tennis Women</option>
                                        <option value="Swimming_Men">Swimming Men</option>
                                        <option value="Swimming_Women">Swimming Women</option>
                                        <option value="Sepak_Takraw_Men">Sepak Takraw Men</option>
                                        <option value="Sepak_Takraw_Women">Sepak Takraw Women</option>
                                        <option value="Judo_Men">Judo Men</option>
                                        <option value="Judo_Women">Judo Women</option>
                                        <option value="Wushu_Sanda">Wushu Sanda</option>
                                        <option value="Wushu_Taolu">Wushu Taolu</option>
                                        <option value="Taekwondo_Men">Taekwondo Men</option>
                                        <option value="Taekwondo_Women">Taekwondo Women</option>
                                        <option value="Chess">Chess</option>
                                        <option value="Football">Football</option>
                                        <option value="Softball">Softball</option>
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

                        </div>

                    </form>

                </div>

            </div>
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

        <div id="achievements" class="tab-pane hidden">
            <div class="space-y-6">

                <div class="bg-white p-6 shadow flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-800">🏅 Achievements</h1>

                    <button onclick="toggleAchievementModal(true)"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 shadow">
                        + Add Achievement
                    </button>
                </div>

                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table id="achievementsTable" class="min-w-full text-sm text-left">
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
                        <tbody id="achievementsTableBody">
                            
                        </tbody>
                    </table>
                </div>
            </div>

                <div id="AchievementModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-[#2e4e1f] rounded-xl shadow-xl w-full max-w-lg p-6 relative">
                        
                        <button onclick="toggleAchievementModal(false)" 
                                class="absolute top-3 right-3 text-white hover:text-grey-700">
                            ✕
                        </button>
                        
                        <h2 class="text-2xl font-semibold text-white text-center mb-4">Add Achievement</h2>
                        <form id="achievementForm">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="year" class="block text-sm font-medium text-white mb-1">Year</label>
                                    <input type="text" id="year" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-green-600 outline-none">
                                </div>
                                <div>
                                    <label for="Month-Day" class="block text-sm font-medium text-white mb-1">Month-Day</label>
                                    <input type="text" id="month_day" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-green-600 outline-none">
                                </div>
                                <div>
                                    <label for="event" class="block text-sm font-medium text-white mb-1">Sports Event</label>
                                    <input type="text" id="event" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-green-600 outline-none">
                                </div>
                                <div>
                                    <label for="venue" class="block text-sm font-medium text-white mb-1">Venue</label>
                                    <input type="text" id="venue" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-green-600 outline-none">
                                </div>
                                <div>
                                    <label for="award" class="block text-sm font-medium text-white mb-1">Award</label>
                                    <select id="award" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-green-600 outline-none">
                                        <option value="">Select Award</option>
                                        <option value="Gold">Gold</option>
                                        <option value="Silver">Silver</option>
                                        <option value="Bronze">Bronze</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="category" class="block text-sm font-medium text-white mb-1">Category</label>
                                    <input type="text" id="category" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-green-600 outline-none">
                                </div>
                                <div class="mt-4">
                                    <label for="remarks" class="block text-sm font-medium text-white mb-1">Remarks</label>
                                    <textarea id="remarks" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-green-600 outline-none"></textarea>
                                </div>
                            </div>
                            <button type="submit" class="bg-green-600 text-white w-full py-2 rounded-lg hover:bg-green-700">
                                Save Achievement
                            </button>
                        </form>
                    </div>
                </div>

        </div> 

        <div id="academic-evolution" class="tab-pane hidden">
            <div class="space-y-6">

                <div class="bg-white p-6 shadow flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-800">Academic Evaluation</h1>

                    <button onclick="toggleAcademicModal(true)"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 shadow">
                        + Add Record
                    </button>
                </div>

                <div>
                    <table class="w-full text-left">
                        <thead class="bg-green-600 text-white text-center">
                            <tr>
                                <th class="py-3">Units Passed</th>
                                <th class="py-3">Units Enrolled</th>
                                <th class="py-3">Percentage</th>
                                <th class="py-3">Remarks</th>
                            </tr>
                        </thead>

                        <tbody id="gradesTable" class="text-gray-700">
                            
                        </tbody>
                    </table>
                </div>

            </div>

            <div id="academicModal" 
                class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

                <div class="bg-[#2e4e1f] rounded-xl shadow-xl w-full max-w-lg p-6 relative">

                    <button onclick="toggleAcademicModal(false)" 
                            class="absolute top-3 right-3 text-white hover:text-red-700">
                        ✕
                    </button>

                    <h2 class="text-xl font-bold mb-4 text-white">Add Academic Record</h2>

                    <form id="academicForm" class="space-y-4">

                        <div>
                            <label class="text-white font-medium">Units Passed</label>
                            <input type="number" class="w-full border rounded px-3 py-2" 
                                name="Passed" placeholder="Units Passed">
                        </div>

                        <div>
                            <label class="text-white font-medium">Units enrolled</label>
                            <input type="number" class="w-full border rounded px-3 py-2" 
                                step="0.01" name="enrolled" placeholder="Enter Units Enrolled">
                        </div>

                        <div>
                            <label class="text-white font-medium">Percentage</label>
                            <input type="text" class="w-full border rounded px-3 py-2" 
                                name="percentage" placeholder="Enter Percentage">
                        </div>

                        <div>
                            <label class="text-white font-medium">Remark</label>
                            <select name="remark" class="w-full border rounded px-3 py-2">
                                <option value="">Select</option>
                                <option>Passed</option>
                                <option>Failed</option>
                                <option>Incomplete</option>
                                <option>Dropped</option>
                            </select>
                        </div>

                        <button type="submit" class="bg-green-600 text-white w-full py-2 rounded-lg hover:bg-green-700">
                            Save Record
                        </button>

                    </form> 

                </div> 

            </div> 

        </div> 


        <div id="fees-discounts" class="tab-pane hidden">
            <div class="bg-white rounded-lg shadow p-4">
               <div class="bg-white p-6 shadow flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-800">Fees and Discounts</h1>

                    <button onclick="toggleFeeModal(true)"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 shadow">
                        + Add Fee / Discount
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-300 text-sm text-gray-700">
                        <thead class="bg-green-600 text-white text-center">
                            <tr>
                                <th class="border border-gray-300 px-4 py-2 ">Academic Term and Year</th>
                                <th class="border border-gray-300 px-4 py-2 ">Total Units Enrolled</th>
                                <th class="border border-gray-300 px-4 py-2 ">Tuition Fee</th>
                                <th class="border border-gray-300 px-4 py-2 ">Miscellaneous Fee</th>
                                <th class="border border-gray-300 px-4 py-2 ">Other Charges</th>
                                <th class="border border-gray-300 px-4 py-2 ">Total Assessment</th>
                                <th class="border border-gray-300 px-4 py-2 ">Total Discount</th>
                                <th class="border border-gray-300 px-4 py-2 ">Remarks</th>
                            </tr>
                        </thead>
                        <tbody id="fees-discounts-table-body">
                            
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="feeModal" 
                class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

                <div class="bg-[#2e4e1f] rounded-xl shadow-xl w-full max-w-lg p-6 relative">

                    <button type="button" onclick="toggleFeeModal(false)" 
                            class="absolute top-3 right-3 text-white hover:text-white">
                        ✕
                    </button>

                    <h2 class="text-xl font-bold mb-4 text-center text-white">Add Fee / Discount</h2>

                    <form id="feeForm" class="space-y-4">

                        <div>
                            <label class="text-white font-medium">Academic Term and Year</label>
                            <input type="text" name="academic_year" placeholder="Ex: 2025-2026"
                                class="w-full border rounded px-3 py-2">
                        </div>

                        <div>
                            <label class="text-white font-medium">Total Units Enrolled</label>
                            <input type="number" name="total_units" class="w-full border rounded px-3 py-2">
                        </div>

                        <div>
                            <label class="text-white font-medium">Tuition Fee</label>
                            <input type="number" name="tuition_fee" class="w-full border rounded px-3 py-2">
                        </div>

                        <div>
                            <label class="text-white font-medium">Miscellaneous Fee</label>
                            <input type="number" name="miscellaneous_fee" class="w-full border rounded px-3 py-2">
                        </div>

                        <div>
                            <label class="text-white font-medium">Other Charges</label>
                            <input type="number" name="other_charges" class="w-full border rounded px-3 py-2">
                        </div>

                        <div>
                            <label class="text-white font-medium">Total Assessment</label>
                            <input type="number" name="total_assessment" class="w-full border rounded px-3 py-2">
                        </div>

                        <div>
                            <label class="text-white font-medium">Total Discount</label>
                            <input type="number" name="total_discount" class="w-full border rounded px-3 py-2">
                        </div>

                        <div>
                            <label class="text-white font-medium">Remarks</label>
                            <select name="remarks" class="w-full border rounded px-3 py-2">
                                <option value="">Select</option>
                                <option>Paid</option>
                                <option>Pending</option>
                                <option>Waived</option>
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

        <div id="work-history" class="tab-pane hidden">
            <div class="bg-white rounded-lg shadow p-4">
                <div class="bg-white p-6 shadow flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-800">Work History</h1>

                    <button onclick="toggleWorkModal(true)"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 shadow">
                        + Add Work History
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-300 text-sm text-gray-700">
                        <thead class="bg-green-600 text-white text-center">
                            <tr>
                                <th class="border border-gray-300 px-4 py-2 ">Year</th>
                                <th class="border border-gray-300 px-4 py-2 ">Date</th>
                                <th class="border border-gray-300 px-4 py-2 ">Work Position</th>
                                <th class="border border-gray-300 px-4 py-2 ">Name of Company</th>
                                <th class="border border-gray-300 px-4 py-2 ">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="workModal" 
                class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

                <div class="bg-[#2e4e1f] rounded-xl shadow-xl w-full max-w-lg p-6 relative">

                    <button type="button" onclick="toggleWorkModal(false)" 
                            class="absolute top-3 right-3 text-white hover:text-white">
                        ✕
                    </button>

                    <h2 class="text-xl font-bold mb-4 text-center text-white">Add Work History</h2>

                    <form id="workForm" class="space-y-4">

                        
                        <div>
                            <label class="text-white font-medium">Year</label>
                            <input type="text" name="year" placeholder="Ex: 2025"
                                class="w-full border rounded px-3 py-2">
                        </div>

                        
                        <div>
                            <label class="text-white font-medium">Date</label>
                            <input type="date" name="date" class="w-full border rounded px-3 py-2">
                        </div>

                        
                        <div>
                            <label class="text-white font-medium">Work Position</label>
                            <input type="text" name="position" placeholder="Ex: Coach"
                                class="w-full border rounded px-3 py-2">
                        </div>

                        
                        <div>
                            <label class="text-white font-medium">Name of Company</label>
                            <input type="text" name="company" placeholder="Ex: ABC Sports Academy"
                                class="w-full border rounded px-3 py-2">
                        </div>

                        
                        <div>
                            <label class="text-white font-medium">Remarks</label>
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
        <div id="student-id" class="tab-pane hidden">
            <p>Stuydents ID content goes here...</p>
        </div>

    </div> <script>
    document.addEventListener('DOMContentLoaded', () => {
        // -----------------------
        // Helpers
        // -----------------------
        const byId = id => document.getElementById(id);
        const q = sel => document.querySelector(sel);

        // Safe-get tbody or fallback selectors
        const getAchievementsTbody = () => byId('achievementsTableBody') || byId('achievementsTable')?.querySelector('tbody') || q('#achievements table tbody');
        const getGradesTbody = () => byId('gradesTable') || q('#academic-evolution table tbody');
        const getFeesTbody = () => byId('fees-discounts-table-body') || q('#fees-discounts table tbody');
        const getWorkTbody = () => q('#work-history table tbody');

        // -----------------------
        // Globals
        // -----------------------
        window.newAthleteData = {
            generalInfo: {},
            achievements: [],
            academicRecords: [],
            fees: [],
            workHistory: []
        };

        // -----------------------
        // TAB SWITCHING
        // -----------------------
        (function initTabs(){
            const tabs = document.querySelectorAll('.tab-link');
            const contents = document.querySelectorAll('.tab-pane');    

            const defaultTab = document.querySelector('.tab-link[href="#general-info"]');
            const defaultContent = byId('general-info');

            if (defaultTab && defaultContent) {
                tabs.forEach(t => t.classList.remove('border-b-2', 'border-green-600', 'text-green-600'));
                contents.forEach(c => c.classList.add('hidden'));
                defaultTab.classList.add('border-b-2', 'border-green-600', 'text-green-600');
                defaultContent.classList.remove('hidden');
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
        // GENERAL INFO (collect only)
        // -----------------------
        const generalForm = byId('athleteForm');
        const saveBtn = byId('saveBtn');
        const updateBtn = byId('updateBtn');
        const selectedIdInput = byId('selected_athlete_id');
        const methodInput = byId('_method');

        function collectGeneralInfo() {
            if (!generalForm) return;
            const inputs = generalForm.querySelectorAll('input[name], select[name], textarea[name]');
            inputs.forEach(input => {
                newAthleteData.generalInfo[input.name] = input.value;
            });
        }

        // -----------------------
        // LIVE SEARCH & LOAD LOGIC
        // -----------------------
        const searchInput = byId('search');
        const resultsBox = byId('searchResults');
        const updateBase = '{{ url('/athletes') }}';

        // FUNCTION: LOAD ATHLETE DATA INTO FORM
        window.loadAthleteData = function(id) {
            if (!generalForm) return;

            // Set form to "Update Mode"
            generalForm.setAttribute('action', updateBase + '/' + id);
            if (methodInput) methodInput.value = 'PUT';
            if (selectedIdInput) selectedIdInput.value = id;
            if (saveBtn) saveBtn.classList.add('hidden');
            if (updateBtn) updateBtn.classList.remove('hidden');

            // Fetch Data
            fetch(updateBase + '/' + id, { headers: { 'Accept': 'application/json' } })
                .then(r => r.json())
                .then(full => {
                    console.log("Loaded Data:", full);

                    // 1. POPULATE INPUTS
                    for (const key in full) {
                        try {
                            const el = generalForm.querySelector(`[name="${key}"]`);
                            if (!el) continue;
                            
                            if (el.tagName === 'SELECT') {
                                let val = String(full[key]).trim().toLowerCase();
                                // Try exact match then partial match
                                let found = false;
                                for(let i=0; i<el.options.length; i++) {
                                    if(el.options[i].value.toLowerCase() === val) {
                                        el.selectedIndex = i; found = true; break;
                                    }
                                }
                                if(!found) {
                                    for(let i=0; i<el.options.length; i++) {
                                        if(el.options[i].value.toLowerCase().includes(val)) {
                                            el.selectedIndex = i; break;
                                        }
                                    }
                                }
                            } else if (el.type !== 'file') {
                                el.value = full[key] ?? '';
                            }
                        } catch (err) {}
                    }

                    // Special Field Fixes
                    if (full.birthdate) {
                        const el = generalForm.querySelector('[name="birthdate"]');
                        if(el) el.value = full.birthdate.split('T')[0];
                    }
                    if (full.picture_url) {
                        const preview = byId('picturePreview');
                        const noPic = byId('noPictureText');
                        if (preview) { preview.src = full.picture_url; preview.classList.remove('hidden'); }
                        if (noPic) noPic.classList.add('hidden');
                    }
                    const selectedName = byId('selected_name');
                    if (selectedName) selectedName.textContent = full.full_name || full.first_name + ' ' + full.last_name;

                    // 2. POPULATE TABLES
                    // Achievements
                    newAthleteData.achievements = full.achievements || [];
                    const achTbody = getAchievementsTbody();
                    if(achTbody) {
                        achTbody.innerHTML = '';
                        newAthleteData.achievements.forEach((a, idx) => {
                            achTbody.innerHTML += `
                                <tr class="${idx % 2 === 0 ? 'bg-gray-50' : 'bg-white'}">
                                    <td class="px-6 py-3">${a.year || ''}</td>
                                    <td class="px-6 py-3">${a.month_day || ''}</td>
                                    <td class="px-6 py-3">${a.event || ''}</td>
                                    <td class="px-6 py-3">${a.venue || ''}</td>
                                    <td class="px-6 py-3 text-green-700 font-bold">${a.award || ''}</td>
                                    <td class="px-6 py-3">${a.category || ''}</td>
                                    <td class="px-6 py-3">${a.remarks || ''}</td>
                                </tr>`;
                        });
                    }

                    // Academics
                    newAthleteData.academicRecords = full.academic_evaluations || [];
                    const gradesTbody = getGradesTbody();
                    if(gradesTbody) {
                        gradesTbody.innerHTML = '';
                        newAthleteData.academicRecords.forEach((r, idx) => {
                            gradesTbody.innerHTML += `
                                <tr class="${idx % 2 === 0 ? 'bg-gray-50' : 'bg-white'}">
                                    <td class="px-6 py-3 text-center">${r.passed || ''}</td>
                                    <td class="px-6 py-3 text-center">${r.enrolled || ''}</td>
                                    <td class="px-6 py-3 text-center">${r.percentage || ''}</td>
                                    <td class="px-6 py-3 text-center">${r.remark || ''}</td>
                                </tr>`;
                        });
                    }

                    // Fees
                    newAthleteData.fees = full.fees_discounts || [];
                    const feesTbody = getFeesTbody();
                    if(feesTbody) {
                        feesTbody.innerHTML = '';
                        newAthleteData.fees.forEach((f, idx) => {
                            feesTbody.innerHTML += `
                                <tr class="text-center ${idx % 2 === 0 ? 'bg-gray-50' : 'bg-white'}">
                                    <td class="border px-4 py-2">${f.academic_year || ''}</td>
                                    <td class="border px-4 py-2">${f.total_units || ''}</td>
                                    <td class="border px-4 py-2">${f.tuition_fee || ''}</td>
                                    <td class="border px-4 py-2">${f.miscellaneous_fee || ''}</td>
                                    <td class="border px-4 py-2">${f.other_charges || ''}</td>
                                    <td class="border px-4 py-2">${f.total_assessment || ''}</td>
                                    <td class="border px-4 py-2">${f.total_discount || ''}</td>
                                    <td class="border px-4 py-2">${f.remarks || ''}</td>
                                </tr>`;
                        });
                    }

                    // Work
                    newAthleteData.workHistory = full.work_histories || [];
                    const workTbody = getWorkTbody();
                    if(workTbody) {
                        workTbody.innerHTML = '';
                        newAthleteData.workHistory.forEach(w => {
                            workTbody.innerHTML += `
                                <tr class="bg-white">
                                    <td class="border px-4 py-2">${w.year || ''}</td>
                                    <td class="border px-4 py-2">${w.date || ''}</td>
                                    <td class="border px-4 py-2">${w.position || ''}</td>
                                    <td class="border px-4 py-2">${w.company || ''}</td>
                                    <td class="border px-4 py-2">${w.remarks || ''}</td>
                                </tr>`;
                        });
                    }

                })
                .catch(err => console.error("Error loading athlete:", err));
        };

        // SEARCH BAR LOGIC
        if (searchInput && resultsBox) {
            let timer = null;
            const searchUrl = '{{ route('athletes.search') }}';

            searchInput.addEventListener('input', (e) => {
                const v = e.target.value;
                if (timer) clearTimeout(timer);
                if (!v || v.trim() === '') {
                    resultsBox.innerHTML = ''; resultsBox.classList.add('hidden'); return;
                }
                timer = setTimeout(() => {
                    fetch(searchUrl + '?q=' + encodeURIComponent(v), { headers: { 'Accept': 'application/json' } })
                        .then(r => r.json())
                        .then(items => {
                            resultsBox.innerHTML = '';
                            if(items.length === 0) { resultsBox.classList.add('hidden'); return; }
                            
                            items.forEach(item => {
                                const div = document.createElement('div');
                                div.className = 'px-3 py-2 hover:bg-gray-100 cursor-pointer text-sm';
                                div.textContent = (item.full_name || item.first_name + ' ' + item.last_name) + ' (' + item.student_id + ')';
                                div.onclick = () => {
                                    loadAthleteData(item.id); // Call our shared load function
                                    resultsBox.innerHTML = '';
                                    resultsBox.classList.add('hidden');
                                    searchInput.value = item.first_name + ' ' + item.last_name;
                                };
                                resultsBox.appendChild(div);
                            });
                            resultsBox.classList.remove('hidden');
                        });
                }, 300);
            });
        }

        // -----------------------
        // ** CHECK URL FOR ID ** (THIS FIXES THE EDIT BUTTON)
        // -----------------------
        const urlParams = new URLSearchParams(window.location.search);
        const urlId = urlParams.get('id');
        if (urlId) {
            console.log("Found ID in URL, loading:", urlId);
            loadAthleteData(urlId);
        }

        // -----------------------
        // ACHIEVEMENTS / ACADEMIC / FEES / WORK MODALS
        // -----------------------
        // (Keep your existing modal logic mostly the same, but use newAthleteData array)
        
        // Helper to toggle any modal
        window.toggleModal = (id, show) => {
            const m = byId(id);
            if(m) m.classList.toggle('hidden', !show);
        };
        
        window.toggleAchievementModal = (s) => toggleModal('AchievementModal', s);
        window.toggleAcademicModal = (s) => toggleModal('academicModal', s);
        window.toggleFeeModal = (s) => toggleModal('feeModal', s);
        window.toggleWorkModal = (s) => toggleModal('workModal', s);

        // SIMPLE FORM HANDLERS (Push to array & Update DOM)
        // Achievements
        const achForm = byId('achievementForm');
        if(achForm) achForm.addEventListener('submit', e => {
            e.preventDefault();
            const data = {
                year: byId('year').value,
                monthDay: byId('month_day').value,
                event: byId('event').value,
                venue: byId('venue').value,
                award: byId('award').value,
                category: byId('category').value,
                remarks: byId('remarks').value
            };
            newAthleteData.achievements.push(data);
            // Refresh Table
            const tbody = getAchievementsTbody();
            if(tbody) tbody.innerHTML += `<tr><td class="px-6 py-3">${data.year}</td><td class="px-6 py-3">${data.monthDay}</td><td class="px-6 py-3">${data.event}</td><td class="px-6 py-3">${data.venue}</td><td class="px-6 py-3 text-green-700">${data.award}</td><td class="px-6 py-3">${data.category}</td><td class="px-6 py-3">${data.remarks}</td></tr>`;
            achForm.reset(); toggleAchievementModal(false);
        });

        // Academics
        const acForm = byId('academicForm');
        if(acForm) acForm.addEventListener('submit', e => {
            e.preventDefault();
            const data = {
                passed: acForm.querySelector('[name="Passed"]').value,
                enrolled: acForm.querySelector('[name="enrolled"]').value,
                percentage: acForm.querySelector('[name="percentage"]').value,
                remark: acForm.querySelector('[name="remark"]').value
            };
            newAthleteData.academicRecords.push(data);
            const tbody = getGradesTbody();
            if(tbody) tbody.innerHTML += `<tr><td class="px-6 py-3 text-center">${data.passed}</td><td class="px-6 py-3 text-center">${data.enrolled}</td><td class="px-6 py-3 text-center">${data.percentage}</td><td class="px-6 py-3 text-center">${data.remark}</td></tr>`;
            acForm.reset(); toggleAcademicModal(false);
        });

        // Fees
        const feeForm = byId('feeForm');
        if(feeForm) feeForm.addEventListener('submit', e => {
            e.preventDefault();
            const formData = new FormData(feeForm);
            const data = Object.fromEntries(formData.entries());
            newAthleteData.fees.push(data);
            const tbody = getFeesTbody();
            if(tbody) tbody.innerHTML += `<tr class="text-center"><td class="border px-4 py-2">${data.academic_year}</td><td class="border px-4 py-2">${data.total_units}</td><td class="border px-4 py-2">${data.tuition_fee}</td><td class="border px-4 py-2">${data.miscellaneous_fee}</td><td class="border px-4 py-2">${data.other_charges}</td><td class="border px-4 py-2">${data.total_assessment}</td><td class="border px-4 py-2">${data.total_discount}</td><td class="border px-4 py-2">${data.remarks}</td></tr>`;
            feeForm.reset(); toggleFeeModal(false);
        });

        // Work
        const workForm = byId('workForm');
        if(workForm) workForm.addEventListener('submit', e => {
            e.preventDefault();
            const formData = new FormData(workForm);
            const data = Object.fromEntries(formData.entries());
            newAthleteData.workHistory.push(data);
            const tbody = getWorkTbody();
            if(tbody) tbody.innerHTML += `<tr class="bg-white"><td class="border px-4 py-2">${data.year}</td><td class="border px-4 py-2">${data.date}</td><td class="border px-4 py-2">${data.position}</td><td class="border px-4 py-2">${data.company}</td><td class="border px-4 py-2">${data.remarks}</td></tr>`;
            workForm.reset(); toggleWorkModal(false);
        });

        // -----------------------
        // FINAL SAVE
        // -----------------------
        function performFinalSave(e) {
            e.preventDefault();
            collectGeneralInfo(); // Update global object with inputs

            // Determine URL (Create or Update)
            const selectedId = selectedIdInput ? selectedIdInput.value : null;
            const endpoint = selectedId ? (updateBase + '/' + selectedId) : updateBase;
            const method = selectedId ? 'PUT' : 'POST';

            fetch(endpoint, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(newAthleteData)
            })
            .then(async r => {
                const data = await r.json();
                if(!r.ok) throw data;
                alert('Athlete saved successfully!');
                window.location.href = "{{ route('athletes.index') }}"; // Redirect to list after save
            })
            .catch(err => {
                console.error(err);
                alert('Error saving: ' + (err.message || JSON.stringify(err)));
            });
        }

        if (saveBtn) saveBtn.addEventListener('click', performFinalSave);
        if (updateBtn) updateBtn.addEventListener('click', performFinalSave);

    }); // End DOMContentLoaded

    // =======================================================
    // NEW LOGIC: CHECK URL FOR ID AND AUTO-FILL
    // =======================================================
    const urlParams = new URLSearchParams(window.location.search);
    const editId = urlParams.get('id'); // Get "5" from "?id=5"

    if (editId) {
        console.log("Edit Mode Detected for ID:", editId);
        
        // 1. Switch Form to "Update Mode"
        const form = document.getElementById('athleteForm');
        const saveBtn = document.getElementById('saveBtn');
        const updateBtn = document.getElementById('updateBtn');
        const methodInput = document.getElementById('_method');
        const selectedIdInput = document.getElementById('selected_athlete_id');

        if (form) {
            // Update the form action to point to the update route
            form.setAttribute('action', '/athletes/' + editId); 
            if (methodInput) methodInput.value = 'PUT'; // Laravel needs this for updates
            if (selectedIdInput) selectedIdInput.value = editId;
            
            // Swap Buttons
            if (saveBtn) saveBtn.classList.add('hidden');
            if (updateBtn) updateBtn.classList.remove('hidden');
        }

        // 2. Fetch Data and Fill Inputs
        fetch('/athlete/' + editId, { 
            headers: { 'Accept': 'application/json' } 
        })
        .then(response => response.json())
        .then(data => {
            // Loop through all data and fill matching inputs
            for (const key in data) {
                // Try to find input by name="key"
                const input = document.querySelector(`[name="${key}"]`);
                if (input) {
                    if (input.type === 'date' && data[key]) {
                        // Fix date format
                        input.value = data[key].split('T')[0];
                    } else if (input.tagName === 'SELECT') {
                        // Select the correct option
                        input.value = data[key];
                    } else if (input.type !== 'file') {
                        input.value = data[key];
                    }
                }
            }
            
            // Special handling for Profile Picture Preview
            if (data.picture_path) {
                const preview = document.getElementById('picturePreview');
                const noText = document.getElementById('noPictureText');
                if(preview) {
                    preview.src = '/storage/' + data.picture_path;
                    preview.classList.remove('hidden');
                }
                if(noText) noText.classList.add('hidden');
            }

            // Fill the "Selected Name" box on the right
            const nameDisplay = document.getElementById('selected_name');
            if(nameDisplay) nameDisplay.textContent = data.first_name + ' ' + data.last_name;
        })
        .catch(error => console.error('Error fetching athlete:', error));
    }
    </script>



@endsection