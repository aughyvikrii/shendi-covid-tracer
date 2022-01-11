@extends('layout')

@section('content')
<div class="container m-auto">
    <div class="row">
        <div class="col-sm-12 col-lg-8 offset-lg-2">
            <h2>No KK: {{ $kk }}</h2>
            <div class="card">
                <div class="card-body">
                    @if(!empty($warning))
                        <div class="alert alert-warning">
                            {{ $warning }}
                        </div>
                    @endif

                    <div class="accordion" id="accordionExample">
                        @foreach($family_members as $item)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="member_{{$item->id}}">
                                <button class="accordion-button collapsed {{ $item->covid_status === 'being_infected' ? 'bg-danger' : ( $item->covid_status === 'been_infected' ? 'bg-warning' : '' )}}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_{{$item->id}}" aria-expanded="false" aria-controls="collapse_{{$item->id}}">
                                    {{$item->nik}} | {{ $item->name }}
                                </button>
                            </h2>
                            <div id="collapse_{{$item->id}}" class="accordion-collapse collapse {{ request()->nik === $item->nik ? 'show' : '' }}" aria-labelledby="member_{{$item->id}}" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <dl class="row">
                                        <dt class="col-sm-12 col-md-3">NIK</dt>
                                        <dd class="col-sm-12 col-md-9">{{$item->nik}}</dd>

                                        <dt class="col-sm-12 col-md-3">Nama Lengkap</dt>
                                        <dd class="col-sm-12 col-md-9">{{$item->name}}</dd>

                                        <dt class="col-sm-12 col-md-3">TTL</dt>
                                        <dd class="col-sm-12 col-md-9">{{$item->place_of_birth}}, {{ \Carbon\Carbon::parse($item->date_of_birth)->translatedFormat('d F Y') }}</dd>
                                        
                                        <dt class="col-sm-12 col-md-3">Alamat</dt>
                                        <dd class="col-sm-12 col-md-9">{{ $item->address }}</dd>
                                        
                                        <dt class="col-sm-12 col-md-3">Kontak</dt>
                                        <dd class="col-sm-12 col-md-9">{{ $item->phone_number }} | {{ $item->email }}</dd>
                                        
                                        <dt class="col-sm-12 col-md-3">Agama</dt>
                                        <dd class="col-sm-12 col-md-9">{{ @$item->religion->name ?: '-' }}</dd>
                                        
                                        <dt class="col-sm-12 col-md-3">Golongan Darah</dt>
                                        <dd class="col-sm-12 col-md-9">{{ @$item->blood_type->name ?: '-' }}</dd>
                                        
                                        <dt class="col-sm-12 col-md-3">Status</dt>
                                        <dd class="col-sm-12 col-md-9">{{ @$item->marital_status->name ?: '-' }}</dd>
                                        
                                        <dt class="col-sm-12 col-md-3">Jenis Kelamin</dt>
                                        <dd class="col-sm-12 col-md-9">{{ @$item->gender->name ?: '-' }}</dd>

                                        <dt class="col-sm-12 col-md-3">Status Covid-19?</dt>
                                        <dd class="col-sm-12 col-md-9">
                                            @switch($item->covid_status)
                                                @case('never_infected')
                                                    Tidak Pernah Terjangkit
                                                    @break
                                                @case('being_infected')
                                                    Sedang Terjangkit
                                                    @break
                                                @case('been_infected')
                                                    Pernah Terjangkit
                                                    @break
                                                @default
                                                    Tidak Pernah Terjangkit
                                            @endswitch
                                        </dd>

                                        @if($item->covid_status === 'being_infected')
                                        <dt class="col-sm-12 col-md-3">Tgl awal positif</dt>
                                        <dd class="col-sm-12 col-md-9">{{ _date_format($item->infected_date_start, 'l, d F Y') }}</dd>
                                        
                                        <dt class="col-sm-12 col-md-3">Bukti Terjangkit</dt>
                                        <dd class="col-sm-12 col-md-9">
                                            <a href="{{ asset('files/'. $item->covid_infected_start) }}" target="__blank">Lihat Bukti</a>
                                        </dd>
                                        @elseif($item->covid_status === 'been_infected')
                                        <dt class="col-sm-12 col-md-3">Tgl awal positif</dt>
                                        <dd class="col-sm-12 col-md-9">{{ _date_format($item->infected_date_start, 'l, d F Y') }}</dd>
                                        
                                        <dt class="col-sm-12 col-md-3">Bukti Terjangkit</dt>
                                        <dd class="col-sm-12 col-md-9">
                                            <a href="{{ asset('files/'. $item->covid_infected_start) }}" target="__blank">Lihat Bukti</a>
                                        </dd>

                                        <dt class="col-sm-12 col-md-3">Tgl sembuh</dt>
                                        <dd class="col-sm-12 col-md-9">{{ _date_format($item->infected_date_end, 'l, d F Y') }}</dd>
                                        
                                        <dt class="col-sm-12 col-md-3">Bukti sembuh</dt>
                                        <dd class="col-sm-12 col-md-9">
                                            <a href="{{ asset('files/'. $item->covid_infected_end) }}" target="__blank">Lihat Bukti</a>
                                        </dd>
                                        @endif
                                        
                                        <dt class="col-sm-12 col-md-3">Tgl Ditambah</dt>
                                        <dd class="col-sm-12 col-md-9">{{ _date_format($item->created_at, 'l, d F Y - H:i') }}</dd>

                                    </dl>

                                    @if($item->covid_status === 'being_infected')
                                        <form action="/update_covid_status/{{$item->id}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row g-2">
                                                <div class="col-sm-12 col-md-6">
                                                    <label for="infected_date_end" class="form-label">Tgl Sembuh Covid <span class="text-danger">*</span></label>
                                                    <input type="date" id="infected_date_end" name="infected_date_end" class="form-control" value="{{{ old('infected_date_end') }}}" required/>
                                                </div>

                                                <div class="col-sm-12 col-md-6">
                                                    <label for="covid_infected_end" class="form-label">Hasil Test PCR/Antigen <span class="text-danger">*</span></label>
                                                    <input type="file" name="covid_infected_end" id="covid_infected_end" class="form-control" required>
                                                </div>

                                                <div class="col-12 text-end">
                                                    <button type="submit" class="btn btn-success ">Update Status Covid</button>
                                                </div>
                                            </div>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <br>

                    <div class="row g-3">
                        <div class="col">
                            <a href="{{ route('register') }}" class="d-grid">
                                <button class="btn btn-success btn-block">
                                    Tambah Anggota Keluarga
                                </button>
                            </a>
                        </div>
                        <div class="col">
                            <a href="{{ route('welcome') }}" class="d-grid">
                                <button class="btn btn-primary btn-block">
                                    Kembali ke beranda
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection