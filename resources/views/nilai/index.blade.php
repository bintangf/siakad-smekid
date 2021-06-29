@extends('adminlte::page')

@section('title', 'Input Nilai')

@section('content_header')
<h1>Input Nilai</h1>
@stop

@section('plugins.Datatables', true)
@section('plugins.sweetalert2', true)

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <table class="table table-hover text-nowrap" id="datatable">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Nama Kelas</th>
                    <th>Mata Pelajaran</th>
                    @can('master')
                    <th>Nama Guru</th>
                    @endcan
                    <th>Aksi</th>
                </thead>
                <tbody>
                @php $i=1; @endphp
                @foreach ($kelas as $val => $data)
                @foreach ($data as $v => $d)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $data[$v][0]->kelas->nama_kelas }}</td>
                    <td>{{ $d[0]->mapel->nama_mapel }}</td>
                    @can('master')
                    <td>{{ $d[0]->guru->nama_guru }}</td>
                    @endcan
                    <td><a href="{{ route('nilai.show', Crypt::encrypt([$val, $v]) ) }}" class="btn btn-primary btn-sm"><i class="nav-icon fas fa-pen"></i> &nbsp; Entry Nilai</a></td>
                </tr>
                @endforeach
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
    </div>
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

