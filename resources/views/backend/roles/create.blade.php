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
            <li class="breadcrumb-item active">Add Role Page</li>
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
          <h4>Add New Role</h4>
        </div>
        <div class="float-sm-right">
          <a class="btn btn-info text-white" href="{{ route('roles.index') }}">Back</a>
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
              <form action="{{ route('roles.store') }}" method="post">
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
                    <label for="permissions" class="col-md-4 col-form-label text-md-end text-start">Permissions</label>
                    <div class="col-md-6">           
                        <div class="select2-purple">
                          <select class="select2 @error('permissions') is-invalid @enderror" multiple="multiple" data-placeholder="Select Permission" aria-label="Permissions" id="permissions" name="permissions[]" style="width: 100%;" data-dropdown-css-class="select2-purple">
                            @forelse ($permissions as $permission)
                                <option value="{{ $permission->id }}" {{ in_array($permission->id, old('permissions') ?? []) ? 'selected' : '' }}>
                                    {{ $permission->name }}
                                </option>
                            @empty

                            @endforelse
                        </select>
                        @if ($errors->has('permissions'))
                            <span class="text-danger">{{ $errors->first('permissions') }}</span>
                        @endif
                        </div>
                    </div>
                </div>
                
                <div class="mb-3 row">
                    <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Add Role">
                </div>
                
            </form>
            </div>
        </div>
      </div>
      
    </div>
    
    
  </section>
</div>
@endsection