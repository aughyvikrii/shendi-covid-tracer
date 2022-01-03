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
                                <button class="accordion-button collapsed {{ $item->on_covid ? 'bg-danger' : ''}}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_{{$item->id}}" aria-expanded="false" aria-controls="collapse_{{$item->id}}">
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

                                        <dt class="col-sm-12 col-md-3">Terjangkit Covid-19?</dt>
                                        <dd class="col-sm-12 col-md-9">{{ @$item->on_covid ? 'Ya' : 'Tidak' }}</dd>
                                        
                                        <dt class="col-sm-12 col-md-3">Tgl Ditambah</dt>
                                        <dd class="col-sm-12 col-md-9">{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('l, d F Y H:i') }}</dd>

                                    </dl>

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