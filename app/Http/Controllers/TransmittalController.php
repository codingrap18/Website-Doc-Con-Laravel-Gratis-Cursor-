<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransmittalLetter;
use App\Models\Document;
use Barryvdh\DomPDF\Facade\Pdf;

class TransmittalController extends Controller
{
    /**
     * Display a listing of transmittal letters.
     */
    public function index()
    {
        $transmittals = TransmittalLetter::with('creator')
            ->orderBy('date', 'desc')
            ->paginate(15);

        return view('transmittals.index', compact('transmittals'));
    }

    /**
     * Show the form for creating a new transmittal letter.
     */
    public function create()
    {
        $documents = Document::all();
        $transmittalNumber = TransmittalLetter::generateTransmittalNumber();

        return view('transmittals.create', compact('documents', 'transmittalNumber'));
    }

    /**
     * Store a newly created transmittal letter.
     */
    public function store(Request $request)
    {
        $request->validate([
            'transmittal_number' => 'required|string|unique:transmittal_letters',
            'date' => 'required|date',
            'vendor_name' => 'required|string|max:255',
            'description' => 'required|string',
            'document_ids' => 'required|array|min:1',
            'document_ids.*' => 'exists:documents,id',
        ]);

        $transmittal = TransmittalLetter::create([
            'transmittal_number' => $request->transmittal_number,
            'date' => $request->date,
            'vendor_name' => $request->vendor_name,
            'description' => $request->description,
            'document_ids' => $request->document_ids,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('transmittals.index')
            ->with('success', 'Transmittal letter created successfully.');
    }

    /**
     * Display the specified transmittal letter.
     */
    public function show(TransmittalLetter $transmittal)
    {
        $transmittal->load('creator');
        $documents = $transmittal->documents()->get();

        return view('transmittals.show', compact('transmittal', 'documents'));
    }

    /**
     * Generate PDF for transmittal letter.
     */
    public function generatePdf(TransmittalLetter $transmittal)
    {
        $transmittal->load('creator');
        $documents = $transmittal->documents()->get();

        $pdf = PDF::loadView('transmittals.pdf', compact('transmittal', 'documents'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('transmittal-' . $transmittal->transmittal_number . '.pdf');
    }

    /**
     * Download PDF for transmittal letter.
     */
    public function downloadPdf(TransmittalLetter $transmittal)
    {
        $transmittal->load('creator');
        $documents = $transmittal->documents()->get();

        $pdf = PDF::loadView('transmittals.pdf', compact('transmittal', 'documents'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('transmittal-' . $transmittal->transmittal_number . '.pdf');
    }

    /**
     * Remove the specified transmittal letter.
     */
    public function destroy(TransmittalLetter $transmittal)
    {
        $transmittal->delete();

        return redirect()->route('transmittals.index')
            ->with('success', 'Transmittal letter deleted successfully.');
    }
}
