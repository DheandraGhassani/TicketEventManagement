@extends('layouts.master')

@section('content')
  <div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h4 class="page-title">Dashboard</h4>
        <ul class="breadcrumbs">
          <li class="nav-home">
            <a href="#">
              <i class="icon-home"></i>
            </a>
          </li>
          <li class="separator">
            <i class="icon-arrow-right"></i>
          </li>
          <li class="nav-item">
            <a href="#">Pages</a>
          </li>
          <li class="separator">
            <i class="icon-arrow-right"></i>
          </li>
          <li class="nav-item">
            <a href="#">Unauthorized</a>
          </li>
        </ul>
      </div>
      <div class="card">
        <div class="card-body">
          <div class="text-center">
            <h1 class="display-1">403</h1>
            <p class="lead">Unauthorized Access</p>
            <a href="{{ route('home') }}" class="btn btn-primary">Go Back</a>
          </div>
      </div>
    </div>
  </div>
@endsection
