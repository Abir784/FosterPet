<x-app-layout>

    {{-- Toast for success message --}}
    @if (session('success'))
        <div id="toast" style="position: fixed; top: 20px; right: 20px; background-color: #38c172; color: white; padding: 10px 20px; border-radius: 5px; z-index: 9999;">
            {{ session('success') }}
        </div>

        <script>
            // Hide the toast after 3 seconds
            setTimeout(() => {
                document.getElementById('toast').style.display = 'none';
            }, 3000);
        </script>
    @endif

    <div class="form-container">
        <h2> 🐾 Add Pet Details</h2>

        <form action="{{ route('add_pets.post') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label for="name">🐶 Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter pet's name" value="{{ old('name') }}" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div class="form-group">
                    <label for="type">🐶 Type</label>
                    <input type="text" id="type" name="type" placeholder="Enter pet's type" value="{{ old('type') }}" required />
                    <x-input-error :messages="$errors->get('type')" class="mt-2" />
                </div>
                <div class="form-group">
                    <label for="age">📅 Age</label>
                    <input type="text" id="age" name="age" placeholder="Enter pet's age" value="{{ old('age') }}" required />
                    <x-input-error :messages="$errors->get('age')" class="mt-2" />
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="breed">🐕 Breed</label>
                    <input type="text" id="breed" name="breed" placeholder="Enter breed" value="{{ old('breed') }}" required />
                    <x-input-error :messages="$errors->get('breed')" class="mt-2" />
                </div>
                <div class="form-group">
                    <label for="health_condition">❤️ Health Condition</label>
                    <input type="text" id="health_condition" name="health_condition" placeholder="Enter health condition" value="{{ old('health_condition') }}" required />
                    <x-input-error :messages="$errors->get('health_condition')" class="mt-2" />
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="color">🎨 Color</label>
                    <input type="text" id="color" name="color" placeholder="Enter color" value="{{ old('color') }}" required />
                    <x-input-error :messages="$errors->get('color')" class="mt-2" />
                </div>
                <div class="form-group">
                    <label for="image">📸 Upload Pet Image</label>
                    <input type="file" name="image" id="image" accept="image/*">
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                </div>
                <div class="form-group">
                    <label for="remarks">📝 Remarks</label>
                    <input type="text" id="remarks" name="remarks" placeholder="Enter remarks" value="{{ old('remarks') }}" required />
                    <x-input-error :messages="$errors->get('remarks')" class="mt-2" />
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="location">📍 Location</label>
                    <input type="text" id="location" name="location" placeholder="Enter location" value="{{ old('location') }}" required />
                    <x-input-error :messages="$errors->get('location')" class="mt-2" />
                </div>
                <div class="form-group full-width">
                    <label for="temperament">😺 Temperament</label>
                    <input type="text" id="temperament" name="temperament" placeholder="Describe temperament" value="{{ old('temperament') }}" required />
                    <x-input-error :messages="$errors->get('temperament')" class="mt-2" />
                </div>
            </div>

            <br>

            <div>
                <button type="submit" class="form-button">Submit</button>
            </div>
        </form>
    </div>

</x-app-layout>
