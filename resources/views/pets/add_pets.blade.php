<x-app-layout>

 <div class="form-container">
    <h2> 🐾 Add Pet Details</h2>
    <form action="{{route('add_pets.post')}}" method="post" enctype="multipart/form-data">
    @csrf
      <div class="form-row">
        <div class="form-group">
          <label for="name">🐶Name</label>
          <input type="text" id="name" name="name" placeholder="Enter pet's name" required />
        </div>
        <div class="form-group">
          <label for="age">📅 Age</label>
          <input type="text" id="age" name="age" placeholder="Enter pet's age" required />
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label for="breed">🐕 Breed</label>
          <input type="text" id="breed" name="breed" placeholder="Enter breed" required />
        </div>
        <div class="form-group">
          <label for="health">❤️ Health Condition</label>
          <input type="text" id="health" name="health" placeholder="Enter health condition" required />        </div>
      </div>
      <div class="form-row">
      <div class="form-group">
          <label for="breed">🐕 color</label>
          <input type="text" id="breed" name="breed" placeholder="Enter breed" required />
        </div>
        <div class="form-group">
        <label for="image">Upload Pet Image:</label>
        <input type="file" name="image" id="breed" accept="image/*">
        </div>
        <div class="form-group">
          <label for="breed">🐕 remarks</label>
          <input type="text" id="breed" name="breed" placeholder="Enter remarks" required />
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label for="breed">🐕 location</label>
          <input type="text" id="breed" name="breed" placeholder="Enter location" required />
        </div>
      <div class="form-group full-width">
        <label for="temperament">😺 Temperament</label>
        <input type="text" id="temperament" name="temperament" placeholder="Describe temperament" required></input>
      </div>
      
    </form>
  </div>
  <div>
      <button type="submit" class="form-button">Submit</button>
      </div>
</x-app-layout>
 