<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function index()
    {
        return view('pages.backup.index');
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT DATABASE
    |--------------------------------------------------------------------------
    */
    public function export()
    {
        $database = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host     = env('DB_HOST', '127.0.0.1');
        $port     = env('DB_PORT', '3306');

        $mysqlDumpPath = "/Users/Shared/DBngin/mysql/8.0.33/bin/mysqldump";
        $fileName = 'backup-' . date('Y-m-d-H-i-s') . '.sql';
        $path = storage_path('app/' . $fileName);

        // Bangun command dalam satu baris (tanpa newline)
        if (!empty($password)) {
            $command = "{$mysqlDumpPath} --host={$host} --port={$port} --user={$username} --password={$password} {$database} > {$path} 2>&1";
        } else {
            $command = "{$mysqlDumpPath} --host={$host} --port={$port} --user={$username} {$database} > {$path} 2>&1";
        }

        exec($command, $output, $returnCode);

        // Cek apakah file berhasil dibuat dan tidak kosong
        if (!file_exists($path)) {
            return back()->with('error', 'Backup gagal: file tidak terbuat. Return code: ' . $returnCode . ' | ' . implode(' ', $output));
        }

        if (filesize($path) === 0) {
            unlink($path);
            return back()->with('error', 'Backup gagal: file kosong. Return code: ' . $returnCode . ' | ' . implode(' ', $output));
        }

        return response()->download($path)->deleteFileAfterSend(true);
    }

    /*
    |--------------------------------------------------------------------------
    | IMPORT DATABASE
    |--------------------------------------------------------------------------
    */
    public function import(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file|mimes:sql,txt'
        ]);

        $database = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host     = env('DB_HOST', '127.0.0.1');
        $port     = env('DB_PORT', '3306');

        $mysqlPath = "/Users/Shared/DBngin/mysql/8.0.33/bin/mysql";

        $file = $request->file('backup_file');
        $path = $file->getRealPath();

        // Bangun command dalam satu baris (tanpa newline)
        if (!empty($password)) {
            $command = "{$mysqlPath} --host={$host} --port={$port} --user={$username} --password={$password} {$database} < {$path} 2>&1";
        } else {
            $command = "{$mysqlPath} --host={$host} --port={$port} --user={$username} {$database} < {$path} 2>&1";
        }

        exec($command, $output, $returnCode);

        if ($returnCode !== 0) {
            return back()->with('error', 'Import gagal: ' . implode(' ', $output));
        }

        return back()->with('success', 'Backup berhasil diimport!');
    }
}