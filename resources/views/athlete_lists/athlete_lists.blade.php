@extends('layouts.app')

@section('title', 'Athlete Lists')

@section('content')

<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex items-center justify-between px-4">
        <a href="{{ route('student.athlete') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
            back
        </a>

        <h1 class="text-2xl font-bold text-gray-800 mx-auto">Student Athletes Lists</h1>
    </div>

    <!-- Filters -->
<div class="bg-white p-2 rounded-lg shadow space-y-2">

    <div class="md:grid-cols-4 gap-2">
        <!-- Search Input -->
        <input type="text" placeholder="Search name, ID…" 
            class="border rounded px-2 py-1 text-sm w-full max-w-xs">

        <!-- Sports Select -->
        <select class="border rounded px-2 py-1 text-sm w-full max-w-xs">
            <option value="">All Sports</option>
            <!-- loop sports -->
        </select>

        <!-- Status Select -->
        <select class="border rounded px-2 py-1 text-sm w-full max-w-xs">
            <option value="">Status</option>
            <option>Active</option>
            <option>Injured</option>
            <option>Inactive</option>
        </select>

        <!-- Classification Select -->
        <select class="border rounded px-2 py-1 text-sm w-full max-w-xs">
            <option value="">Classification</option>
            <option>Varsity</option>
            <option>Trainee</option>
            <option>Reserve</option>
        </select>
    </div>
</div>


    <!-- Table Container -->
    <div class="bg-white rounded-xl shadow overflow-auto">
        
        <table class="w-full table-auto text-sm">
            <thead class="bg-gray-100 text-gray-700 top-0">
                <tr>
                    <th class="px-4 py-3 border">S No</th>
                    <th class="px-4 py-3 border">Last Name</th>
                    <th class="px-4 py-3 border">First Name, MI</th>
                    <th class="px-4 py-3 border">Stud ID</th>
                    <th class="px-4 py-3 border">Sports Event</th>
                    <th class="px-4 py-3 border">Status</th>
                    <th class="px-4 py-3 border">Classification</th>
                    <th class="px-4 py-3 border">Gender</th>
                    <th class="px-4 py-3 border">Birthdate</th>
                    <th class="px-4 py-3 border">Age</th>
                    <th class="px-4 py-3 border">Blood Type</th>
                    <th class="px-4 py-3 border">Course</th>
                    <th class="px-4 py-3 border">Year</th>
                    <th class="px-4 py-3 border">Email</th>
                    <th class="px-4 py-3 border">FB Link</th>
                    <th class="px-4 py-3 border">Marital Status</th>
                    <th class="px-4 py-3 border">Contact #</th>
                    <th class="px-4 py-3 border">Address</th>
                    <th class="px-4 py-3 border">City</th>
                    <th class="px-4 py-3 border">Province</th>
                    <th class="px-4 py-3 border">Zip Code</th>
                    <th class="px-4 py-3 border">Emergency Contact Person</th>
                    <th class="px-4 py-3 border">Emergency #</th>
                    <th class="px-4 py-3 border">Coach Name</th>
                    <th class="px-4 py-3 border">Date Joined</th>
                    <th class="px-4 py-3 border">Term Graduated</th>
                    <th class="px-4 py-3 border">Asst Coach</th>
                    <th class="px-4 py-3 border">Units Enrolled</th>
                    <th class="px-4 py-3 border">Year Graduated</th>
                    <th class="px-4 py-3 border">Tuition Fee</th>
                    <th class="px-4 py-3 border">Misc Fee</th>
                    <th class="px-4 py-3 border">Other Charges</th>
                    <th class="px-4 py-3 border">Total Assessment</th>
                    <th class="px-4 py-3 border">Total Discount</th>
                    <th class="px-4 py-3 border">Balance</th>
                    <th class="px-4 py-3 border">Current Work</th>
                    <th class="px-4 py-3 border">Company</th>
                    <th class="px-4 py-3 border">Picture</th>
                    <th class="px-4 py-3 border">Notes</th>
                    <th class="px-4 py-3 border">Inactive Date</th>
                    <th class="px-4 py-3 border">Full Name</th>
                    <!-- <th class="px-4 py-3 border">Actions</th> -->
                </tr>
            </thead>

            <tbody>
                @foreach ($athletes as $index => $athlete)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2 text-center">{{ $index + 1 }}</td>
                        <td class="border px-4 py-2">{{ $athlete->last_name }}</td>
                        <td class="border px-4 py-2">{{ $athlete->first_name }} {{ $athlete->middle_initial }}</td>
                        <td class="border px-4 py-2">{{ $athlete->student_id }}</td>
                        <td class="border px-4 py-2">{{ $athlete->sport_event }}</td>
                        <td class="border px-4 py-2">
                            <span class="px-2 py-1 rounded text-white {{ $athlete->status == 'Active' ? 'bg-green-600' : 'bg-gray-500' }} text-xs">
                                {{ $athlete->status }}
                            </span>
                        </td>
                        <td class="border px-4 py-2">{{ $athlete->classification }}</td>
                        <td class="border px-4 py-2">{{ $athlete->gender }}</td>
                        <td class="border px-4 py-2">{{ $athlete->birthdate }}</td>
                        <td class="border px-4 py-2 text-center">{{ $athlete->age }}</td>
                        <!-- Add the rest of the columns similarly -->
                        <!-- <td class="border px-4 py-2 text-center">
                            <button class="px-2 py-1 bg-blue-600 text-white rounded text-xs">View</button>
                            <button class="px-2 py-1 bg-yellow-500 text-white rounded text-xs">Edit</button>
                            <button class="px-2 py-1 bg-red-600 text-white rounded text-xs">Delete</button>
                        </td> -->
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>


@endsection