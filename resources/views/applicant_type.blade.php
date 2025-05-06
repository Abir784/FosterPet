<x-app-layout>
<div class="container mt-4">
    <h2>Foster Application Form</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($pets->isEmpty())
        <div class="alert alert-info">
            You don't have any approved adoption requests to apply for fostering.
            Please submit an adoption request first.
        </div>
    @else
    <form action="{{ route('applicant-types.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="adoption_request_id">Select Pet Request:</label>
            <select name="adoption_request_id" class="form-control" required>
                @foreach($pets as $pet)
                    @if(isset($pet->adoption) && $pet->adoption->adoptionRequest)
                        <option value="{{ $pet->adoption->adoptionRequest->id }}">
                            {{ $pet->name }} ({{ $pet->breed }})
                        </option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="foster_type">Foster Type:</label>
            <select name="foster_type" id="foster_type" class="form-control" required>
                <option value="" disabled selected>Select type</option>
                <option value="short-term">Short-Term</option>
                <option value="permanent">Permanent</option>
            </select>
        </div>

        <!-- Fields for short-term foster -->
        <div id="short-term-fields" style="display: none;">
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
        <div id="permanent-fields" style="display: none;">
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
    @endif
</div>

@push('scripts')
<script>
// Function to toggle fields based on selection
function toggleFields() {
    console.log('toggleFields called');
    const fosterType = document.getElementById('foster_type');
    if (!fosterType) {
        console.error('foster_type element not found');
        return;
    }

    const type = fosterType.value;
    console.log('Selected type:', type);

    // Toggle short-term fields
    const shortTermFields = document.getElementById('short-term-fields');
    console.log('Short term fields element:', shortTermFields);
    if (shortTermFields) {
        const displayValue = (type === 'short-term') ? 'block' : 'none';
        console.log('Setting short term fields display to:', displayValue);
        shortTermFields.style.display = displayValue;
    }

    // Toggle permanent fields
    const permanentFields = document.getElementById('permanent-fields');
    console.log('Permanent fields element:', permanentFields);
    if (permanentFields) {
        const displayValue = (type === 'permanent') ? 'block' : 'none';
        console.log('Setting permanent fields display to:', displayValue);
        permanentFields.style.display = displayValue;
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded');
    const fosterTypeSelect = document.getElementById('foster_type');
    console.log('Foster type select element:', fosterTypeSelect);

    if (fosterTypeSelect) {
        // Add change event listener
        fosterTypeSelect.addEventListener('change', function() {
            console.log('Foster type changed');
            toggleFields();
        });

        // Set initial state
        console.log('Setting initial state');
        toggleFields();
    } else {
        console.error('Could not find foster_type element');
    }
});
</script>
@endpush
</x-app-layout>
