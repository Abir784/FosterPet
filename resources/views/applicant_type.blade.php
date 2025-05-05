<x-app-layout>
<div class="container mt-4">
    <h2>Applicant Form</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('applicant-types.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="pet_id">Select Pet:</label>
            <select name="pet_id" class="form-control" required>
                @foreach($pets as $pet)
                    <option value="{{ $pet->id }}">{{ $pet->name }} ({{ $pet->breed }})</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="foster_type">Foster Type:</label>
            <select name="foster_type" id="foster_type" class="form-control" onchange="toggleFields()" required>
                <option value="" disabled selected>Select type</option>
                <option value="short-term">Short-Term</option>
                <option value="permanent">Permanent</option>
            </select>
        </div>

        <!-- Fields for short-term foster -->
        <div id="short-term-fields" class="d-none">
            <div class="form-group mb-3">
                <label>Duration (weeks):</label>
                <input type="number" name="duration" class="form-control">
            </div>
            <div class="form-group mb-3">
                <label>Temporary Address:</label>
                <input type="text" name="temporary_address" class="form-control">
            </div>
        </div>

        <!-- Fields for permanent foster -->
        <div id="permanent-fields" class="d-none">
            <div class="form-group mb-3">
                <label>Employment Status:</label>
                <input type="text" name="employment_status" class="form-control">
            </div>
            <div class="form-group mb-3">
                <label>Own or Rent Home:</label>
                <input type="text" name="housing_status" class="form-control">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Submit Application</button>
    </form>
</div>

<script>
function toggleFields() {
    const type = document.getElementById('foster_type').value;
    document.getElementById('short-term-fields').classList.add('d-none');
    document.getElementById('permanent-fields').classList.add('d-none');

    if (type === 'short-term') {
        document.getElementById('short-term-fields').classList.remove('d-none');
    } else if (type === 'permanent') {
        document.getElementById('permanent-fields').classList.remove('d-none');
    }
}
</script>
</x-app-layout>