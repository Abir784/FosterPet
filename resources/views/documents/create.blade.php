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

                        <div>
                            <select name="RequestID" id="">
                                @foreach ($request as $req )
                                <option value="{{$req->id}}">{{$req->pet->name}}</option>

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
