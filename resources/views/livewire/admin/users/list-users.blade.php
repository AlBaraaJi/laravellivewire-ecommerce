{{-- @extends('layouts.app')
@section('content') --}}

<div>
  <div class="pagetitle">
    <h1>All Users</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
        <li class="breadcrumb-item active">Users</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <section class="section">
    <div class="row mt-5">
      <div class="col-lg-12">

        <div class="d-flex justify-content-between mb-3">
          <div>
            <button wire:click.prevent='addNew' class="btn btn-primary"><i class="ri-add-line"></i> Add New
              User</button>

            <div class="btn-group">
              <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown"
                aria-expanded="false">
                Action
              </button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="#" wire:click.prevent="deleteSelectedRows">Delete Selected</a>
                <a class="dropdown-item" href="#" wire:click.prevent="changeToUser">Change Role to USER</a>
                <a class="dropdown-item" href="#" wire:click.prevent="changeToAdmin">Change Role to ADMIN</a>
              </div>
            </div>


          </div>

          <div>
            @include('components.search-input')
          </div>
        </div>

        {{-- <div class="d-flex justify-content-end mb-2">


        </div> --}}
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Users</h5>

            <!-- Default Table -->
            <table class="table">
              <thead>
                <tr>
                  <th>
                    <div class="icheck-primary d-inline ml-2">
                      <input wire:model.lazy='selectedPageRows' type="checkbox" name="todo2" id="checkbox">
                      <label for="checkbox"></label>
                    </div>
                  </th>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Email</th>
                  <th scope="col">Role</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($users as $user)
                <tr>
                  <th>
                    <div class="icheck-primary d-inline ml-2">
                      <input wire:model.lazy='selectedRows' type="checkbox" value="{{$user->id}}" name="todo2"
                        id="checkbox{{$user->id}}">
                      <label for="checkbox{{$user->id}}"></label>
                    </div>
                  </th>
                  <th scope="row">{{$loop->iteration}}</th>
                  <td>{{$user->name}}</td>
                  <td>{{$user->email}}</td>
                  <td value="{{$user->role_id}}">{{ ($user->role_id == '1') ? 'Admin' : 'User' }}</td>
                  <td>
                    <button wire:click.prevent='edit({{$user}})' type="submit" class="btn btn-success"><i
                        class="ri-edit-line"></i>
                      <span>Edit</span>
                    </button>

                    <button wire:click.prevent='confirmDelete({{$user->id}})' type="submit" class="btn btn-danger"><i
                        class="ri-delete-bin-6-line"></i>
                      <span>Delete</span>
                    </button>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            {{-- @dump($selectedRows) --}}
            <!-- End Default Table Example -->
          </div>
          <div class="card-footer d-flex justify-content-end">
            {{$users->links()}}
          </div>
        </div>

      </div>


    </div>
  </section>

  <!-- Modal -->
  <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
    wire:ignore.self>
    <div class="modal-dialog" role="document">
      {{--start form --}}
      <form action="" wire:submit.prevent='{{$showEditModal ? ' updateUser' : 'createUser' }}' autocomplete="off">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              @if ($showEditModal)
              <span>Edit User</span>
              @else
              <span>Add New User</span>
              @endif
            </h5>
          </div>
          <div class="modal-body">
            <div class="form-group mb-3">
              <label for="name">Name</label>

              <input wire:model.defer='state.name' type="text" class="form-control @error('name') is-invalid @enderror"
                id="name" aria-describedby="nameHelp" placeholder="your full name">
              @error('name')
              <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>

            <div class="form-group mb-3">
              <label for="email">Email address</label>

              <input wire:model.defer='state.email' type="email"
                class="form-control @error('state.email') is-invalid @enderror" id="email" aria-describedby="emailHelp"
                placeholder="Enter email">
              @error('email')
              <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>

            <div class="form-group mb-3">
              <label for="password">Password</label>

              <input wire:model.defer='state.password' type="password"
                class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password">
              @error('password')
              <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>

            <div class="form-group mb-3">
              <label for="passwordConfirmation">Confirm Password</label>

              <input wire:model.defer='state.password_confirmation' type="password"
                class="form-control @error('password_confirmation') is-invalid @enderror" id="passwordConfirmation"
                placeholder="Confirm your Password">
              @error('password_confirmation')
              <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>

                
            <div class="form-group mb-3">
              <label for="newHobby">Hobbies</label>
              <div class="d-flex">
                <input wire:model.defer="newHobby" id="newHobby" type="text" class="form-control"
                  placeholder="Enter a hobby">
                <button wire:click.prevent="addHobby" type="button" class="btn btn-primary ms-2">Add</button>
              </div>
            </div>
            <div class="mt-2">
              @foreach ($hobbies as $index => $hobby)
              <span class="badge bg-primary text-light me-2 mb-2"
                style="font-size: 14px; display: inline-flex; align-items: center; padding: 8px 12px; border-radius: 20px;">
                {{ $hobby }}
                <button type="button" class="btn-close btn-close-white btn-sm ms-2"
                  wire:click="removeHobby({{ $index }})" aria-label="Remove"></button>
              </span>
              @endforeach
            </div>


            <div class="form-group">
              <select wire:model.defer='state.role_id' class="form-select @error('role_id') is-invalid @enderror">
                <option value="">Select the role</option>
                <option value="1">Admin</option>
                <option value="2">User</option>
                <!-- ... -->
              </select>
              @error('role_id')
              <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                class="ri-close-line"></i>Cancel</button>
            <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i>
              @if ($showEditModal)
              <span>Save changes</span>
              @else
              <span>Save</span>
              @endif
            </button>
          </div>
        </div>
      </form>
      {{-- end form --}}
    </div>
  </div>
  {{-- end modal --}}

  <!-- Delete Modal -->
  <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog" role="document">
      {{--start form --}}
      <div class="modal-content">
        <div class="modal-header">
          <h5>Delete User</h5>
        </div>

        <div class="modal-body">
          <h4>Are you sure to delete this user?</h4>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
              class="fa fa-times mr-1"></i>Cancel</button>
          <button wire:click.prevent='deleteUser' type="button" class="btn btn-danger"><i class="fa fa-trash mr-1"></i>
            <span>Delete</span>
          </button>
        </div>

      </div>
      {{-- end form --}}
    </div>
  </div>
  {{-- end delete modal --}}


</div>