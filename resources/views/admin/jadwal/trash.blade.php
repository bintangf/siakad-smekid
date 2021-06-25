@extends('adminlte::page')

@section('title', 'Trash Jadwal')

@section('content_header')
<h1>Trash Jadwal</h1>
@stop

@section('plugins.Datatables', true)
@section('plugins.sweetalert2', true)

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                    <div class="card-body">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap" id="datatable">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">No.</th>
                                        <th>Hari</th>
                                        <th>Jadwal</th>
                                        <th>Kelas</th>
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
                                        <td>{{ $jadwal->kelas->nama_kelas }}</td>
                                        <td>{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</td>
                                        <td>
                                            <form action="{{ route('jadwal.kill', $jadwal->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <a href="{{ route('jadwal.restore', Crypt::encrypt($jadwal->id)) }}" class="btn btn-success btn-sm mt-2"><i class="nav-icon fas fa-undo"></i> &nbsp; Restore</a>
                                                <button class="btn btn-danger btn-sm mt-2"><i class="nav-icon fas fa-trash-alt"></i> &nbsp; Hapus</button>
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
    $(document).ready(function() {

      @if(Session::has('success'))
        Swal.fire(
          'Berhasil!',
          "{{ Session::get('success') }}",
          'success'
        );
      @endif
      @if(Session::has('info'))
        Swal.fire(
          'Berhasil!',
          "{{ Session::get('info') }}",
          'warning'
        );
      @endif

        $('#datatable').DataTable({
            dom: 'Bfrtip'
        });

    } );

</script>
@stop

