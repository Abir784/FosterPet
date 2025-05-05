<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        </h2>
    </x-slot>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Documents</h2>
        <a href="{{ route('documents.create') }}" class="btn btn-primary">Upload New Document</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Document Name</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Uploaded Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($documents as $document)
                            <tr>
                                <td>{{ $document->document_name }}</td>
                                <td>{{ $document->document_type ?? 'N/A' }}</td>
                                <td>{{ $document->description ?? 'N/A' }}</td>
                                <td>{{ $document->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ asset('storage/' . $document->file_path) }}" class="btn btn-sm btn-info" target="_blank">View</a>
                                    <form action="{{ route('documents.destroy', $document) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
