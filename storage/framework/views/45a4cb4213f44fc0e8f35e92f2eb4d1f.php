<?php $__env->startSection('title', 'Student Athletes'); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-6 w-full">
    <!-- Page Header -->
    <div class="bg-white p-6 flex items-center justify-between">
        <div class="flex-1 text-center">
            <h1 class="text-3xl font-bold text-gray-800 mb-0">Student Athlete</h1>
        </div>
        <div>
            <a href="<?php echo e(route('student.athletes')); ?>" 
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
        <!-- Save All Button -->
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
                <form id="athleteForm" method="POST" action="<?php echo e(route('athletes.store')); ?>" class="student-form flex items-stretch gap-6 w-full" autocomplete="off">
                    <?php echo csrf_field(); ?>

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
                            <div class="mb-4">
                                <label class="block text-gray-700 font-bold mb-2">Coach</label>
                                <div class="p-2 border rounded bg-gray-100 text-gray-700">
                                    <?php echo e(Auth::user()->coach ? Auth::user()->coach->coach_first_name . ' ' . Auth::user()->coach->coach_last_name : 'No coach assigned'); ?>

                                </div>
                            </div>

                            <input type="hidden" name="coach_id" value="<?php echo e(Auth::user()->coach ? Auth::user()->coach->id : ''); ?>">


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
                                    <?php echo e($selectedAthlete->name ?? 'No athlete selected'); ?>

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

                            <!-- CENTERED BUTTONS BELOW THE RIGHT SIDE PANEL
                            <div class="flex justify-center space-x-2 mt-4">
                                <button id="saveBtn" type="submit" class="px-4 py-2 rounded bg-green-600 text-white bg-green-700 hover:bg-green-700 transition">
                                    Save Athlete
                                </button>

                                <button id="updateBtn" type="submit" class="hidden px-4 py-2 rounded bg-blue-600 text-white bg-green-700 hover:bg-blue-700 transition">
                                    Update Athlete
                                </button>

                                <button type="button" onclick="resetForm()" class="px-4 py-2 rounded bg-gray-300 text-gray-800 hover:bg-gray-400 transition">
                                    Cancel New
                                </button>
                            </div> -->
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
        
        <!-- Achievement Tab -->
        <div id="achievements" class="tab-pane hidden">
            <div class="space-y-6">

                <!-- PAGE HEADER -->
                <div class="bg-white p-6 shadow flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-800">🏅 Achievements</h1>

                    <button onclick="toggleAchievementModal(true)"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 shadow">
                        + Add Achievement
                    </button>
                </div>

                <!-- Achievements Table -->
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

                <!-- Modal -->
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
                            <!-- Submit -->
                            <button type="submit" class="bg-green-600 text-white w-full py-2 rounded-lg hover:bg-green-700">
                                Save Achievement
                            </button>
                        </form>
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

                    <button onclick="toggleAcademicModal(true)"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 shadow">
                        + Add Record
                    </button>
                </div>

                <!-- SUBJECT TABLE -->
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

            <!-- ADD SUBJECT MODAL -->
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

            <!-- ADD FEE / DISCOUNT MODAL -->
            <div id="feeModal" 
                class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

                <div class="bg-[#2e4e1f] rounded-xl shadow-xl w-full max-w-lg p-6 relative">

                    <!-- CLOSE BUTTON -->
                    <button type="button" onclick="toggleFeeModal(false)" 
                            class="absolute top-3 right-3 text-white hover:text-white">
                        ✕
                    </button>

                    <h2 class="text-xl font-bold mb-4 text-center text-white">Add Fee / Discount</h2>

                    <form id="feeForm" class="space-y-4">

                        <!-- Academic Year -->
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

            <!-- ADD WORK HISTORY MODAL -->
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
        <!-- ================================================================================================ -->
        <!-- Student ID Tab -->
        <div id="student-id" class="tab-pane hidden">
            <!-- Add Achievements form or table here -->
            <p>Stuydents ID content goes here...</p>
        </div>

    </div> <!-- End of Content Area -->

    <script>
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

    // Save button (final local-save feedback)
    if (saveBtn) {
        saveBtn.addEventListener('click', e => {
            e.preventDefault();
            collectGeneralInfo();
            // feedback
            alert('General information saved locally. Click "Save Athlete" to persist everything.');
        });
    }

    // -----------------------
    // LIVE SEARCH (search + populate form)
    // -----------------------
    (function initLiveSearch() {
        const searchInput = byId('search');
        const resultsBox = byId('searchResults');
        // If not present, skip live search
        if (!searchInput || !resultsBox) return;

        const searchUrl = '<?php echo e(route('athletes.search')); ?>'; // Blade route (should produce URL)
        let timer = null;
        let selectedFromSearch = false;
        let selectedId = null;

        const defaultAction = generalForm ? generalForm.getAttribute('action') : '<?php echo e(route('athletes.store')); ?>';
        const updateBase = '<?php echo e(url('/athletes')); ?>';

        function clearResults() {
            resultsBox.innerHTML = '';
            resultsBox.classList.add('hidden');
        }

        function clearSelection() {
            if (!generalForm) return;
            // clear inputs
            generalForm.querySelectorAll('input, select, textarea').forEach(el => {
                if (el.name === '_method') return;
                if (el.type === 'file') {
                    el.value = '';
                    const preview = byId('picturePreview');
                    if (preview) { preview.src = ''; preview.classList.add('hidden'); }
                    const noPic = byId('noPictureText');
                    if (noPic) noPic.classList.remove('hidden');
                } else if (el.tagName === 'SELECT') {
                    el.selectedIndex = 0;
                } else {
                    el.value = '';
                }
            });

            // reset selected display
            const selectedName = byId('selected_name');
            if (selectedName) selectedName.textContent = 'No athlete selected';

            selectedFromSearch = false;
            selectedId = null;
            if (generalForm) generalForm.setAttribute('action', defaultAction);
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
                const name = (item.full_name && item.full_name.trim() !== '') ? item.full_name : (item.first_name + ' ' + (item.last_name || ''));
                div.textContent = name + (item.student_id ? ' — ' + item.student_id : '');
                div.addEventListener('click', () => {
                    if (!generalForm) return;

                    selectedFromSearch = true;
                    selectedId = item.id || null;
                    if (selectedIdInput) selectedIdInput.value = selectedId;

                    if (generalForm && selectedId) {
                        generalForm.setAttribute('action', updateBase + '/' + selectedId);
                        if (methodInput) methodInput.value = 'PUT';
                    }

                    // fetch full athlete (with related sections) and populate UI
                    fetch(updateBase + '/' + selectedId, { headers: { 'Accept': 'application/json' } })
                        .then(r => r.json())
                        .then(full => {
                            // populate general form fields from returned object
                            for (const key in full) {
                                try {
                                    const el = generalForm.querySelector(`[name="${key}"]`);
                                    if (!el) continue;
                                    if (el.tagName === 'SELECT') {
                                        for (let i = 0; i < el.options.length; i++) {
                                            if (String(el.options[i].value).trim().toLowerCase() === String(full[key]).trim().toLowerCase()) {
                                                el.selectedIndex = i;
                                                break;
                                            }
                                        }
                                    } else if (el.type === 'file') {
                                        // skip
                                    } else {
                                        el.value = full[key] ?? '';
                                    }
                                } catch (err) { /* ignore DOM mismatches */ }
                            }

                            // picture
                            if (full.picture_url) {
                                const preview = byId('picturePreview');
                                const noPic = byId('noPictureText');
                                if (preview) { preview.src = full.picture_url; preview.classList.remove('hidden'); }
                                if (noPic) noPic.classList.add('hidden');
                            }

                            const selectedName = byId('selected_name');
                            if (selectedName) selectedName.textContent = (full.full_name || (full.first_name + ' ' + (full.last_name || '')));

                            // populate achievements table
                            newAthleteData.achievements = Array.isArray(full.achievements) ? full.achievements.map(a => ({
                                year: a.year ?? '',
                                monthDay: a.month_day ?? a.monthDay ?? '',
                                event: a.event ?? '',
                                venue: a.venue ?? '',
                                award: a.award ?? '',
                                category: a.category ?? '',
                                remarks: a.remarks ?? ''
                            })) : [];

                            const achTbody = getAchievementsTbody();
                            if (achTbody) achTbody.innerHTML = '';
                            newAthleteData.achievements.forEach((a, idx) => {
                                const tr = document.createElement('tr');
                                tr.className = idx % 2 === 0 ? 'bg-gray-50' : 'bg-white';
                                tr.innerHTML = `
                                    <td class="px-6 py-3">${a.year}</td>
                                    <td class="px-6 py-3">${a.monthDay}</td>
                                    <td class="px-6 py-3">${a.event}</td>
                                    <td class="px-6 py-3">${a.venue}</td>
                                    <td class="px-6 py-3 text-green-700 font-bold">${a.award}</td>
                                    <td class="px-6 py-3">${a.category}</td>
                                    <td class="px-6 py-3">${a.remarks}</td>
                                `;
                                if (achTbody) achTbody.appendChild(tr);
                            });

                            // academic records
                            newAthleteData.academicRecords = Array.isArray(full.academic_evaluations) ? full.academic_evaluations.map(r => ({
                                passed: r.passed ?? '',
                                enrolled: r.enrolled ?? '',
                                percentage: r.percentage ?? '',
                                remark: r.remark ?? r.remarks ?? ''
                            })) : (Array.isArray(full.academicEvaluations) ? full.academicEvaluations.map(r => ({
                                passed: r.passed ?? '',
                                enrolled: r.enrolled ?? '',
                                percentage: r.percentage ?? '',
                                remark: r.remark ?? r.remarks ?? ''
                            })) : []);

                            const gradesTbody = getGradesTbody();
                            if (gradesTbody) gradesTbody.innerHTML = '';
                            newAthleteData.academicRecords.forEach((r, idx) => {
                                const tr = document.createElement('tr');
                                tr.className = idx % 2 === 0 ? 'bg-gray-50' : 'bg-white';
                                tr.innerHTML = `
                                    <td class="px-6 py-3 text-center">${r.passed}</td>
                                    <td class="px-6 py-3 text-center">${r.enrolled}</td>
                                    <td class="px-6 py-3 text-center">${r.percentage}</td>
                                    <td class="px-6 py-3 text-center">${r.remark}</td>
                                `;
                                if (gradesTbody) gradesTbody.appendChild(tr);
                            });

                            // fees
                            newAthleteData.fees = Array.isArray(full.fees_discounts) ? full.fees_discounts.map(f => ({
                                academic_year: f.academic_year ?? '',
                                total_units: f.total_units ?? '',
                                tuition_fee: f.tuition_fee ?? '',
                                miscellaneous_fee: f.miscellaneous_fee ?? f.misc_fee ?? '',
                                other_charges: f.other_charges ?? '',
                                total_assessment: f.total_assessment ?? '',
                                total_discount: f.total_discount ?? '',
                                remarks: f.remarks ?? ''
                            })) : (Array.isArray(full.feesDiscounts) ? full.feesDiscounts.map(f => ({
                                academic_year: f.academic_year ?? '',
                                total_units: f.total_units ?? '',
                                tuition_fee: f.tuition_fee ?? '',
                                miscellaneous_fee: f.miscellaneous_fee ?? f.misc_fee ?? '',
                                other_charges: f.other_charges ?? '',
                                total_assessment: f.total_assessment ?? '',
                                total_discount: f.total_discount ?? '',
                                remarks: f.remarks ?? ''
                            })) : []);

                            const feesTbody = getFeesTbody();
                            if (feesTbody) feesTbody.innerHTML = '';
                            newAthleteData.fees.forEach((f, idx) => {
                                const tr = document.createElement('tr');
                                tr.className = idx % 2 === 0 ? 'bg-gray-50 text-center' : 'bg-white text-center';
                                tr.innerHTML = `
                                    <td class="border px-4 py-2">${f.academic_year}</td>
                                    <td class="border px-4 py-2">${f.total_units}</td>
                                    <td class="border px-4 py-2">${f.tuition_fee}</td>
                                    <td class="border px-4 py-2">${f.miscellaneous_fee}</td>
                                    <td class="border px-4 py-2">${f.other_charges}</td>
                                    <td class="border px-4 py-2">${f.total_assessment}</td>
                                    <td class="border px-4 py-2">${f.total_discount}</td>
                                    <td class="border px-4 py-2">${f.remarks}</td>
                                `;
                                if (feesTbody) feesTbody.appendChild(tr);
                            });

                            // work history
                            newAthleteData.workHistory = Array.isArray(full.work_histories) ? full.work_histories.map(w => ({
                                year: w.year ?? '',
                                date: w.date ?? '',
                                position: w.position ?? '',
                                company: w.company ?? '',
                                remarks: w.remarks ?? ''
                            })) : (Array.isArray(full.workHistories) ? full.workHistories.map(w => ({
                                year: w.year ?? '',
                                date: w.date ?? '',
                                position: w.position ?? '',
                                company: w.company ?? '',
                                remarks: w.remarks ?? ''
                            })) : []);

                            const workTbody = getWorkTbody();
                            if (workTbody) workTbody.innerHTML = '';
                            newAthleteData.workHistory.forEach((w, idx) => {
                                const tr = document.createElement('tr');
                                tr.className = 'bg-white';
                                tr.innerHTML = `
                                    <td class="border px-4 py-2">${w.year}</td>
                                    <td class="border px-4 py-2">${w.date}</td>
                                    <td class="border px-4 py-2">${w.position}</td>
                                    <td class="border px-4 py-2">${w.company}</td>
                                    <td class="border px-4 py-2">${w.remarks}</td>
                                `;
                                if (workTbody) workTbody.appendChild(tr);
                            });

                            // show update button state
                            if (saveBtn) saveBtn.classList.add('hidden');
                            if (updateBtn) updateBtn.classList.remove('hidden');
                        })
                        .catch(err => {
                            console.error('Failed to load athlete details', err);
                        });

                    clearResults();
                });
                resultsBox.appendChild(div);
            });
            resultsBox.classList.remove('hidden');
        }

        function doSearch(qv) {
            if (!qv || qv.trim().length < 1) { clearResults(); return; }
            fetch(searchUrl + '?q=' + encodeURIComponent(qv), { headers: { 'Accept': 'application/json' } })
                .then(r => r.json())
                .then(data => renderResults(data))
                .catch(() => clearResults());
        }

        searchInput.addEventListener('input', (e) => {
            const v = e.target.value;
            if (timer) clearTimeout(timer);

            if (!v || v.trim() === '') {
                if (selectedFromSearch) clearSelection();
                clearResults();
                return;
            }

            timer = setTimeout(() => doSearch(v), 300);
        });
    })();

    // -----------------------
    // ACHIEVEMENTS
    // -----------------------
    (function achievementsModule(){
        const form = byId('achievementForm');
        const tbody = getAchievementsTbody();
        let count = 0;

        window.toggleAchievementModal = function(show) {
            const modal = byId('AchievementModal');
            if (!modal) return;
            modal.classList.toggle('hidden', !show);
        };

        if (!form || !tbody) return;

        form.addEventListener('submit', function(e){
            e.preventDefault();
            const year = (byId('year') || {}).value || '';
            const monthDay = (byId('month_day') || {}).value || '';
            const eventName = (byId('event') || {}).value || '';
            const venue = (byId('venue') || {}).value || '';
            const award = (byId('award') || {}).value || '';
            const category = (byId('category') || {}).value || '';
            const remarks = (byId('remarks') || {}).value || '';

            if (!year || !monthDay || !eventName || !venue || !award) {
                alert('Please fill in all required fields.');
                return;
            }

            const record = { year, monthDay, event: eventName, venue, award, category, remarks };
            newAthleteData.achievements.push(record);

            // add row
            count++;
            const tr = document.createElement('tr');
            tr.className = count % 2 === 0 ? 'bg-gray-50' : 'bg-white';
            tr.innerHTML = `
                <td class="px-6 py-3">${year}</td>
                <td class="px-6 py-3">${monthDay}</td>
                <td class="px-6 py-3">${eventName}</td>
                <td class="px-6 py-3">${venue}</td>
                <td class="px-6 py-3 text-green-700 font-bold">${award}</td>
                <td class="px-6 py-3">${category}</td>
                <td class="px-6 py-3">${remarks}</td>
            `;
            tbody.appendChild(tr);

            form.reset();
            toggleAchievementModal(false);
        });
    })();

    // -----------------------
    // ACADEMIC RECORDS
    // -----------------------
    (function academicModule(){
        const form = byId('academicForm');
        const tbody = getGradesTbody();
        let count = 0;

        window.toggleAcademicModal = function(show) {
            const modal = byId('academicModal');
            if (!modal) return;
            modal.classList.toggle('hidden', !show);
        };

        if (!form || !tbody) return;

        form.addEventListener('submit', function(e){
            e.preventDefault();
            const passed = form.querySelector('input[name="Passed"]').value || '';
            const enrolled = form.querySelector('input[name="enrolled"]').value || '';
            const percentage = form.querySelector('input[name="percentage"]').value || '';
            const remark = form.querySelector('select[name="remark"]').value || '';

            if (!passed || !enrolled || !percentage || !remark) {
                alert('Please fill all required fields.');
                return;
            }

            const rec = { passed, enrolled, percentage, remark };
            newAthleteData.academicRecords.push(rec);

            count++;
            const tr = document.createElement('tr');
            tr.className = count % 2 === 0 ? 'bg-gray-50' : 'bg-white';
            tr.innerHTML = `
                <td class="px-6 py-3 text-center">${passed}</td>
                <td class="px-6 py-3 text-center">${enrolled}</td>
                <td class="px-6 py-3 text-center">${percentage}</td>
                <td class="px-6 py-3 text-center">${remark}</td>
            `;
            tbody.appendChild(tr);

            form.reset();
            toggleAcademicModal(false);
        });
    })();

    // -----------------------
    // FEES & DISCOUNTS
    // -----------------------
    (function feesModule(){
        const form = byId('feeForm');
        const tbody = getFeesTbody();
        let count = 0;

        window.toggleFeeModal = function(show) {
            const modal = byId('feeModal');
            if (!modal) return;
            modal.classList.toggle('hidden', !show);
        };

        if (!form || !tbody) return;

        form.addEventListener('submit', function(e){
            e.preventDefault();

            const academic_year = (form.querySelector('[name="academic_year"]') || {}).value || '';
            const total_units = (form.querySelector('[name="total_units"]') || {}).value || '';
            const tuition_fee = (form.querySelector('[name="tuition_fee"]') || {}).value || '';
            const miscellaneous_fee = (form.querySelector('[name="miscellaneous_fee"]') || {}).value || '';
            const other_charges = (form.querySelector('[name="other_charges"]') || {}).value || '';
            const total_assessment = (form.querySelector('[name="total_assessment"]') || {}).value || '';
            const total_discount = (form.querySelector('[name="total_discount"]') || {}).value || '';
            const remarks = (form.querySelector('[name="remarks"]') || {}).value || '';

            if (!academic_year) {
                alert('Please fill in Academic Year.');
                return;
            }

            const rec = { academic_year, total_units, tuition_fee, miscellaneous_fee, other_charges, total_assessment, total_discount, remarks };
            newAthleteData.fees.push(rec);

            count++;
            const tr = document.createElement('tr');
            tr.className = count % 2 === 0 ? 'bg-gray-50 text-center' : 'bg-white text-center';
            tr.innerHTML = `
                <td class="border px-4 py-2">${academic_year}</td>
                <td class="border px-4 py-2">${total_units}</td>
                <td class="border px-4 py-2">${tuition_fee}</td>
                <td class="border px-4 py-2">${miscellaneous_fee}</td>
                <td class="border px-4 py-2">${other_charges}</td>
                <td class="border px-4 py-2">${total_assessment}</td>
                <td class="border px-4 py-2">${total_discount}</td>
                <td class="border px-4 py-2">${remarks}</td>
            `;
            tbody.appendChild(tr);

            form.reset();
            toggleFeeModal(false);
        });
    })();

    // -----------------------
    // WORK HISTORY
    // -----------------------
    (function workModule(){
        const form = byId('workForm');
        const tbody = getWorkTbody();
        let count = 0;

        window.toggleWorkModal = function(show) {
            const modal = byId('workModal');
            if (!modal) return;
            modal.classList.toggle('hidden', !show);
        };

        if (!form || !tbody) return;

        form.addEventListener('submit', function(e){
            e.preventDefault();

            const year = (form.querySelector('[name="year"]') || {}).value || '';
            const date = (form.querySelector('[name="date"]') || {}).value || '';
            const position = (form.querySelector('[name="position"]') || {}).value || '';
            const company = (form.querySelector('[name="company"]') || {}).value || '';
            const remarks = (form.querySelector('[name="remarks"]') || {}).value || '';

            if (!year || !position) {
                alert('Please fill in Year and Work Position.');
                return;
            }

            const rec = { year, date, position, company, remarks };
            newAthleteData.workHistory.push(rec);

            count++;
            addWorkRow(rec);
            form.reset();
            toggleWorkModal(false);
        });

        function addWorkRow(data) {
            const tr = document.createElement('tr');
            tr.className = 'bg-white';
            tr.innerHTML = `
                <td class="border px-4 py-2">${data.year}</td>
                <td class="border px-4 py-2">${data.date}</td>
                <td class="border px-4 py-2">${data.position}</td>
                <td class="border px-4 py-2">${data.company}</td>
                <td class="border px-4 py-2">${data.remarks}</td>
            `;
            tbody.appendChild(tr);
        }
    })();

    // -----------------------
    // FINAL SAVE (handles both Create and Update)
    // -----------------------
    (function finalSave(){
        const finalSaveBtn = byId('saveFinalBtn') || byId('saveBtn') || byId('submitBtn');
        const submitBtn = finalSaveBtn;
        if (!submitBtn && !updateBtn) return;

        function performFinalSave(e) {
            if (e && e.preventDefault) e.preventDefault();
            // ensure general info is collected
            collectGeneralInfo();

            // decide endpoint and method based on whether an athlete is selected
            const updateBase = '<?php echo e(url('/athletes')); ?>';
            const selectedId = (selectedIdInput && selectedIdInput.value) ? selectedIdInput.value : '';
            const endpoint = selectedId ? (updateBase + '/' + selectedId) : updateBase;
            const method = selectedId ? 'PUT' : 'POST';

            // include selected id in payload generalInfo for clarity
            if (!newAthleteData.generalInfo) newAthleteData.generalInfo = {};
            if (selectedId) newAthleteData.generalInfo.selected_athlete_id = selectedId;

            fetch(endpoint, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(newAthleteData)
            })
            .then(async r => {
                const text = await r.text();
                let data = null;
                try { data = JSON.parse(text); } catch (e) { /* ignore parse error */ }
                if (!r.ok) {
                    console.error('Server error', r.status, data || text);
                    if (r.status === 422 && data && data.errors) {
                        alert('Validation error: ' + JSON.stringify(data.errors));
                        return;
                    }
                    throw new Error('Server returned ' + r.status);
                }
                return data;
            })
            .then(data => {
                alert('Athlete saved successfully.');
                location.reload();
            })
            .catch(err => {
                console.error('Save error:', err);
                alert('Failed to save athlete. Check console for details.');
            });
        }

        if (submitBtn) submitBtn.addEventListener('click', performFinalSave);
        if (updateBtn) updateBtn.addEventListener('click', performFinalSave);
    })();

}); // DOMContentLoaded end
</script>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\caps\athletix\AthleteX\resources\views/features/student_athlete.blade.php ENDPATH**/ ?>