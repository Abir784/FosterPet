<x-app-layout>
    <body>
        <div class="card basic-data-table">
          <div class="card-body">
            <table class="table mb-0 bordered-table" id="dataTable" data-page-length='20'>
              <thead>
                <tr>

                  <th scope="col">
                    <div class="form-check style-check d-flex align-items-center">
                      <label class="form-check-label">
                        S.L
                      </label>
                    </div>
                  </th>

                <th scope="col">Name</th>
                <th scope="col">Age</th>
                <th scope="col">Breed</th>
                <th scope="col">Color</th>
                <th scope="col">Health Condition</th>
                <th scope="col">Image</th>
                <th scope="col" style="text-align: center;">Update</th>

                </tr>
              </thead>

              <tbody>
                @foreach($pets as $SL=>$pet)
                <tr>
                  <td><img src={{asset($pet->image)}} alt="{{$pet->image}}" width="200x" height="200px"></td>
                  <td>{{  $SL+1}}</td>
                  <td>{{$pet->name}}</td>
                  <td>{{$pet->age}}</td>
                  <td>{{$pet->breed}}</td>
                  <td>{{$pet->color}}</td>
                  <td>{{$pet->health_condition}}</td>

                  <td>
                    <a href="{{ route('pets.update_form')}}">
                    <button type="submit" class="form-button success">Edit</button>
                    </a>
                    <a href="{{ route('pets.update_pet')}}">
                    <button type="submit" class="form-button danger" style="text-align: center;">Delete</button>
                    </a>

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
