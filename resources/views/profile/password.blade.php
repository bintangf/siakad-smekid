@extends('adminlte::page')

@section('title', 'Ubah Password')

@section('content_header')
<h1>Ubah Password</h1>
@stop

@section('plugins.sweetalert2', true)

@section('content')
<div class="col-md-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title text-capitalize">Ubah Password {{ Auth::user()->name }}</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form action="{{ route('pengaturan.ubah-password') }}" method="post">
        @csrf
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="password-old">Password Lama</label>
                    <input id="password-old" type="password" class="form-control" name="password_lama" autocomplete="old-password">
                </div> 
                <div class="form-group">
                    <label for="password">Password Baru</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                </div> 
                <div class="form-group">
                    <label for="password-confirm">Konfirmasi Password</label>
                    <input id="password-confirm" type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" autocomplete="new-password">
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
    <!-- /.card -->
</div>
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
    @if(Session::has('error'))
        Swal.fire(
            'Error!',
            "{{ Session::get('error') }}",
            'error'
        );
    @endif

    $('#back').click(function() {
        window.location="{{ route('profile') }}";
    });
});
</script>
@stop

