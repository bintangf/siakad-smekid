@extends('adminlte::page')

@section('title', 'Detail Siswa')

@section('content_header')
<h1>Detail Siswa</h1>
@stop

@section('content')
<section class="content">
  <div class="container-fluid">
  <div class="row">
  <div class="col-md-12">
      <div class="card">
          <div class="card-header">
              <a onclick="goBack()" class="btn btn-default btn-sm"><i class='nav-icon fas fa-arrow-left'></i> Kembali</a>
          </div>
          <div class="card-body">
              <div class="row no-gutters ml-2 mb-2 mr-2">
                  <div class="col-md-7">
                      <h5 class="card-title card-text mb-2">Nama : {{ $siswa->nama_siswa }}</h5>
                      <h5 class="card-title card-text mb-2">No Induk : {{ $siswa->no_induk }}</h5>
                      @if ($siswa->jk == 'L')
                      <h5 class="card-title card-text mb-2">Jenis Kelamin : Laki-laki</h5>
                      @else
                      <h5 class="card-title card-text mb-2">Jenis Kelamin : Perempuan</h5>
                      @endif
                      <h5 class="card-title card-text mb-2">Tempat Lahir : {{ $siswa->tmp_lahir }}</h5>
                      <h5 class="card-title card-text mb-2">Tanggal Lahir : {{ date('l, d F Y', strtotime($siswa->tgl_lahir)) }}</h5>
                      <h5 class="card-title card-text mb-2">No. Telepon : {{ $siswa->telp }}</h5>
                  </div>
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
</script>
@stop

