<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BasisdataAlphabyte;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Exception\ProcessFailedException;

class UpdateDataAlphabyteController extends Controller
{
    public function processPdf($id)
    {
        $document = BasisdataAlphabyte::findOrFail($id);

        try {

            //$output = shell_exec('/Users/indra/Projects/AI/flaskdeploy/venv/bin/python /Users/indra/Projects/AI/flaskdeploy/loadpdfv2.py 2>&1');
            $output = shell_exec('/Users/indra/Projects/AI/flaskdeploy/venv/bin/python /Users/indra/Projects/AI/flaskdeploy/loadpdfv2.py');
            //$output = shell_exec('/home/administrator/flaskdeploy/venv/bin/python /home/administrator/flaskdeploy/loadpdfv2.py ');
            return response()->json(['output' => $output]);

            //dd($output2); // atau return response()->json(['output' => $output]);


            //$pythonPath = config('services.python.path');
            //$scriptPath = env('ALPHABYTE_APP_PATH');
            //$dataPath   = env('ALPHABYTE_DATA');
        
            //$venvActivate = '/Users/indra/Projects/AI/flaskdeploy/venv/bin/activate';
            //$scriptPath = env('ALPHABYTE_APP_PATH'); // path ke processor.py
            //$dataPath = env('ALPHABYTE_DATA');
            //$pythonPath = 'python'; // Biarkan python dari venv yang aktif nanti

            //if (!file_exists($venvActivate)) {
            //    throw new \Exception("Virtual environment tidak ditemukan di: $venvActivate");
            //}

            //$command = "source {$venvActivate} && {$pythonPath} {$scriptPath} {$dataPath} {$id}";
            //$command = "{$pythonPath} {$scriptPath}";

            //$process = Process::fromShellCommandline($command);
            //$process->setTimeout(60);
            //$process->run();

            //if (!$process->isSuccessful()) {
            //    throw new ProcessFailedException($process);
            //}

            //Log::info('Process output: ' . $process->getOutput());

            //return response()->json([
            //    'status' => $command,
            //    'message' => $process->getOutput()
            //]);

            /*
            Log::info('Process output: ' . $process->getOutput());
            $process = new Process([
                $pythonPath,
                $scriptPath,
                $dataPath,
                $id
            ]);
            $process->setTimeout(60);
            $process->run();
            */

            // Cek jika gagal
            /*if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }*/

            // Output jika ingin di-log
            //Log::info('Process output: ' . $process->getOutput());

            /*return response()->json([
                'status' => 'processing',
                'message' => $process->getOutput()
            ]);*/

            
        } catch (\Exception $e) {
            Log::error('PDF Processing Error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
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