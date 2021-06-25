@extends('adminlte::page')

@section('title', 'Edit Profile')

@section('content_header')
<h1>Edit Profile</h1>
@stop

@section('content')
<div class="col-md-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title text-capitalize">Profile {{ Auth::user()->name }}</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form action="{{ route('pengaturan.ubah-profile') }}" method="post">
        @csrf
        <div class="card-body">
          @role('guru')
            <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                      <label for="name">Nama Guru</label>
                      <input type="text" id="name" name="name" value="{{ Auth::user()->name }}" class="form-control @error('name') is-invalid @enderror">
                  </div>
                  <div class="form-group">
                      <label for="tmp_lahir">Tempat Lahir</label>
                      <input type="text" id="tmp_lahir" name="tmp_lahir" value="{{ Auth::user()->guru->tmp_lahir }}" class="form-control @error('tmp_lahir') is-invalid @enderror">
                  </div>
                  <div class="form-group">
                      <label for="telp">Nomor Telpon/HP</label>
                      <input type="text" id="telp" name="telp" onkeypress="return inputAngka(event)" value="{{ Auth::user()->guru->telp }}" class="form-control @error('telp') is-invalid @enderror">
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                      <label for="nip">NIP</label>
                      <input type="text" id="nip" name="nip" onkeypress="return inputAngka(event)" value="{{ Auth::user()->guru->nip }}" class="form-control @error('nip') is-invalid @enderror" disabled>
                  </div>
                  <div class="form-group">
                      <label for="jk">Jenis Kelamin</label>
                      <select id="jk" name="jk" class="select2bs4 form-control @error('jk') is-invalid @enderror">
                          <option value="">-- Pilih Jenis Kelamin --</option>
                          <option value="L"
                              @if (Auth::user()->guru->jk == 'L')
                                  selected
                              @endif
                          >Laki-Laki</option>
                          <option value="P"
                              @if (Auth::user()->guru->jk == 'P')
                                  selected
                              @endif
                          >Perempuan</option>
                      </select>
                  </div>
                  <div class="form-group">
                      <label for="tgl_lahir">Tanggal Lahir</label>
                      <input type="date" id="tgl_lahir" name="tgl_lahir" value="{{ Auth::user()->guru->tgl_lahir }}" class="form-control @error('tgl_lahir') is-invalid @enderror">
                  </div>
              </div>
            </div>
          @else
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="name">Username</label>
                  <input id="name" type="text" value="{{ Auth::user()->name }}" class="form-control @error('name') is-invalid @enderror" name="name" autocomplete="off">
                </div>
              </div>
            </div>
          @endrole
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <a href="#" name="kembali" class="btn btn-default" id="back"><i class='nav-icon fas fa-arrow-left'></i> &nbsp; Kembali</a> &nbsp;
          <button name="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp; Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.card -->
</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        $('#back').click(function() {
            window.location="{{ route('profile') }}";
        });
    });
</script>
@stop

