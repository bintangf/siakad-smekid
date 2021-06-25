@extends('adminlte::page')

@section('title', 'Nilai Rapor')

@section('content_header')
<h1>Nilai Rapor {{ $kelas->nama_kelas }}</h1>
@stop

@section('plugins.Datatables', true)

@section('content')
<div class="col-md-12">
    <!-- general form elements -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
            <a href="{{ route('rapor') }}" class="btn btn-default btn-sm"><i class="nav-icon fas fa-arrow-left"></i> &nbsp; Kembali</a>
        </h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <table id="datatable" class="table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Nama Siswa</th>
                  <th>No. Induk</th>
                  <th>Aksi</th>
              </thead>
              <tbody>
                @foreach ($siswa as $data)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data[0]->siswa->nama_siswa }}</td>
                    <td>{{ $data[0]->siswa->no_induk }}</td>
                    <td><a href="{{ route('rapor.detail', Crypt::encrypt($data[0]->siswa->id)) }}" class="btn btn-info btn-sm"><i class="nav-icon fas fa-search-plus"></i> &nbsp; Show Rapot</a></td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>
$(document).ready(function() {
    $('#datatable').DataTable({
        dom: 'Bfrtip'
    });
});
</script>
@stop

