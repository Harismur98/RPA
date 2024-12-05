<?php

namespace App\Http\Controllers;
use App\Models\FileImg;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class FileimgController extends Controller
{
    public function download($id)
    {
        $file = Fileimg::findOrFail($id); // Retrieve the file record.

        if (Storage::disk('public')->exists($file->file_path)) {
            return response()->download(
                Storage::disk('public')->path($file->file_path), // Path to the file.
                $file->original_name // Use the original name for the download.
            );
        }

        return abort(404, 'File not found.');
    }
}
