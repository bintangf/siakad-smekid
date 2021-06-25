@extends('adminlte::page')

@section('title', 'Ubah Email')

@section('content_header')
<h1>Ubah Email</h1>
@stop

@section('plugins.sweetalert2', true)

@section('content')
<div class="col-md-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title text-capitalize">Ubah Email {{ Auth::user()->name }}</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form action="{{ route('pengaturan.ubah-email') }}" method="post">
        @csrf
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="email-old">Email Lama</label>
                    <input id="email-old" type="email" class="form-control" value="{{ Auth::user()->email }}" disabled>
                </div> 
                <div class="form-group">
                    <label for="email">Email Baru</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" autofocus autocomplete="off">
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

