@extends('adminlte::page')

@section('title', 'Detail Jadwal')

@section('content_header')
<h1>Detail Jadwal {{ $kelas->nama_kelas }}</h1>
@stop

@section('plugins.Datatables', true)
@section('plugins.datatablesPlugins', true)
@section('plugins.sweetalert2', true)

@section('content')
<section class="content">
  <div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <a onclick="goBack()" class="btn btn-default btn-sm mb-2"><i class='nav-icon fas fa-arrow-left'></i> Kembali</a>
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap" id="datatable">
            <thead>
                <tr>
                    <th style="width: 5%;">No.</th>
                    <th>Hari</th>
                    <th>Jadwal</th>
                    <th>Jam Pelajaran</th>
                    <th style="width: 5%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jadwals as $jadwal)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $jadwal->hari->nama_hari }}</td>
                    <td>
                        <h5 class="card-title">{{ $jadwal->mapel->nama_mapel }}</h5>
                        <p class="card-text"><small class="text-muted">{{ $jadwal->guru->nama_guru }}</small></p>
                    </td>
                    <td>{{ date('H:i', strtotime($jadwal->jam_mulai)).' - '.date('H:i', strtotime($jadwal->jam_selesai)) }}</td>
                    <td>
                      <form action="{{ route('jadwal.destroy', $jadwal->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <a href="{{ route('jadwal.edit',Crypt::encrypt($jadwal->id)) }}" class="btn btn-success btn-sm"><i class="nav-icon fas fa-edit"></i> &nbsp; Edit</a>
                        <button class="btn btn-danger btn-sm"><i class="nav-icon fas fa-trash-alt"></i> &nbsp; Hapus</button>
                      </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
              </table>
            </div>
        </div>
      </div>
    </div>
  </div>
</section>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>

function goBack() {
  window.history.back();
}

$(document).ready(function(){
  @if(Session::has('success'))
  Swal.fire(
    'Berhasil!',
    "{{ Session::get('success') }}",
    'success'
    );
  @endif
  @if(Session::has('warning'))
  Swal.fire(
    'Berhasil!',
    "{{ Session::get('warning') }}",
    'warning'
    );
  @endif

    $('#datatable').DataTable({
        dom: 'Bfrtip',
        buttons: [
      'copy', 'csv', 'excel', 'pdf'
        ]
    });
});

</script>
@stop
