@extends('layouts.app')

@section('title', 'Athlete Lists')

@section('content')

<div class="space-y-6">

    <div class="flex items-center justify-between px-4">
        <a href="{{ route('student.athlete') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
        <h1 class="text-2xl font-bold text-gray-800 mx-auto">Student Athletes List</h1>
    </div>

    {{-- Filter Section --}}
    <div class="bg-white p-4 rounded-lg shadow-sm border space-y-2">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
            <input type="text" placeholder="Search name, ID…" 
                class="border border-gray-300 rounded px-3 py-2 text-sm w-full focus:ring-2 focus:ring-green-500 outline-none">

            <select class="border border-gray-300 rounded px-3 py-2 text-sm w-full">
                <option value="">All Sports</option>
                {{-- Add dynamic sports list here later --}}
            </select>

            <select class="border border-gray-300 rounded px-3 py-2 text-sm w-full">
                <option value="">Status</option>
                <option>Active</option>
                <option>Injured</option>
                <option>Inactive</option>
            </select>

            <select class="border border-gray-300 rounded px-3 py-2 text-sm w-full">
                <option value="">Classification</option>
                <option>Varsity</option>
                <option>Trainee</option>
                <option>Reserve</option>
            </select>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden border">
        <div class="overflow-x-auto">
            <table class="w-full table-auto text-sm whitespace-nowrap">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-3 border-b text-center">S No</th>
                        <th class="px-4 py-3 border-b text-left">Last Name</th>
                        <th class="px-4 py-3 border-b text-left">First Name, MI</th>
                        <th class="px-4 py-3 border-b text-left">Stud ID</th>
                        <th class="px-4 py-3 border-b text-left">Sports Event</th>
                        <th class="px-4 py-3 border-b text-center">Status</th>
                        <th class="px-4 py-3 border-b text-center">Approval</th>
                        <th class="px-4 py-3 border-b text-left">Classification</th>
                        <th class="px-4 py-3 border-b text-left">Gender</th>
                        <th class="px-4 py-3 border-b text-left">Birthdate</th>
                        <th class="px-4 py-3 border-b text-center">Age</th>
                        <th class="px-4 py-3 border-b text-center">Blood Type</th>
                        <th class="px-4 py-3 border-b text-left">Course</th>
                        <th class="px-4 py-3 border-b text-center">Year / Level</th>
                        <th class="px-4 py-3 border-b text-left">Email</th>
                        <th class="px-4 py-3 border-b text-left">FB Link</th>
                        <th class="px-4 py-3 border-b text-left">Marital Status</th>
                        <th class="px-4 py-3 border-b text-left">Contact #</th>
                        <th class="px-4 py-3 border-b text-left">Address</th>
                        <th class="px-4 py-3 border-b text-left">City</th>
                        <th class="px-4 py-3 border-b text-left">Province</th>
                        <th class="px-4 py-3 border-b text-left">Zip Code</th>
                        <th class="px-4 py-3 border-b text-left">Emergency Contact</th>
                        <th class="px-4 py-3 border-b text-left">Emergency #</th>
                        <th class="px-4 py-3 border-b text-left text-center sticky right-0 bg-gray-100 z-10 shadow-l">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @foreach ($athletes as $index => $athlete)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-center text-gray-500">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 font-semibold text-gray-900">{{ $athlete->last_name }}</td>
                            <td class="px-4 py-3">{{ $athlete->first_name }} {{ substr($athlete->middle_name, 0, 1) }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $athlete->student_id }}</td>
                            <td class="px-4 py-3">{{ str_replace('_', ' ', $athlete->sport_event) }}</td> 
                            <td class="px-4 py-3 text-center">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $athlete->status == 'Active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $athlete->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $athlete->approval_status == 'approved' ? 'bg-blue-100 text-blue-800' : ($athlete->approval_status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($athlete->approval_status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">{{ $athlete->classification }}</td>
                            
                            {{-- FIX: Using 'gender' instead of 'sex' --}}
                            <td class="px-4 py-3">{{ $athlete->gender }}</td> 
                            
                            <td class="px-4 py-3">{{ $athlete->birthdate ? $athlete->birthdate->format('M d, Y') : '-' }}</td>
                            <td class="px-4 py-3 text-center">{{ $athlete->age }}</td>
                            <td class="px-4 py-3 text-center">{{ $athlete->blood_type }}</td>
                            <td class="px-4 py-3">{{ $athlete->course }}</td>
                            <td class="px-4 py-3 text-center">{{ $athlete->year_level }}</td> 
                            <td class="px-4 py-3">{{ $athlete->email }}</td>
                            <td class="px-4 py-3"><a href="{{ $athlete->facebook }}" target="_blank" class="text-blue-600 hover:underline">Link</a></td> 
                            
                            {{-- FIX: Using 'marital_status' instead of 'civil_status' --}}
                            <td class="px-4 py-3">{{ $athlete->marital_status }}</td> 
                            
                            <td class="px-4 py-3">{{ $athlete->contact_number }}</td>
                            <td class="px-4 py-3 truncate max-w-xs">{{ $athlete->address }}</td>
                            <td class="px-4 py-3">{{ $athlete->city_municipality }}</td> 
                            <td class="px-4 py-3">{{ $athlete->province_state }}</td>
                            <td class="px-4 py-3">{{ $athlete->zip_code }}</td>
                            <td class="px-4 py-3">{{ $athlete->emergency_person }}</td> 
                            <td class="px-4 py-3">{{ $athlete->emergency_contact }}</td> 
                            
                            <td class="px-4 py-3 text-center sticky right-0 bg-white z-10 shadow-l">
                                <a href="{{ route('athletes.show', $athlete->id) }}" 
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs transition">
                                    View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection