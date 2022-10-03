@extends('layout')

@section('content')
<div class="container mt-4">
  <div class="row g-2">
    <div class="col-sm-4 col-lg-3 offset-lg-3">
      <div class="card">
        <div class="card-body text-center">
          <h5>Jumlah Pasien</h5>
          {{ $people->total }}
        </div>
      </div>
    </div>

    <div class="col-sm-4 col-lg-3">
      <div class="card">
        <div class="card-body text-center">
          <h5>Jumlah KK</h5>
          {{ $people->kk }}
        </div>
      </div>
    </div>
  </div>

  <div class="row g-2 mt-4">


    <div class="col-sm-4 col-lg-4">
      <div class="card">
        <div class="card-body text-center">
          <h5>Tidak Terjangkit</h5>
          {{ $people->total - ($covid_status->being_infected + $covid_status->been_infected) }}
        </div>
      </div>
    </div>

    <div class="col-sm-4 col-lg-4">
      <div class="card">
        <div class="card-body text-center">
          <h5>Sedang Terjangkit</h5>
          {{ $covid_status->being_infected }}
        </div>
      </div>
    </div>

    <div class="col-sm-4 col-lg-4">
      <div class="card">
        <div class="card-body text-center">
          <h5>Sudah Sembuh</h5>
          {{ $covid_status->been_infected }}
        </div>
      </div>
    </div>
  </div>

  <div class="mt-4">
    <div class="table-responsive">
      <table class="table table-bordered table-light table-hover">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>NIK</th>
            <th>Status</th>
            <th>Tgl Input</th>
            <th class="text-center">#</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; ?>
          @foreach($persons as $person)
          <tr>
            <td>{{$no++}}</td>
            <td>{{$person->first_name}} {{$person->last_name}}</td>
            <td>{{$person->nik}}</td>
            <td>{{$person->covid_status === "been_infected" ? "Pernah Terjangkit" : ($person->covid_status === "being_infected" ? "Sedang Terjangkit" : "Tidak Pernah Terjangkit")}}</td>
            <td>{{$person->created_at ?? '-'}}</td>
            <td class="text-center d-grid">
              <a href="/kk/{{$person->kk}}?nik={{$person->nik}}">
                <button class="btn btn-sm btn-primary">Detail</button>
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection