@extends('layouts.app')

@section('title', 'Contacts')

@section('content')
<div class="container w-75 m-4 bg-white d-flex flex-column gap-2 justify-content-start p-5">
  <h3>Contacts</h3>
  <div class="horizontalDivider mb-3"></div>
  <div class="col-md-11 px-4">
    <p>
      If you're having difficulties using our platform or would like to report a bug, 
      please contact us using:
    </p>
    <p class="m-0 p-0 fw-bold">
      +351 123 456 789
    </p>
    <p>
      contacts@wrottit.tk
    </p>
  </div>
</div>
@endsection