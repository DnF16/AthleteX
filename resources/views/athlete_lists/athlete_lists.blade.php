@extends('layouts.app')

@section('title', 'Athlete Master List')

@section('content')

<div class="space-y-6">

    <div class="flex items-center justify-between px-4">
        <a href="{{ route('student.athlete') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition shadow">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
        <h1 class="text-2xl font-bold text-gray-800 mx-auto">Student Athletes Master List</h1>
    </div>

    <form method="GET" action="{{ url()->current() }}" class="bg-white p-4 rounded-lg shadow space-y-4 border-t-4 border-green-600">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
            
            <div class="flex">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, ID…" 
                    class="border border-gray-300 rounded-l px-3 py-2 text-sm w-full focus:outline-none focus:border-green-500">
                <button type="submit" class="bg-green-600 text-white px-3 py-2 rounded-r hover:bg-green-700 transition">
                    <i class="fas fa-search"></i>
                </button>
            </div>

            <select name="sport" onchange="this.form.submit()" class="border border-gray-300 rounded px-2 py-2 text-sm w-full focus:outline-none focus:border-green-500 bg-white">
                <option value="">All Sports</option>
                <option value="Basketball_Men" {{ request('sport') == 'Basketball_Men' ? 'selected' : '' }}>Basketball (Men)</option>
                <option value="Basketball_Women" {{ request('sport') == 'Basketball_Women' ? 'selected' : '' }}>Basketball (Women)</option>
                <option value="Volleyball_Men" {{ request('sport') == 'Volleyball_Men' ? 'selected' : '' }}>Volleyball (Men)</option>
                <option value="Volleyball_Women" {{ request('sport') == 'Volleyball_Women' ? 'selected' : '' }}>Volleyball (Women)</option>
                <option value="Football" {{ request('sport') == 'Football' ? 'selected' : '' }}>Football</option>
                <option value="Badminton_Men" {{ request('sport') == 'Badminton_Men' ? 'selected' : '' }}>Badminton (Men)</option>
            </select>

            <select name="status" onchange="this.form.submit()" class="border border-gray-300 rounded px-2 py-2 text-sm w-full focus:outline-none focus:border-green-500 bg-white">
                <option value="">All Statuses</option>
                <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="Transferred" {{ request('status') == 'Transferred' ? 'selected' : '' }}>Transferred</option>
                <option value="Injured" {{ request('status') == 'Injured' ? 'selected' : '' }}>Injured</option>
                <option value="Tryout" {{ request('status') == 'Tryout' ? 'selected' : '' }}>Tryout Applicant</option>
                <option value="Alumni" {{ request('status') == 'Alumni' ? 'selected' : '' }}>Alumni / Graduate</option>
            </select>

            <a href="{{ url()->current() }}" class="text-center border border-gray-300 bg-gray-50 text-gray-700 px-4 py-2 rounded hover:bg-gray-200 transition text-sm flex items-center justify-center font-semibold">
                <i class="fas fa-times me-2"></i> Clear Filters
            </a>
        </div>
    </form>

    <div class="bg-white rounded-xl shadow overflow-auto">
        <table class="w-full table-auto text-sm">
            <thead class="bg-green-50 text-green-800 border-b-2 border-green-200">
                <tr>
                    <th class="px-4 py-3 text-left">S No</th>
                    <th class="px-4 py-3 text-left">Name (Last, First, MI)</th>
                    <th class="px-4 py-3 text-left">Stud ID</th>
                    <th class="px-4 py-3 text-center">Sports Event</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-center">Course & Year</th>
                    <th class="px-4 py-3 text-left">Contact Info</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($athletes as $index => $athlete)
                    <tr class="hover:bg-gray-50 border-b border-gray-100">
                        <td class="px-4 py-3 text-center text-gray-500">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 font-bold text-gray-800 uppercase">{{ $athlete->last_name }}, {{ $athlete->first_name }} {{ $athlete->middle_initial }}</td>
                        <td class="px-4 py-3 text-gray-600 font-mono">{{ $athlete->student_id ?? 'N/A' }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs whitespace-nowrap font-semibold">
                                {{ str_replace('_', ' ', $athlete->sport_event) }}
                            </span>
                        </td>
                        
                        <td class="px-4 py-3 text-center">
                            @if($athlete->status == 'Active')
                                <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs shadow-sm"><i class="fas fa-check-circle me-1"></i> Active</span>
                            @elseif($athlete->status == 'Injured')
                                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs shadow-sm"><i class="fas fa-briefcase-medical me-1"></i> Injured</span>
                            @elseif($athlete->status == 'Inactive')
                                <span class="bg-gray-500 text-white px-3 py-1 rounded-full text-xs shadow-sm">Inactive</span>
                            @elseif($athlete->status == 'Transferred')
                                <span class="bg-orange-500 text-white px-3 py-1 rounded-full text-xs shadow-sm"><i class="fas fa-exchange-alt me-1"></i> Transferred</span>
                            @elseif($athlete->status == 'Alumni')
                                <span class="bg-indigo-600 text-white px-3 py-1 rounded-full text-xs shadow-sm"><i class="fas fa-graduation-cap me-1"></i> Alumni</span>
                            @elseif($athlete->status == 'Tryout')
                                <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-xs shadow-sm"><i class="fas fa-running me-1"></i> Tryout</span>
                            @else
                                <span class="bg-gray-400 text-white px-3 py-1 rounded-full text-xs">{{ $athlete->status ?? 'Unknown' }}</span>
                            @endif
                        </td>
                        
                        <td class="px-4 py-3 text-center text-gray-600">
                            {{ $athlete->course ?? 'N/A' }} 
                            @if($athlete->status !== 'Alumni' && $athlete->year_level)
                                - Yr {{ $athlete->year_level }}
                            @endif
                        </td>
                        
                        <td class="px-4 py-3 text-gray-600 text-xs">
                            <div class="flex flex-col gap-1">
                                <span><i class="fas fa-envelope text-gray-400 w-4"></i> {{ $athlete->email }}</span>
                                @if($athlete->contact_number)
                                    <span><i class="fas fa-phone text-gray-400 w-4"></i> {{ $athlete->contact_number }}</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-16 text-gray-400">
                            <i class="fas fa-users-slash text-5xl mb-3 text-gray-300"></i>
                            <p class="text-lg">No athletes found matching your filters.</p>
                            <a href="{{ url()->current() }}" class="text-green-600 hover:underline mt-2 inline-block">Clear filters and try again</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection