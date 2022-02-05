<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Departments</h1>
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
                                        <input type="search" wire:model="search" name="search" class="form-control mb-2" id="inlineFormInput" placeholder="Search Department">
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
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deptModal">
                                New Department
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#Id</th>
                                <th scope="col">Department Name</th>
                                <th scope="col">Manage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($depts as $dept)
                            <tr>
                                <th scope="row">{{ $dept->id }}</th>
                                <td>{{ $dept->name }}</td>
                                <td>
                                    <button wire:click="showEditModel({{$dept->id}})" class=" btn btn-success">Edit</button>
                                    <button wire:click="deleteDept({{$dept->id}})" class=" btn btn-danger">Delete</button>

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
                        {{$depts->links('pagination::bootstrap-4')}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" wire:ignore.self id="deptModal" tabindex="-1" aria-labelledby="deptModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    @if(!$editMode)
                    <h5 class="modal-title" id="deptModalLabel">Create Dept.</h5>
                    @else
                    <h5 class="modal-title" id="deptModalLabel">Edit Dept.</h5>
                    @endif
                    <button type="button" class="close" wire:click="closeModal()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form>


                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Department Name') }}</label>

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
                    <button type="button" class="btn btn-success" wire:click="updateDept()">Update</button>
                    @else
                    <button type="button" class="btn btn-primary" wire:click="storeDept()">Store Dept.</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>