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
            <li class="breadcrumb-item active">Show Role</li> 
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
          <h4>Role Information</h4>
        </div>
        <div class="float-sm-right">
          <a class="btn btn-info text-white" href="{{ route('roles.index') }}">Back</a>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Name:</strong>
                            {{ $role->name }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Permissions:</strong><br><br>
                            @if ($role->name=='Super Admin')
                                <span class="badge bg-primary">All</span>
                            @else
                                @forelse ($rolePermissions as $permission)
                                    <span class="badge bg-primary">{{ $permission->name }}</span>
                                @empty
                                @endforelse
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
      
    </div>
    
    
  </section>
</div>
@endsection