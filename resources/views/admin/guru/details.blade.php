@extends('adminlte::page')

@section('title', 'Detail Guru')

@section('content_header')
<h1>Detail Guru</h1>
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
                      <h5 class="card-title card-text mb-2">Nama : {{ $guru->nama_guru }}</h5>
                      <h5 class="card-title card-text mb-2">NIP : {{ $guru->nip }}</h5>
                      @if ($guru->jk == 'L')
                      <h5 class="card-title card-text mb-2">Jenis Kelamin : Laki-laki</h5>
                      @else
                      <h5 class="card-title card-text mb-2">Jenis Kelamin : Perempuan</h5>
                      @endif
                      <h5 class="card-title card-text mb-2">Tempat Lahir : {{ $guru->tmp_lahir }}</h5>
                      <h5 class="card-title card-text mb-2">Tanggal Lahir : {{ date('l, d F Y', strtotime($guru->tgl_lahir)) }}</h5>
                      <h5 class="card-title card-text mb-2">No. Telepon : {{ $guru->telp }}</h5>
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

