@extends('backend.layouts.master')
{{-- @section('content') --}}
@section('main')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item active">Create User</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row mb-2">
      <div class="col-lg-12 margin-tb">
        <div class="float-sm-left ms-2">
          <h4>Add New User</h4>
        </div>
        <div class="float-sm-right">
          <a class="btn btn-info text-white" href="{{ route('users.index') }}">Back</a>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="container">
        <div class="card">
            <div class="card-header">
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                  </div>
                @endif
            </div>
            <div class="card-body">
              <form action="{{ route('users.store') }}" method="post">
                @csrf

                <div class="mb-3 row">
                    <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                    <div class="col-md-6">
                      <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                        @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="email" class="col-md-4 col-form-label text-md-end text-start">Email Address</label>
                    <div class="col-md-6">
                      <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="password" class="col-md-4 col-form-label text-md-end text-start">Password</label>
                    <div class="col-md-6">
                      <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                        @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="password_confirmation" class="col-md-4 col-form-label text-md-end text-start">Confirm Password</label>
                    <div class="col-md-6">
                      <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="roles" class="col-md-4 col-form-label text-md-end text-start">Roles</label>
                    <div class="col-md-6">
                      <div class="select2-purple">
                        <select class="select2 @error('roles') is-invalid @enderror" multiple="multiple" data-placeholder="Select a Role" data-dropdown-css-class="select2-purple" style="width: 100%;" aria-label="Roles" id="roles" name="roles[]">
                          @forelse ($roles as $role)

                              @if ($role!='Super Admin')
                                  <option value="{{ $role }}" {{ in_array($role, old('roles') ?? []) ? 'selected' : '' }}>
                                  {{ $role }}
                                  </option>
                              @else
                                  @if (Auth::user()->hasRole('Super Admin'))   
                                      <option value="{{ $role }}" {{ in_array($role, old('roles') ?? []) ? 'selected' : '' }}>
                                      {{ $role }}
                                      </option>
                                  @endif
                              @endif

                          @empty

                          @endforelse
                      </select>
                      @if ($errors->has('roles'))
                          <span class="text-danger">{{ $errors->first('roles') }}</span>
                      @endif
                      </div>
                    </div>
                </div>
                
                <div class="mb-3 row">
                    <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Add User">
                </div>

              </form>
            </div>
        </div>
      </div>
      
    </div>
    
    
  </section>
</div>
@endsection