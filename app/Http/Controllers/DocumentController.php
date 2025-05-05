<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\AdoptionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::with('adopter')->get();
        return view('documents.index', compact('documents'));
    }

    public function create()
    {
        $requests=AdoptionRequest::where('AdopterID',Auth::id())->get();

        return view('documents.create',
    [
        'requests'=>$request,
    ]);

    }

    public function store(Request $request)
    {
        $request->validate([
            'document_name' => 'required|string|max:255',
            'document' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'document_type' => 'nullable|string|max:255',
            'description' => 'nullable|string'
        ]);

        $file = $request->file('document');
        $path = $file->store('documents', 'public');

        Document::create([
            'adopter_id' => auth()->id(),
            'document_name' => $request->document_name,
            'file_path' => $path,
            'document_type' => $request->document_type,
            'description' => $request->description
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
