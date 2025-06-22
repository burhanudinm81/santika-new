<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrivateFileController extends Controller
{
    public function serveBlokDiagramSistem($id)
    {
        $proposal = Proposal::findOrFail($id);

        if (!$proposal->blok_diagram_sistem) {
            abort(404, 'Blok diagram sistem tidak ditemukan');
        }

        $filepath = $proposal->blok_diagram_sistem;

        if (!Storage::disk('local')->exists($filepath)) {
            abort(404, 'Blok diagram sistem tidak ditemukan');
        }

        $file = Storage::disk('local')->get($filepath);
        $mimeType = Storage::disk('local')->mimeType($filepath);

        return response($file, 200, [
            'Content-Type' => $mimeType,
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }
}
