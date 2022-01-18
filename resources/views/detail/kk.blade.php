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
                                        <dd class="col-sm-12 col-md-9" id="patient_{{$item->id}}_nik">{{$item->nik}}</dd>

                                        <dt class="col-sm-12 col-md-3">Nama Lengkap</dt>
                                        <dd class="col-sm-12 col-md-9" id="patient_{{$item->id}}_name">{{$item->name}}</dd>

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
                                                    <span class="badge bg-success">Tidak Pernah Terjangkit</span>
                                                    @break
                                                @case('being_infected')
                                                    <span class="badge bg-danger">Sedang Terjangkit</span>
                                                    @break
                                                @case('been_infected')
                                                    <span class="badge bg-warning text-dark">Pernah Terjangkit</span>
                                                    <span class="badge bg-success">Sudah Sembuh</span>
                                                    @break
                                                @default
                                                    <span class="badge bg-success">Tidak Pernah Terjangkit</span>
                                            @endswitch
                                        </dd>

                                    </dl>

                                    @if(count($item->registrations) > 0)
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No. Reg</th>
                                                    <th>Positif</th>
                                                    <th>Negatif</th>
                                                    <th>Cetak</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($item->registrations as $reg)
                                                <tr>
                                                    <td>#{{ sprintf("%05d", $reg->id) }}</td>
                                                    <td>
                                                        {{ _date_format($reg->infected_date_start, 'l, d F Y') }}
                                                        <a href="{{ asset('files/'. $reg->covid_infected_start) }}" target="__blank">Bukti</a>
                                                    </td>
                                                    <td>
                                                        @if($reg->infection_status === 'infected')
                                                            <form action="/update_covid_status/{{$reg->id}}" method="post" enctype="multipart/form-data">
                                                                @csrf
                                                                <row class="row g-1">
                                                                    <div class="col-sm-12">
                                                                        <input type="date" id="infected_date_end" name="infected_date_end" class="form-control" value="{{{ old('infected_date_end') }}}" required/>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <input type="file" accept="image/*" name="covid_infected_end" id="covid_infected_end" class="form-control" required>
                                                                    </div>
                                                                    <div class="col-sm-12 d-grid">
                                                                        <button type="submit" class="btn btn-success btn-block">Update Status Covid</button>
                                                                    </div>
                                                                </row>
                                                            </form>
                                                        @else
                                                        {{ _date_format($reg->infected_date_end, 'l, d F Y') }}
                                                        <a href="{{ asset('files/'. $reg->covid_infected_end) }}" target="__blank">Bukti</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="/print/{{ $reg->id }}" target="__blank">
                                                            <button type="button" class="btn btn-warning ">cetak</button>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <a href="/print_no_covid/{{ $item->id }}" target="__blank" class="d-grid">
                                            <button type="button" class="btn btn-success btn-block">cetak</button>
                                        </a>
                                    @endif 
                                    <br>
                                    <div class="d-grid">
                                        <button type="button" onclick="register_patient({{$item->id}})" class="btn btn-warning btn-block">Tambah Riwayat Covid</button>
                                    </div>
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
<div class="modal fade" id="exampleModalToggle" data-bs-backdrop="static"  aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel">Tambah Informasi Covid-19 Pasien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="/register_patient" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="mb-3">
                        <label for="patient" class="form-label"><b>Pasien</b></label> <br>
                        <span id="register_name"></span>
                        <input type="hidden" name="patient_id" id="patient_id" value="{{ old('patient_id') }}">
                    </div>
                    <div class="mb-3">
                        <label for="covid_status" class="form-label">Status covid-19 <span class="text-danger">*</span></label>
                        <select id="covid_status" name="covid_status" class="form-select" required>
                            <option value="being_infected" {{ old('covid_status') === 'being_infected' ? 'selected' : '' }}>Sedang terjangkit</option>
                            <option value="been_infected" {{ old('covid_status') === 'been_infected' ? 'selected' : '' }}>Pernah terjangkit</option>
                        </select>
                    </div>

                    <div class="col-sm-12" id="covid_input_section"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" class="button" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success">Tambah Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script>

    const modal = $('#exampleModalToggle')
    const register_name = $('#register_name');
    const patient_id = $('#patient_id');

    const register_patient = (id) => {
        modal.modal('toggle');

        patient_id.val(id);
        register_name.html(
            $(`#patient_${id}_name`).html() + ' | ' + $(`#patient_${id}_nik`).html()
        )
    }

    const covid_status = $('#covid_status')
        const covid_input_section = $('#covid_input_section');

        const field_being_infected = `<div class="row g-2">
            <div class="col-sm-12">
                <label for="infected_date_start" class="form-label">Tgl Positif Covid <span class="text-danger">*</span></label>
                <input type="date" id="infected_date_start" name="infected_date_start" class="form-control" value="{{{ old('infected_date_start') }}}" required/>
            </div>

            <div class="col-sm-12">
                <label for="covid_infected_start" class="form-label">Hasil Test PCR/Antigen <span class="text-danger">*</span></label>
                <input type="file" accept="image/*" name="covid_infected_start" id="covid_infected_start" class="form-control" required>
            </div>
        </div>`;

        const field_been_infected = `<div class="row g-2">
            <div class="col-sm-12">
                <label for="infected_date_start" class="form-label">Tgl Positif Covid <span class="text-danger">*</span></label>
                <input type="date" id="infected_date_start" name="infected_date_start" class="form-control" value="{{{ old('infected_date_start') }}}" required/>
            </div>

            <div class="col-sm-12">
                <label for="covid_infected_start" class="form-label">Hasil Test PCR/Antigen <span class="text-danger">*</span></label>
                <input type="file" accept="image/*" name="covid_infected_start" id="covid_infected_start" class="form-control" required>
            </div>

            <div class="col-sm-12">
                <label for="infected_date_end" class="form-label">Tgl Sembuh Covid <span class="text-danger">*</span></label>
                <input type="date" id="infected_date_end" name="infected_date_end" class="form-control" value="{{{ old('infected_date_end') }}}" required/>
            </div>

            <div class="col-sm-12">
                <label for="covid_infected_end" class="form-label">Hasil Test PCR/Antigen <span class="text-danger">*</span></label>
                <input type="file" accept="image/*" name="covid_infected_end" id="covid_infected_end" class="form-control" required>
            </div>
        </div>`;

        covid_status.on('change', () => {
            let val = covid_status.val();

            if(val === 'being_infected') {
                covid_input_section.html(field_being_infected);
            } else if (val === 'been_infected') {
                covid_input_section.html(field_been_infected);
            } else {
                covid_input_section.html('')
            }
        });

        covid_status.change();
</script>
@endpush