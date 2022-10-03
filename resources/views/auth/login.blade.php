@extends('layout')

@section('content')
<div class="container m-auto">
  <div class="row g-2">
    <div class="col-sm-12 col-lg-4 offset-lg-4">
      <div class="card">
        <div class="card-body">
          <form action="/auth/login" method="POST">
            @csrf
            <h3 class="text-center">Login Aplikasi</h3>
            @if($errors->has("message"))
            <div class="alert alert-danger">
              {{$errors->first("message")}}
            </div>
            @endif
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" aria-describedby="username" name="username" value="{{ old('username') }}" placeholder="......">
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="......">
            </div>
            <div class="d-grid">
              <button type="submit" class="btn btn-block btn-success">Submit</button>
            </div>
          </form>

        </div>
      </div>
    </div>

    <div class="col-sm-12">
      <div class="text-center">
        <img src="/images/logo_unibi.jpeg" alt="Unibi" class="img-thumbnail img-fluid logo">
        <img src="/images/logo_klinik.jpeg" alt="Unibi" class="img-thumbnail img-fluid logo">
      </div>
    </div>
  </div>
</div>
@endsection