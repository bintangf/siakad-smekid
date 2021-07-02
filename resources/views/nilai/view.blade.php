@extends('adminlte::page')

@section('title', 'Lihat Nilai')

@section('content_header')
<h1>Lihat Nilai</h1>
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
                    <th>Tahun Pelajaran Semester</th>
                    @can('master')
                    <th>Nama Guru</th>
                    @endcan
                    <th>Aksi</th>
                </thead>
                <tbody>
                @php $i=1; @endphp
                @foreach ($kelas as $kel)
                @foreach ($kel as $val => $data)
                  @foreach ($data as $v => $d)
                  <tr>
                      <td>{{ $i++ }}</td>
                      <td>{{ $data[$v][0]->kelas->nama_kelas }}</td>
                      <td>{{ $d[0]->mapel->nama_mapel }}</td>
                      <td>{{ $d[0]->tahun_semester }}</td>
                      @can('master')
                      <td>{{ $d[0]->guru->nama_guru }}</td>
                      @endcan
                      @role('wali kelas')
                        @if(Auth::user()->guru->id == $data[$v][0]->kelas->guru_id)
                        <td><a href="{{ route('nilai.detail', Crypt::encrypt([$val, $d[0]->guru->id, $v, $d[0]->tahun_semester]) ) }}" class="btn btn-primary btn-sm"><i class="nav-icon fas fa-sign-in-alt"></i> &nbsp; Approve Nilai</a></td>
                        @else
                        <td><a href="{{ route('nilai.detail', Crypt::encrypt([$val, $d[0]->guru->id, $v, $d[0]->tahun_semester]) ) }}" class="btn btn-primary btn-sm"><i class="nav-icon fas fa-search-plus"></i> &nbsp; Details Nilai</a></td>
                        @endif
                      @else
                        <td><a href="{{ route('nilai.detail', Crypt::encrypt([$val, $d[0]->guru->id, $v, $d[0]->tahun_semester]) ) }}" class="btn btn-primary btn-sm"><i class="nav-icon fas fa-search-plus"></i> &nbsp; Details Nilai</a></td>
                      @endrole
                  </tr>
                  @endforeach
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

