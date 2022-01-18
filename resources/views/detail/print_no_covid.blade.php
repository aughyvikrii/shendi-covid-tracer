<!DOCTYPE html>
<html>
<head>
	<title>Laporan Covid-19</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}

        .page-break {
            page-break-after: always;
        }
	</style>
</head>
<body>
    <center>
        <h2><b>Laporan Covid-19</b></h2>
    </center>
    <hr>

    <dl>
        <dt class="col-sm-12 col-md-3">NIK</dt>
        <dd class="col-sm-12 col-md-9">{{$patient->nik}}</dd>

        <dt class="col-sm-12 col-md-3">Nama Lengkap</dt>
        <dd class="col-sm-12 col-md-9">{{$patient->name}}</dd>

        <dt class="col-sm-12 col-md-3">TTL</dt>
        <dd class="col-sm-12 col-md-9">{{$patient->place_of_birth}}, {{ \Carbon\Carbon::parse($patient->date_of_birth)->translatedFormat('d F Y') }}</dd>
        
        <dt class="col-sm-12 col-md-3">Alamat</dt>
        <dd class="col-sm-12 col-md-9">{{ $patient->address }}</dd>
        
        <dt class="col-sm-12 col-md-3">Kontak</dt>
        <dd class="col-sm-12 col-md-9">{{ $patient->phone_number }} | {{ $patient->email }}</dd>
        
        <dt class="col-sm-12 col-md-3">Agama</dt>
        <dd class="col-sm-12 col-md-9">{{ @$patient->religion->name ?: '-' }}</dd>
        
        <dt class="col-sm-12 col-md-3">Golongan Darah</dt>
        <dd class="col-sm-12 col-md-9">{{ @$patient->blood_type->name ?: '-' }}</dd>
        
        <dt class="col-sm-12 col-md-3">Status</dt>
        <dd class="col-sm-12 col-md-9">{{ @$patient->marital_status->name ?: '-' }}</dd>
        
        <dt class="col-sm-12 col-md-3">Jenis Kelamin</dt>
        <dd class="col-sm-12 col-md-9">{{ @$patient->gender->name ?: '-' }}</dd>
        
        <dt class="col-sm-12 col-md-3">Tgl Ditambah</dt>
        <dd class="col-sm-12 col-md-9">{{ _date_format($patient->created_at, 'l, d F Y - H:i') }}</dd>

        <dt class="col-sm-12 col-md-3">Status Covid-19</dt>
        <dd class="col-sm-12 col-md-9">
            @switch($patient->covid_status)
                @case('never_infected')
                    <span class="badge badge-success">Tidak Pernah Terjangkit</span>
                    @break
                @case('being_infected')
                    <span class="badge badge-danger">Sedang Terjangkit</span>
                    @break
                @case('been_infected')
                    <span class="badge badge-warning">Pernah Terjangkit</span>
                    <span class="badge badge-success">Sudah Sembuh</span>
                    @break
                @default
                    <span class="badge badge-success">Tidak Pernah Terjangkit</span>
            @endswitch
        </dd>

    </dl>

</body>
</html>