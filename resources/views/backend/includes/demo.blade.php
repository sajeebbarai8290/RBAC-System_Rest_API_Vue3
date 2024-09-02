{{-- @extends('layouts.app') --}}

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
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">User Page</li>
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
          <h4>Users Management</h4>
        </div>
        <div class="float-sm-right">
          <a class="btn btn-success" href="">Create New User</a>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="container">
        <div class="card">
          <div class="card-header">
            @if ($message = Session::get('success'))
            <div class="alert alert-success">
              <p>{{ $message }}</p>
            </div>
            @endif
            </div>
            <div class="card-body">
            
            </div>
        </div>
      </div>
      
    </div>
    
    
  </section>
</div>
@endsection