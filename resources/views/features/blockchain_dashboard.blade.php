@extends('layouts.app')

@section('content')
<!-- Main Container -->
<div class="p-8 relative z-10">
    
    <h1 class="text-3xl font-bold text-[#2e4e1f] mb-6">Data Integrity Ledger</h1>

    <!-- ========================================== -->
    <!-- THE MAIN ALARM BANNER -->
    <!-- ========================================== -->
    @if($isSecure)
        <div class="bg-green-600 text-white p-6 rounded-lg shadow-lg mb-8 flex items-center justify-between transition-all duration-500">
            <div>
                <h2 class="text-2xl font-black mb-1"><i class="bi bi-shield-check mr-2"></i> SYSTEM SECURE</h2>
                <p class="text-green-100">Data Integrity Ledger is Intact. No database tampering detected.</p>
            </div>
            <div class="text-5xl"><i class="bi bi-check-circle-fill"></i></div>
        </div>
    @else
        <div class="bg-red-600 text-white p-6 rounded-lg shadow-lg mb-8 flex items-center justify-between animate-pulse">
            <div>
                <h2 class="text-2xl font-black mb-1"><i class="bi bi-shield-exclamation mr-2"></i> CRITICAL ALERT: DATA TAMPERING DETECTED!</h2>
                <p class="text-red-100">The data integrity ledger is compromised at Block(s): <strong class="text-white">{{ implode(', ', $tamperedBlocks) }}</strong>. Manual database modification detected!</p>
            </div>
            <div class="text-5xl"><i class="bi bi-exclamation-triangle-fill"></i></div>
        </div>
    @endif

    <!-- ========================================== -->
    <!-- THE QUICK STATS SCOREBOARD -->
    <!-- ========================================== -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-[#2e4e1f]">
            <p class="text-gray-500 text-xs font-bold tracking-wider mb-1">TOTAL BLOCKS CHAINED</p>
            <p class="text-4xl font-black text-[#2e4e1f]">{{ $totalBlocks }}</p>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow border-l-4 {{ $isSecure ? 'border-green-500' : 'border-red-600' }}">
            <p class="text-gray-500 text-xs font-bold tracking-wider mb-1">COMPROMISED RECORDS</p>
            <p class="text-4xl font-black {{ $isSecure ? 'text-green-500' : 'text-red-600' }}">{{ count($tamperedBlocks) }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
            <p class="text-gray-500 text-xs font-bold tracking-wider mb-1">LAST VERIFICATION SCAN</p>
            <p class="text-2xl font-bold text-blue-600 mt-2">{{ now()->format('h:i:s A') }}</p>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- THE IMMUTABLE LEDGER TABLE -->
    <!-- ========================================== -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b bg-gray-50 flex justify-between items-center">
            <h3 class="font-bold text-gray-700">Audit Trail History</h3>
            <span class="text-xs text-gray-500">Showing all chained transactions</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse relative z-20">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 text-xs uppercase tracking-wider">
                        <th class="p-4 border-b">Block #</th>
                        <th class="p-4 border-b">Timestamp</th>
                        <th class="p-4 border-b">User</th>
                        <th class="p-4 border-b">Action</th>
                        <th class="p-4 border-b">Current Hash (Signature)</th>
                        <th class="p-4 border-b text-center">Status</th>
                        <th class="p-4 border-b text-center">Details</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @foreach($logs as $log)
                        <tr class="hover:bg-gray-50 border-b">
                            <td class="p-4 font-bold text-gray-700">#{{ $log->id }}</td>
                            <td class="p-4 text-gray-500">{{ $log->created_at->format('M d, Y - h:i A') }}</td>
                            <td class="p-4 font-semibold text-[#2e4e1f]">{{ $log->user ? $log->user->name : 'System/Guest' }}</td>
                            <td class="p-4">{{ $log->action }}</td>
                            <td class="p-4 font-mono text-xs text-gray-400" title="{{ $log->current_hash }}">
                                {{ substr($log->current_hash, 0, 16) }}...
                            </td>
                            <td class="p-4 text-center">
                                @if(in_array($log->id, $tamperedBlocks))
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold border border-red-200"><i class="bi bi-x-circle-fill mr-1"></i>Tampered</span>
                                @else
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold border border-green-200"><i class="bi bi-check-circle-fill mr-1"></i>Valid</span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                <!-- The Trigger Button -->
                                <button type="button" 
                                        class="bg-gray-100 hover:bg-gray-200 border border-gray-300 text-gray-700 font-semibold py-1 px-3 rounded-full text-sm transition view-data-btn"
                                        data-block="{{ $log->id }}"
                                        data-action="{{ $log->action }}">
                                    View Data
                                </button>
                                
                                <!-- The Hidden Data Vault (Prevents HTML breakage) -->
                                <textarea id="payload-{{ $log->id }}" class="hidden">{!! $log->payload ?? $log->details ?? $log->data ?? '{}' !!}</textarea>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div> 
<!-- END OF MAIN CONTAINER -->


<!-- ========================================== -->
<!-- BULLETPROOF SECURITY DATA MODAL -->
<!-- ========================================== -->
<!-- Placed OUTSIDE the main container to escape layout traps -->
<div id="dataModal" class="fixed inset-0 hidden items-center justify-center p-4" style="z-index: 9999; background-color: rgba(0, 0, 0, 0.75); backdrop-filter: blur(4px);">
    
    <!-- Modal Window (HARDCODED COMPACT SIZE!) -->
    <div class="bg-white rounded-xl shadow-2xl border border-gray-200 flex flex-col" style="width: 100%; max-width: 650px; max-height: 75vh;">
        
        <!-- Header -->
        <div class="px-6 py-4 border-b flex justify-between items-center bg-gray-50 rounded-t-xl shrink-0">
            <div class="flex items-center gap-2">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                <h3 class="text-lg font-bold text-gray-800" id="modalTitle">Block Details</h3>
            </div>
            <button id="closeModalBtn" class="text-gray-400 hover:text-red-500 transition text-2xl font-bold">&times;</button>
        </div>

        <!-- Body (Scrollable region) -->
        <div class="p-6 overflow-y-auto grow">
            <div class="mb-4">
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Action Recorded</span>
                <p id="modalAction" class="text-md font-medium text-gray-800 mt-1"></p>
            </div>
            
            <div>
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Cryptographic Payload (Raw JSON)</span>
                <!-- Hacker Terminal Theme with Strict Height -->
                <div class="rounded-lg p-4 mt-2 overflow-y-auto shadow-inner border border-gray-700" style="background-color: #111827; max-height: 300px;">
                    <pre><code id="modalPayload" class="text-sm font-mono whitespace-pre-wrap" style="color: #4ade80;"></code></pre>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="px-6 py-4 border-t bg-gray-50 rounded-b-xl flex justify-end shrink-0">
            <button id="closeModalFooterBtn" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-6 rounded-lg transition shadow">Close</button>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- JAVASCRIPT LOGIC -->
<!-- ========================================== -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('dataModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalAction = document.getElementById('modalAction');
    const modalPayload = document.getElementById('modalPayload');
    
    // Function to close the modal
    const closeModal = () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex'); 
    };

    // Attach click events to close buttons
    document.getElementById('closeModalBtn').addEventListener('click', closeModal);
    document.getElementById('closeModalFooterBtn').addEventListener('click', closeModal);

    // Close when clicking outside the modal box
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });

    // Attach click event to all "View Data" buttons
    document.querySelectorAll('.view-data-btn').forEach(button => {
        button.addEventListener('click', function() {
            const blockNumber = this.getAttribute('data-block');
            const action = this.getAttribute('data-action');
            
            // Grab data safely from the hidden textarea
            const rawPayload = document.getElementById('payload-' + blockNumber).value;
            let formattedPayload = '';

            try {
                // If it is JSON, format it perfectly with 4 spaces of indentation
                const parsed = JSON.parse(rawPayload);
                formattedPayload = JSON.stringify(parsed, null, 4);
            } catch (e) {
                // Fallback for regular text
                formattedPayload = rawPayload;
            }

            // Inject data into the modal
            modalTitle.innerText = `Block #${blockNumber} Audit Data`;
            modalAction.innerText = action;
            modalPayload.innerText = formattedPayload;

            // Show modal cleanly
            modal.classList.remove('hidden');
            modal.classList.add('flex'); 
        });
    });
});
</script>

@endsection