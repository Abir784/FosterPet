<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upload Document') }}
        </h2>
    </x-slot>
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Upload Document</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="RequestID" class="block text-sm font-medium text-gray-700 mb-2">Select Pet</label>
                            <select name="RequestID" id="RequestID" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md shadow-sm">
                                <option value="" disabled selected>Choose a pet...</option>
                                @foreach ($requests as $req)
                                    <option value="{{$req->id}}" class="py-2">
                                        {{App\Models\pets::where('id',$req->adoption->pet_id)->get("name")[0]['name']}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="document" class="form-label">Document File</label>
                            <input type="file" class="form-control @error('document') is-invalid @enderror"
                                id="document" name="document" required>
                            @error('document')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="text-muted">Accepted formats: PDF, DOC, DOCX. Max size: 10MB</small>
                        </div>


                        <div class="d-flex justify-content-between">
                            <a href="{{ route('documents.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Upload Document</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
