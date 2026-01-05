@extends('layouts.app')

@section('title', 'Athlete Lists')

@section('content')

<div class="space-y-6">

    <div class="flex items-center justify-between px-4">
        <a href="{{ route('student.athlete') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
            Back
        </a>

        <h1 class="text-2xl font-bold text-gray-800 mx-auto">Student Athletes List</h1>
    </div>

    <div class="bg-white p-2 rounded-lg shadow space-y-2">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-2">
            <input type="text" placeholder="Search name, ID…" 
                class="border rounded px-2 py-1 text-sm w-full">

            <select class="border rounded px-2 py-1 text-sm w-full">
                <option value="">All Sports</option>
                </select>

            <select class="border rounded px-2 py-1 text-sm w-full">
                <option value="">Status</option>
                <option>Active</option>
                <option>Injured</option>
                <option>Inactive</option>
            </select>

            <select class="border rounded px-2 py-1 text-sm w-full">
                <option value="">Classification</option>
                <option>Varsity</option>
                <option>Trainee</option>
                <option>Reserve</option>
            </select>
        </div>
    </div>


    <div class="bg-white rounded-xl shadow overflow-auto">
        
        <table class="w-full table-auto text-sm whitespace-nowrap">
            <thead class="bg-gray-100 text-gray-700 top-0">
                <tr>
                    <th class="px-4 py-3 border">S No</th>
                    <th class="px-4 py-3 border">Last Name</th>
                    <th class="px-4 py-3 border">First Name, MI</th>
                    <th class="px-4 py-3 border">Stud ID</th>
                    <th class="px-4 py-3 border">Sports Event</th>
                    <th class="px-4 py-3 border">Status</th>
                    <th class="px-4 py-3 border">Approval</th>
                    <th class="px-4 py-3 border">Classification</th>
                    <th class="px-4 py-3 border">Gender</th>
                    <th class="px-4 py-3 border">Birthdate</th>
                    <th class="px-4 py-3 border">Age</th>
                    <th class="px-4 py-3 border">Blood Type</th>
                    <th class="px-4 py-3 border">Course</th>
                    <th class="px-4 py-3 border">Year / Level</th>
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
                    <th class="px-4 py-3 border text-center sticky right-0 bg-gray-100 z-10">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($athletes as $index => $athlete)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2 text-center">{{ $index + 1 }}</td>
                        <td class="border px-4 py-2 font-semibold">{{ $athlete->last_name }}</td>
                        <td class="border px-4 py-2">{{ $athlete->first_name }} {{ $athlete->middle_initial }}</td>
                        <td class="border px-4 py-2">{{ $athlete->student_id }}</td>
                        <td class="border px-4 py-2">{{ $athlete->sport }}</td> <td class="border px-4 py-2 text-center">
                            <span class="px-2 py-1 rounded text-white text-xs font-bold {{ $athlete->status == 'Active' ? 'bg-green-500' : 'bg-gray-500' }}">
                                {{ $athlete->status }}
                            </span>
                        </td>
                        <td class="border px-4 py-2 text-center">
                            <span class="px-2 py-1 rounded text-white text-xs font-semibold
                                {{ $athlete->approval_status == 'approved' ? 'bg-blue-500' : ($athlete->approval_status == 'pending' ? 'bg-yellow-500' : 'bg-red-500') }}">
                                {{ ucfirst($athlete->approval_status) }}
                            </span>
                        </td>
                        <td class="border px-4 py-2">{{ $athlete->classification }}</td>
                        <td class="border px-4 py-2">{{ $athlete->sex }}</td> <td class="border px-4 py-2">{{ $athlete->birthdate }}</td>
                        <td class="border px-4 py-2 text-center">{{ $athlete->age }}</td>
                        <td class="border px-4 py-2 text-center">{{ $athlete->blood_type }}</td>
                        <td class="border px-4 py-2">{{ $athlete->course }}</td>
                        <td class="border px-4 py-2 text-center">{{ $athlete->year_level }}</td> <td class="border px-4 py-2">{{ $athlete->email }}</td>
                        <td class="border px-4 py-2">{{ $athlete->facebook }}</td> <td class="border px-4 py-2">{{ $athlete->civil_status }}</td> <td class="border px-4 py-2">{{ $athlete->contact_number}}</td>
                        <td class="border px-4 py-2">{{ $athlete->address }}</td>
                        <td class="border px-4 py-2">{{ $athlete->city_municipality }}</td> <td class="border px-4 py-2">{{ $athlete->province }}</td>
                        <td class="border px-4 py-2">{{ $athlete->zip_code }}</td>
                        <td class="border px-4 py-2">{{ $athlete->emergency_person }}</td> <td class="border px-4 py-2">{{ $athlete->emergency_contact }}</td> <td class="border px-4 py-2">{{ $athlete->coach_name ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $athlete->date_joined ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $athlete->term_graduated ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $athlete->asst_coach ?? '-' }}</td>
                        <td class="border px-4 py-2 text-center">{{ $athlete->units_enrolled ?? '-' }}</td>
                        <td class="border px-4 py-2 text-center">{{ $athlete->year_graduated ?? '-' }}</td>
                        <td class="border px-4 py-2 text-right">{{ $athlete->tuition_fee ?? '-' }}</td>
                        <td class="border px-4 py-2 text-right">{{ $athlete->misc_fee ?? '-' }}</td>
                        <td class="border px-4 py-2 text-right">{{ $athlete->other_charges ?? '-' }}</td>
                        
                        <td class="border px-4 py-2 text-center sticky right-0 bg-white z-10 shadow-l">
                            <a href="{{ route('athletes.show', $athlete->id) }}" 
                               class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-xs font-medium transition duration-150 ease-in-out">
                                View
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>

@endsection