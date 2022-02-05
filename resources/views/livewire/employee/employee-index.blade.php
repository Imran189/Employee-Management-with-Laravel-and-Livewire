<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Employees</h1>
    </div>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <div class="card  mx-auto">
                <div>
                    @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                    @endif
                </div>
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <form>
                                <div class="form-row align-items-center">
                                    <div class="col">
                                        <input type="search" wire:model="search" name="search" class="form-control mb-2" id="inlineFormInput" placeholder="Search Employee">
                                    </div>
                                    <div class="col">
                                        <select wire:model="selectDeptId" class="form-control mb-2">
                                            <option selected>Choose Dept</option>
                                            @foreach($depts as $dept)
                                            <option value="{{$dept->id}}">{{$dept->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col" wire:loading>
                                        <div class="spinner-border text-success" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#employeeModal">
                                New Employee
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#Id</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Department</th>
                                <th scope="col">Country</th>
                                <th scope="col">Date Hired</th>
                                <th scope="col">Manage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($employees as $employee)
                            <tr>
                                <th scope="row">{{ $employee->id }}</th>
                                <td>{{ $employee->first_name }}</td>
                                <td>{{ $employee->department->name}}</td>
                                <td>{{ $employee->country->name}}</td>
                                <td>{{ $employee->date_hired}}</td>
                                <td>
                                    <button wire:click="showEditModel({{$employee->id}})" class=" btn btn-success">Edit</button>
                                    <button wire:click="deleteEmployee({{$employee->id}})" class=" btn btn-danger">Delete</button>

                                </td>
                            </tr>
                            @empty
                            <tr>
                                <th>No Result to Show</th>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div>
                        {{$employees->links('pagination::bootstrap-4')}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" wire:ignore.self id="employeeModal" tabindex="-1" aria-labelledby="employeeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    @if(!$editMode)
                    <h5 class="modal-title" id="employeeModalLabel">Create Employee</h5>
                    @else
                    <h5 class="modal-title" id="employeeModalLabel">Edit Employee</h5>
                    @endif
                    <button type="button" class="close" wire:click="closeModal()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form>
                        <div class="form-group row">
                            <label for="lastName" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>

                            <div class="col-md-6">
                                <input id="lastName" type="text" class="form-control @error('lastName') is-invalid @enderror" wire:model="lastName">

                                @error('lastName')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="firstName" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>

                            <div class="col-md-6">
                                <input id="firstName" type="text" class="form-control @error('firstName') is-invalid @enderror" wire:model="firstName">

                                @error('firstName')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="middleName" class="col-md-4 col-form-label text-md-right">{{ __('Middle Name') }}</label>

                            <div class="col-md-6">
                                <input id="middleName" type="text" class="form-control @error('middleName') is-invalid @enderror" wire:model="middleName">

                                @error('middleName')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" wire:model="address">

                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="countryId" class="col-md-4 col-form-label text-md-right">{{ __('Country ') }}</label>

                            <div class="col-md-6" id="countryId" wire:model="countryId">
                                <select class="custom-select">
                                    <option selected disabled>Choose Country </option>
                                    @foreach($countries as $country)
                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                    @endforeach
                                </select>
                                @error('countryId')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="stateId" class="col-md-4 col-form-label text-md-right">{{ __('State ') }}</label>

                            <div class="col-md-6" id="stateId" wire:model="stateId">
                                <select class="custom-select">
                                    <option selected disabled>Choose State</option>
                                    @foreach($states as $state)
                                    <option value="{{$state->id}}">{{$state->name}}</option>
                                    @endforeach
                                </select>
                                @error('stateId')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cityId" class="col-md-4 col-form-label text-md-right">{{ __('City') }}</label>

                            <div class="col-md-6" id="cityId" wire:model="cityId">
                                <select class="custom-select">
                                    <option selected disabled>Choose City </option>
                                    @foreach($cities as $city)
                                    <option value="{{$city->id}}">{{$city->name}}</option>
                                    @endforeach
                                </select>
                                @error('cityId')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="deptId" class="col-md-4 col-form-label text-md-right">{{ __('Department') }}</label>

                            <div class="col-md-6" id="deptId" wire:model="deptId">
                                <select class="custom-select">
                                    <option selected disabled>Choose Department </option>
                                    @foreach($depts as $dept)
                                    <option value="{{$dept->id}}">{{$dept->name}}</option>
                                    @endforeach
                                </select>
                                @error('deptId')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="zipCode" class="col-md-4 col-form-label text-md-right">{{ __('Zip Code') }}</label>

                            <div class="col-md-6">
                                <input id="zipCode" type="text" class="form-control @error('zipCode') is-invalid @enderror" wire:model="zipCode">

                                @error('zipCode')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="birthDay" class="col-md-4 col-form-label text-md-right">{{ __('Birth Day') }}</label>

                            <div class="col-md-6">
                                <input id="birthDay" type="date" class="form-control @error('birthDay') is-invalid @enderror" wire:model="birthDay">

                                @error('birthDay')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="dateHired" class="col-md-4 col-form-label text-md-right">{{ __('Date Heired') }}</label>
                            <div class="col-md-6">
                                <input id="dateHired" type="date" class="form-control @error('dateHired') is-invalid @enderror" wire:model="dateHired">

                                @error('dateHired')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal()">Close</button>
                    @if($editMode)
                    <button type="button" class="btn btn-success" wire:click="updateEmployee()">Update</button>
                    @else
                    <button type="button" class="btn btn-primary" wire:click="storeEmployee()">Store Employee</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>