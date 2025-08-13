<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranSemhas;
use App\Models\PendaftaranSeminarProposal;
use App\Models\Proposal;
use App\Models\Revisi;
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

    // UNTUK SEMPRO
    public function serveProposalSemproFile($id)
    {
        $pendaftaranSempro = PendaftaranSeminarProposal::findOrFail($id);

        if (!$pendaftaranSempro->file_proposal) {
            abort(404, 'Blok diagram sistem tidak ditemukan');
        }

        $filepath = $pendaftaranSempro->file_proposal;

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

    public function serveLembarKonsulSemproFile($id)
    {
        $pendaftaranSempro = PendaftaranSeminarProposal::findOrFail($id);

        if (!$pendaftaranSempro->lembar_konsultasi) {
            abort(404, 'Blok diagram sistem tidak ditemukan');
        }

        $filepath = $pendaftaranSempro->lembar_konsultasi;

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

    public function serveLembarKerjsamaMitraSemproFile($id)
    {
        $pendaftaranSempro = PendaftaranSeminarProposal::findOrFail($id);

        if (!$pendaftaranSempro->lembar_kerjasama_mitra) {
            abort(404, 'Blok diagram sistem tidak ditemukan');
        }

        $filepath = $pendaftaranSempro->lembar_kerjasama_mitra;

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

    public function serveBuktiCekPlagiasiSemproFile($id)
    {
        $pendaftaranSempro = PendaftaranSeminarProposal::findOrFail($id);

        if (!$pendaftaranSempro->bukti_cek_plagiasi) {
            abort(404, 'Blok diagram sistem tidak ditemukan');
        }

        $filepath = $pendaftaranSempro->bukti_cek_plagiasi;

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

    // UNTUK SEMHAS
    public function serveSuratRekomDospemFile($id)
    {
        $pendaftaranSemhas = PendaftaranSemhas::findOrFail($id);

        if (!$pendaftaranSemhas->file_rekom_dospem) {
            abort(404, 'Blok diagram sistem tidak ditemukan');
        }

        $filepath = $pendaftaranSemhas->file_rekom_dospem;

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

    public function serveProposalSemhasFile($id)
    {
        $pendaftaranSemhas = PendaftaranSemhas::findOrFail($id);

        if (!$pendaftaranSemhas->file_rekom_dospem) {
            abort(404, 'Blok diagram sistem tidak ditemukan');
        }

        $filepath = $pendaftaranSemhas->file_rekom_dospem;

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

    public function serveDraftJurnalFile($id)
    {
        $pendaftaranSemhas = PendaftaranSemhas::findOrFail($id);

        if (!$pendaftaranSemhas->file_draft_jurnal) {
            abort(404, 'Blok diagram sistem tidak ditemukan');
        }

        $filepath = $pendaftaranSemhas->file_draft_jurnal;

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

    public function serveIAMitraFile($id)
    {
        $pendaftaranSemhas = PendaftaranSemhas::findOrFail($id);

        if (!$pendaftaranSemhas->file_IA_mitra) {
            abort(404, 'Blok diagram sistem tidak ditemukan');
        }

        $filepath = $pendaftaranSemhas->file_IA_mitra;

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

    public function serveBebasTanggunganPklFile($id)
    {
        $pendaftaranSemhas = PendaftaranSemhas::findOrFail($id);

        if (!$pendaftaranSemhas->file_bebas_tanggungan_pkl) {
            abort(404, 'Blok diagram sistem tidak ditemukan');
        }

        $filepath = $pendaftaranSemhas->file_bebas_tanggungan_pkl;

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

    public function serveSKLAFile($id)
    {
        $pendaftaranSemhas = PendaftaranSemhas::findOrFail($id);

        if (!$pendaftaranSemhas->file_skla) {
            abort(404, 'Blok diagram sistem tidak ditemukan');
        }

        $filepath = $pendaftaranSemhas->file_skla;

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

    // UNTUK REVISI
    public function serveRevisiProposalSempro($id)
    {
        $revisi = Revisi::where('id', $id)->where('jenis_revisi', 'sempro')->first();

        if (!$revisi->file_proposal_revisi) {
            abort(404, 'Blok file revisi tidak ditemukan');
        }

        $filepath = $revisi->file_proposal_revisi;

        if (!Storage::disk('local')->exists($filepath)) {
            abort(404, 'Blok file revisi  tidak ditemukan');
        }

        $file = Storage::disk('local')->get($filepath);
        $mimeType = Storage::disk('local')->mimeType($filepath);

        return response($file, 200, [
            'Content-Type' => $mimeType,
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }

    public function serveRevisiProposalSemhas($id)
    {
        $revisi = Revisi::where('id', $id)->where('jenis_revisi', 'semhas')->first();

        if (!$revisi->file_proposal_revisi) {
            abort(404, 'Blok file revisi tidak ditemukan');
        }

        $filepath = $revisi->file_proposal_revisi;

        if (!Storage::disk('local')->exists($filepath)) {
            abort(404, 'Blok file revisi  tidak ditemukan');
        }

        $file = Storage::disk('local')->get($filepath);
        $mimeType = Storage::disk('local')->mimeType($filepath);

        return response($file, 200, [
            'Content-Type' => $mimeType,
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }

    public function serveRevisiLembarRevisiSempro($id)
    {
        $revisi = Revisi::where('id', $id)->where('jenis_revisi', 'sempro')->first();

        if (!$revisi->file_lembar_revisi_dosen) {
            abort(404, 'Blok file revisi tidak ditemukan');
        }

        $filepath = $revisi->file_lembar_revisi_dosen;

        if (!Storage::disk('local')->exists($filepath)) {
            abort(404, 'Blok file revisi  tidak ditemukan');
        }

        $file = Storage::disk('local')->get($filepath);
        $mimeType = Storage::disk('local')->mimeType($filepath);

        return response($file, 200, [
            'Content-Type' => $mimeType,
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }

    public function serveRevisiLembarRevisiSemhas($id)
    {
        $revisi = Revisi::where('id', $id)->where('jenis_revisi', 'semhas')->first();

        if (!$revisi->file_lembar_revisi_dosen) {
            abort(404, 'Blok file revisi tidak ditemukan');
        }

        $filepath = $revisi->file_lembar_revisi_dosen;

        if (!Storage::disk('local')->exists($filepath)) {
            abort(404, 'Blok file revisi  tidak ditemukan');
        }

        $file = Storage::disk('local')->get($filepath);
        $mimeType = Storage::disk('local')->mimeType($filepath);

        return response($file, 200, [
            'Content-Type' => $mimeType,
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }

    
}
