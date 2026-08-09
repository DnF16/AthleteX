<?php

namespace App\Services;

use App\Models\BlockchainLog;
use Illuminate\Support\Facades\Auth;

class BlockchainService
{
    /**
     * This method intercepts an action, hashes it, and chains it to the last block.
     */
    public static function logAction($action, $payloadArray)
    {
        // 1. Get the very last block in the database
        $lastBlock = BlockchainLog::latest('id')->first();
        
        // If there is no previous block, this is the "Genesis" (first) block.
        $previousHash = $lastBlock ? $lastBlock->current_hash : null;

        // 2. Convert the user's data into a JSON string
        $payloadJson = json_encode($payloadArray);

        // 3. Combine everything together to prepare for hashing
        // Even the timestamp is included so the hash is totally unique to this exact second
        $timestamp = now()->toDateTimeString();
        $dataToHash = $action . $payloadJson . $previousHash . $timestamp;

        // 4. GENERATE THE HASH: Run it through the SHA-256 cryptographic algorithm
        $currentHash = hash('sha256', $dataToHash);

        // 5. Save the new chained block permanently to the database
        return BlockchainLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'payload' => $payloadJson,
            'previous_hash' => $previousHash,
            'current_hash' => $currentHash,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);
    }

    /**
     * This method recalculates the entire chain to check for hackers.
     * The Dashboard will use this.
     */
    public static function verifyChain()
    {
        $logs = BlockchainLog::orderBy('id', 'asc')->get();
        $previousHashTracker = null;
        $tamperedBlocks = [];

        foreach ($logs as $log) {
            // 1. RECALCULATE the math to see if a hacker edited the JSON text!
            // We use getRawOriginal to ensure the database timestamp format matches exactly
            $timestamp = $log->getRawOriginal('created_at');
            $dataToHash = $log->action . $log->payload . $log->previous_hash . $timestamp;
            $recalculatedHash = hash('sha256', $dataToHash);

            // 2. The alarm goes off if the Payload was edited OR if the Chain is broken
            if ($recalculatedHash !== $log->current_hash || ($log->id != $logs->first()->id && $log->previous_hash !== $previousHashTracker)) {
                $tamperedBlocks[] = $log->id;
            }
            
            $previousHashTracker = $log->current_hash;
        }

        return [
            'is_secure' => count($tamperedBlocks) === 0,
            'tampered_blocks' => $tamperedBlocks
        ];
    }
}