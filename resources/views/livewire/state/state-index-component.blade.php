<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">States</h1>
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
                                        <input type="search" wire:model="search" name="search" class="form-control mb-2" id="inlineFormInput" placeholder="Search State">
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
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#userModal">
                                New State
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#Id</th>
                                <th scope="col">Country Name</th>
                                <th scope="col">State Name</th>
                                <th scope="col">Manage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($states as $state)
                            <tr>
                                <th scope="row">{{ $state->id }}</th>
                                <td>{{ $state->country->name}}</td>
                                <td>{{ $state->name }}</td>
                                <td>
                                    <button wire:click="showEditModel({{$state->id}})" class=" btn btn-success">Edit</button>
                                    <button wire:click="deleteState({{$state->id}})" class=" btn btn-danger">Delete</button>

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
                        {{$states->links('pagination::bootstrap-4')}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" wire:ignore.self id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    @if(!$editMode)
                    <h5 class="modal-title" id="userModalLabel">Create Country</h5>
                    @else
                    <h5 class="modal-title" id="userModalLabel">Edit Country</h5>
                    @endif
                    <button type="button" class="close" wire:click="closeModal()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form>
                        <div class="form-group row">
                            <label for="country_id" class="col-md-4 col-form-label text-md-right">{{ __('Country Code') }}</label>

                            <div class="col-md-6" id="country_id" wire:model="country_id">
                                <select class="custom-select">
                                    @foreach($countries as $country)
                                    <option selected disabled>Choose Country </option>
                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                    @endforeach
                                </select>
                                @error('country_code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Country Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name">

                                @error('name')
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
                    <button type="button" class="btn btn-success" wire:click="updateState()">Update</button>
                    @else
                    <button type="button" class="btn btn-primary" wire:click="storeState()">Store State</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>