<x-app-layout>
    <body>
        <div class="card basic-data-table">
          <div class="card-body">
            <table class="table mb-0 bordered-table" id="dataTable" data-page-length='20'>
              <thead>
                <tr>
                  <th scope="col">S.L</th>
                  <th scope="col">Name</th>
                  <th scope="col">Age</th>
                  <th scope="col">Breed</th>
                  <th scope="col">Color</th>
                  <th scope="col">Health Condition</th>
                  <th scope="col">Image</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>

              <tbody>
                @foreach($pets as $SL=>$pet)
                <tr>
                  <td>{{ $SL+1 }}</td>
                  <td>{{ $pet->name }}</td>
                  <td>{{ $pet->age }}</td>
                  <td>{{ $pet->breed }}</td>
                  <td>{{ $pet->color }}</td>
                  <td>{{ $pet->health_condition }}</td>
                  <td>
                    <img src="{{ asset($pet->image) }}" alt="{{ $pet->name }}" width="100" height="100">
                  </td>
                  <td>
                    <div class="d-flex gap-2">
                      <a href="{{ route('pets.update_form', $pet->id) }}" class="btn btn-primary btn-sm">Edit</a>
                      <form action="{{ route('pets.destroy_pet', $pet->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this pet?')">Delete</button>
                      </form>
                    </div>
                  </td>
                </tr>

                @endforeach
              </tbody>

            </table>
          </div>
        </div>
      </div>
    </body>
   </x-app-layout>
