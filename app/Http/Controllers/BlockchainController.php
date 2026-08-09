<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlockchainLog;
use App\Services\BlockchainService;

class BlockchainController extends Controller
{
    public function index()
    {
        // 1. Run the math engine to check if the chain is broken
        $verification = BlockchainService::verifyChain();
        
        // 2. Grab all the blocks to display in the table (newest at the top)
        $logs = BlockchainLog::with('user')->orderBy('id', 'desc')->get();
        
        // 3. Send the data to the dashboard view
        return view('features.blockchain_dashboard', [
            'isSecure' => $verification['is_secure'],
            'tamperedBlocks' => $verification['tampered_blocks'],
            'logs' => $logs,
            'totalBlocks' => $logs->count()
        ]);
    }
}