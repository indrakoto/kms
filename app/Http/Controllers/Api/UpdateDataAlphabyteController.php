<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BasisdataAlphabyte;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

class UpdateDataAlphabyteController extends Controller
{
    public function processPdf($id)
    {
        $document = BasisdataAlphabyte::findOrFail($id);

        //dd($document);
        
        try {
            /*$process = new Process([
                config('services.python.path'),
                base_path('scripts/loadpdf_qa.py'),
                storage_path('app/'.$document->file_path),
                $id
            ]);
            
            $process->run();*/

            
            return response()->json([
                'status' => 'processing',
                'message' => 'PDF sedang diproses'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function updateStatus($id, Request $request)
    {
        $request->validate([
            'status' => 'required|in:1,2,3'
        ]);
        
        BasisdataAlphabyte::find($id)->update([
            'is_processed' => $request->status
        ]);
        
        return response()->json(['success' => true]);
    }
}