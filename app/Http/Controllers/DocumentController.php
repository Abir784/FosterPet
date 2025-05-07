<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\AdoptionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::all();
        return view('documents.index', compact('documents'));
    }

    public function create()
    {
        $requests=AdoptionRequest::where('adopterID',Auth::id())->get();

        return view('documents.create',
    [
        'requests'=>$requests,
    ]);

    }

    public function store(Request $request)
    {
        $request->validate([
            'RequestID' => 'required|string',
            'document' => 'required|file|mimes:pdf,doc,docx|max:10240'
        ]);

        $file = $request->file('document');
        $extension = $file->getClientOriginalExtension();
        $timestamp = now()->format('Y-m-d-H-i-s');
        $filename = $request->RequestID . '-' . $timestamp . '.' . $extension;

        // Store the file in the public/documents directory
        $path = $file->storeAs('documents', $filename, 'public');
        print_r($path);
        die();

        Document::create([
            'RequestID' => $request->RequestID,
            'file_path' => $path
        ]);

        return redirect()->route('documents.index')
            ->with('success', 'Document uploaded successfully');
    }

    public function show(Document $document)
    {
        return view('documents.show', compact('document'));
    }

    public function destroy(Document $document)
    {
        Storage::disk('public')->delete($document->file_path);
        $document->delete();

        return redirect()->route('documents.index')
            ->with('success', 'Document deleted successfully');
    }
}
