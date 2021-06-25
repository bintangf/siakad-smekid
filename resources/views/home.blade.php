@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')

    <!-- tabel jadwal hari ini -->
    <div class="col-md-12">
      <div class="card card-primary">
        <div class="card-body">
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th>Jam Pelajaran</th>
                    <th>Mata Pelajaran</th>
                    <th>Kelas</th>
                  </tr>
                </thead>
                <tbody>
                @if ( $tabeljadwal->count() > 0 )
                @foreach ($tabeljadwal as $data)
                <tr>
                    <td>{{ date('H:i', strtotime($data->jam_mulai)).' - '.date('H:i', strtotime($data->jam_selesai)) }}</td>
                    <td>
                        <h5 class="card-title">{{ $data->mapel->nama_mapel }}</h5>
                        <p class="card-text"><small class="text-muted">{{ $data->guru->nama_guru }}</small></p>
                    </td>
                    <td>{{ $data->kelas->nama_kelas }}</td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan='3' style='background:#fff;text-align:center;font-weight:bold;font-size:18px;'>Tidak Ada Data Jadwal!</td>
                  </tr>
                @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>

    @role('admin|operator')
    <div class="row">
        <div class="col-lg-4 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $jadwal }}</h3>
                    <p>Jadwal</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-alt nav-icon"></i>
                </div>
                <a href="{{ route('jadwal.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-warning">
                <div class="inner" style="color: #FFFFFF;">
                    <h3>{{ $guru }}</h3>
                    <p>Guru</p>
                </div>
                <div class="icon">
                    <i class="fas fa-id-card nav-icon"></i>
                </div>
                <a href="{{ route('guru.index') }}" style="color: #FFFFFF !important;" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $siswa }}</h3>
                    <p>Siswa</p>
                </div>
                <div class="icon">
                    <i class="fas fa-id-card nav-icon"></i>
                </div>
                <a href="{{ route('siswa.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $kelas }}</h3>
                    <p>Kelas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-home nav-icon"></i>
                </div>
                <a href="{{ route('kelas.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $mapel }}</h3>
                    <p>Mapel</p>
                </div>
                <div class="icon">
                    <i class="fas fa-book nav-icon"></i>
                </div>
                <a href="{{ route('mapel.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $user }}</h3>
                    <p>User Registrations</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-plus nav-icon"></i>
                </div>
                <a href="{{ route('user.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    @endrole
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>
</script>
@stop

