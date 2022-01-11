@extends('layout')

@section('content')
<div class="container m-auto pb-5 pt-2">
    <div class="row">
        <div class="col-sm-12 col-lg-8 offset-lg-2">
            <h3 class="text-bold">Formulir Pasien</h3>
            <div class="card">
                <div class="card-body">

                @if(session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                @endif

                @if(session()->has('warning'))
                    <div class="alert alert-warning">
                        {{ session()->get('warning') }}
                    </div>
                @endif

                    <form action="{{ route('register.action') }}" method="POST" class="row g-3" enctype="multipart/form-data">
                        @csrf
                        <div class="col-sm-12">
                            <h4>Data Diri</h4>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <label for="kk" class="form-label">Nomor KK <span class="text-danger">*</span> </label>
                            <input type="text" id="kk" name="kk" class="form-control" oninput="numberOnly(this.id);" maxlength="16" minlength="16" placeholder="16 Nomor KK" value="{{{ old('kk') }}}" required/>
                            @if($errors->has('kk'))
                            <small class="text-danger">{{ $errors->first('kk') }}</small>
                            @endif
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <label for="nik" class="form-label">Nomor NIK <span class="text-danger">*</span> </label>
                            <input type="text" id="nik" name="nik" class="form-control" oninput="numberOnly(this.id);" maxlength="16" minlength="16" placeholder="16 Nomor NIK" value="{{{ old('nik') }}}" required/>
                            @if($errors->has('nik'))
                            <small class="text-danger">{{ $errors->first('nik') }}</small>
                            @endif
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <label for="first_name" class="form-label">Nama Depan <span class="text-danger">*</span></label>
                            <input type="text" id="first_name" name="first_name" class="form-control" placeholder="John" value="{{{ old('first_name') }}}" required/>
                            @if($errors->has('first_name'))
                            <small class="text-danger">{{ $errors->first('first_name') }}</small>
                            @endif
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <label for="last_name" class="form-label">Nama Belakang</label>
                            <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Doe" value="{{{ old('last_name') }}}" required/>
                            @if($errors->has('last_name'))
                            <small class="text-danger">{{ $errors->first('last_name') }}</small>
                            @endif
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <label for="place_of_birth" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                            <input type="text" id="place_of_birth" name="place_of_birth" class="form-control" placeholder="Bandung" value="{{{ old('place_of_birth') }}}" required/>
                            @if($errors->has('place_of_birth'))
                            <small class="text-danger">{{ $errors->first('place_of_birth') }}</small>
                            @endif
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <label for="date_of_birth" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="date" id="date_of_birth" name="date_of_birth" class="form-control" value="{{{ old('date_of_birth') }}}" required/>
                            @if($errors->has('date_of_birth'))
                            <small class="text-danger">{{ $errors->first('date_of_birth') }}</small>
                            @endif
                        </div>

                        <div class="col-sm-12">
                            <label for="address" class="form-label">Alamat lengkap <span class="text-danger">*</span></label>
                            <textarea name="address" id="address" cols="3" rows="3" class="form-control" required>{{{ old('address') }}}</textarea>
                            @if($errors->has('address'))
                            <small class="text-danger">{{ $errors->first('address') }}</small>
                            @endif
                        </div>

                        <div class="col-sm-6 col-md-3">
                            <label for="religion_id" class="form-label">Agama <span class="text-danger">*</span></label>
                            <select id="religion_id" name="religion_id" class="form-select">
                                <option selected>Pilih...</option>
                                @foreach($religions as $item)
                                <option value="{{ $item->id }}" {{ $item->id == old('religion_id') ? 'selected' : '' }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('religion_id'))
                            <small class="text-danger">{{ $errors->first('religion_id') }}</small>
                            @endif
                        </div>

                        <div class="col-sm-6 col-md-3">
                            <label for="marital_status_id" class="form-label">Status <span class="text-danger">*</span></label>
                            <select id="marital_status_id" name="marital_status_id" class="form-select">
                            <option selected>Pilih...</option>
                                @foreach($marital_statuses as $item)
                                <option value="{{ $item->id }}"  {{ $item->id == old('marital_status_id') ? 'selected' : '' }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('marital_status_id'))
                            <small class="text-danger">{{ $errors->first('marital_status_id') }}</small>
                            @endif
                        </div>

                        <div class="col-sm-6 col-md-3">
                            <label for="gender_id" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select id="gender_id" name="gender_id" class="form-select">
                                <option selected>Pilih...</option>
                                @foreach($genders as $item)
                                <option value="{{ $item->id }}"  {{ $item->id == old('gender_id') ? 'selected' : '' }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('gender_id'))
                            <small class="text-danger">{{ $errors->first('gender_id') }}</small>
                            @endif
                        </div>

                        <div class="col-sm-6 col-md-3">
                            <label for="blood_type_id" class="form-label">Golongan Darah <span class="text-danger">*</span></label>
                            <select id="blood_type_id" name="blood_type_id" class="form-select">
                                <option selected>Pilih...</option>
                                @foreach($blood_types as $item)
                                <option value="{{ $item->id }}" {{ $item->id == old('blood_type_id') ? 'selected' : '' }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('blood_type_id'))
                            <small class="text-danger">{{ $errors->first('blood_type_id') }}</small>
                            @endif
                        </div>

                        <div class="col-sm-12">
                            <h4>Informasi Kontak</h4>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <label for="phone_number" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                            <input type="text" id="phone_number" name="phone_number" oninput="numberOnly(this.id);"  class="form-control" placeholder="081224343024" value="{{{ old('phone_number') }}}" required/>
                            @if($errors->has('phone_number'))
                            <small class="text-danger">{{ $errors->first('phone_number') }}</small>
                            @endif
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <label for="email" class="form-label">Alamat Email <span class="text-danger">*</span></label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="user@email.com" value="{{{ old('email') }}}" required/>
                            @if($errors->has('email'))
                            <small class="text-danger">{{ $errors->first('email') }}</small>
                            @endif
                        </div>

                        <div class="col-sm-12">
                            <h4>Informasi Covid-19</h4>
                        </div>

                        <div class="col-sm-12 col-md-4">
                            <label for="covid_status" class="form-label">Status covid-19 <span class="text-danger">*</span></label>
                            <select id="covid_status" name="covid_status" class="form-select" required>
                                <option value="never_infected" {{ old('covid_status') === 'never_infected' ? 'selected' : '' }}>Belum pernah terjangkit</option>
                                <option value="being_infected" {{ old('covid_status') === 'being_infected' ? 'selected' : '' }}>Sedang terjangkit</option>
                                <option value="been_infected" {{ old('covid_status') === 'been_infected' ? 'selected' : '' }}>Pernah terjangkit</option>
                            </select>
                        </div>

                        <div class="col-sm-12" id="covid_input_section">
                            
                        </div>

                        <div class="col-12 text-end">
                            <a href="{{ route('welcome') }}"><button type="button" class="btn btn-primary ">Kembali</button></a>
                            <button type="submit" class="btn btn-success ">Tambah Pasien</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script>
        const covid_status = $('#covid_status')
        const covid_input_section = $('#covid_input_section');

        const field_being_infected = `<div class="row g-2">
            <div class="col-sm-12 col-md-6">
                <label for="infected_date_start" class="form-label">Tgl Positif Covid <span class="text-danger">*</span></label>
                <input type="date" id="infected_date_start" name="infected_date_start" class="form-control" value="{{{ old('infected_date_start') }}}" required/>
            </div>

            <div class="col-sm-12 col-md-6">
                <label for="covid_infected_start" class="form-label">Hasil Test PCR/Antigen <span class="text-danger">*</span></label>
                <input type="file" name="covid_infected_start" id="covid_infected_start" class="form-control" required>
            </div>
        </div>`;

        const field_been_infected = `<div class="row g-2">
            <div class="col-sm-12 col-md-6">
                <label for="infected_date_start" class="form-label">Tgl Positif Covid <span class="text-danger">*</span></label>
                <input type="date" id="infected_date_start" name="infected_date_start" class="form-control" value="{{{ old('infected_date_start') }}}" required/>
            </div>

            <div class="col-sm-12 col-md-6">
                <label for="covid_infected_start" class="form-label">Hasil Test PCR/Antigen <span class="text-danger">*</span></label>
                <input type="file" name="covid_infected_start" id="covid_infected_start" class="form-control" required>
            </div>

            <div class="col-sm-12 col-md-6">
                <label for="infected_date_end" class="form-label">Tgl Sembuh Covid <span class="text-danger">*</span></label>
                <input type="date" id="infected_date_end" name="infected_date_end" class="form-control" value="{{{ old('infected_date_end') }}}" required/>
            </div>

            <div class="col-sm-12 col-md-6">
                <label for="covid_infected_end" class="form-label">Hasil Test PCR/Antigen <span class="text-danger">*</span></label>
                <input type="file" name="covid_infected_end" id="covid_infected_end" class="form-control" required>
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