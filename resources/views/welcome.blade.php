@extends('layout')

@section('content')
<div class="container m-auto">
    <div class="row g-2">
        <div class="col-sm-12 col-lg-6 offset-lg-3">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('action_search') }}" method="POST">
                        @csrf
                        <label for="text" class="form-label">Cek Riwayat Covid</label>
                        <div class="input-group mb-3">
                            <input type="text" oninput="numberOnly(this.id);" id="search" name="search" class="form-control" placeholder="NIK/KK" minlength="16" maxlength="16" required>
                            <button class="btn btn-success" type="submit" id="button-addon2">PERIKSA</button>
                        </div>
                        <div id="passwordHelpBlock" class="form-text">
                            <span class="text-danger">*</span> Masukan NIK/KK Pasien
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