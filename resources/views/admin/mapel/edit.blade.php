@extends('adminlte::page')

@section('title', 'Edit Mata Pelajaran')

@section('content_header')
<h1>Edit Mata Pelajaran</h1>
@stop

@section('plugins.sweetalert2', true)

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                    <div class="card-body">
                      <form action="{{ route('mapel.store') }}" method="post">
                        @csrf
                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="mapel_id" value="{{ $mapels->id }}">
                                <div class="form-group">
                                  <label for="nama_mapel">Nama Mapel</label>
                                  <input type="text" id="nama_mapel" name="nama_mapel" value="{{ $mapels->nama_mapel }}" class="form-control @error('nama_mapel') is-invalid @enderror" placeholder="{{ __('Nama Mata Pelajaran') }}">
                                </div>
                                <div class="form-group">
                                  <label for="jurusan_id">Jurusan</label>
                                  <select id="jurusan_id" name="jurusan_id" class="form-control @error('jurusan_id') is-invalid @enderror select2bs4">
                                    <option value="">-- Pilih Jurusan Mapel --</option>
                                    <option value="4"
                                        @if ($mapels->jurusan_id == '4')
                                            selected
                                        @endif
                                    >Semua</option>
                                    @foreach ($jurusans as $jurusan)
                                      <option value="{{ $jurusan->id }}"
                                        @if ($mapels->jurusan_id == $jurusan->id)
                                            selected
                                        @endif
                                      >{{ $jurusan->nama }}</option>
                                    @endforeach
                                  </select>
                                </div>
                                <div class="form-group">
                                    <label for="kelompok">Kelompok</label>
                                    <select id="kelompok" name="kelompok" class="select2bs4 form-control @error('kelompok') is-invalid @enderror">
                                        <option value="">-- Pilih Kelompok Mapel --</option>
                                        <option value="A"
                                            @if ($mapels->kelompok == 'A')
                                                selected
                                            @endif
                                        >Muatan Nasional</option>
                                        <option value="B"
                                            @if ($mapels->kelompok == 'B')
                                                selected
                                            @endif
                                        >Muatan Kewilayahan</option>
                                        <option value="C"
                                            @if ($mapels->kelompok == 'C')
                                                selected
                                            @endif
                                        >Muatan Kejuruhan</option>
                                    </select>
                                </div>
                            </div>
                          </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                          <a href="#" name="kembali" class="btn btn-default" id="back"><i class='nav-icon fas fa-arrow-left'></i> &nbsp; Kembali</a> &nbsp;
                          <button name="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp; Update</button>
                        </div>
                      </form>
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
      "Data Mata Pelajaran berhasil diedit!",
      'success'
    );
  @endif
  $('#back').click(function() {
    window.location="{{ route('mapel.index') }}";
  });
});

</script>
@stop
