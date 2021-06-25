@extends('adminlte::page')

@section('title', 'Data User')

@section('content_header')
<h1>Data User</h1>
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
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".tambah-user">
              <i class="nav-icon fas fa-folder-plus"></i> Tambah User
            </button>
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap" id="datatable">
                <thead>
                  <tr>
                    <th> Level User </th>
                    <th> Jumlah User </th>
                    <th style="width: 10%;"> Lihat User </th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($roles as $role)
                    @if ($role->users->count() > 0)
                    <tr>
                      <td>{{ ucfirst(trans($role->name)) }}</td>
                      <td>{{ $role->users->count() }}</td>
                      <td>
                        <a href="{{ route('user.show', Crypt::encrypt($role->id)) }}" class="btn btn-info btn-sm">
                          <i class="nav-icon fas fa-search-plus"></i> 
                          Details
                        </a>
                      </td>
                    </tr>
                    @endif
                  @endforeach
                </tbody>
              </table>
            </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- modal tambah user -->
<div class="modal fade bd-example-modal-md tambah-user" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">Tambah Data User</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form action="{{ route('user.store') }}" method="post">
          @csrf
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="email">E-Mail Address</label>
                  <input id="email" type="email" placeholder="{{ __('E-Mail Address') }}" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email">
                  @error('email')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="role">Level User</label>
                  <select id="role" type="text" class="form-control @error('role') is-invalid @enderror select2bs4" name="role" value="{{ old('role') }}" autocomplete="role">
                    <option value="">-- Select {{ __('Level User') }} --</option>
                    <option value="Admin">Admin</option>
                    <option value="Operator">Operator</option>
                    <option value="Guru">Guru</option>
                    <!-- <option value="Siswa">Siswa</option> -->
                  </select>
                  @error('role')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="form-group" id="noId">
                </div>
                <div class="form-group">
                  <label for="password">Password</label>
                  <input id="password" type="password" placeholder="{{ __('Password') }}" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                  @error('password')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="password-confirm">Confirm Password</label>
                  <input id="password-confirm" type="password" placeholder="{{ __('Confirm Password') }}" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" autocomplete="new-password">
                  @error('password')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class='nav-icon fas fa-arrow-left'></i> &nbsp; Kembali</button>
            <button type="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp; Tambahkan</button>
        </form>
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
        $('#role').change(function(){
            var kel = $('#role option:selected').val();
            if (kel == "Guru") {
              $("#noId").html('<label for="nomer">Nomer Induk Pegawai</label><input id="nomer" type="text" maxlength="5" onkeypress="return inputAngka(event)" placeholder="NIP" class="form-control" name="nomer" autocomplete="off">');
            } else if(kel == "Siswa") {
              $("#noId").html(`<label for="nomer">Nomer Induk Siswa</label><input id="nomer" type="text" placeholder="No Induk Siswa" class="form-control" name="nomer" autocomplete="off">`);
            } else if(kel == "Admin" || kel == "Operator") {
              $("#noId").html(`<label for="name">Username</label><input id="name" type="text" placeholder="Username" class="form-control" name="name" autocomplete="off">`);
            } else {
              $("#noId").html("")
            }
        });

      @if(Session::has('success'))
        Swal.fire(
          'Berhasil!',
          "{{ Session::get('success') }}",
          'success'
        );
      @endif
      @if(Session::has('error'))
        Swal.fire(
          'Gagal!',
          "{{ Session::get('error') }}",
          'error'
        );
      @endif
      @if(Session::has('warning'))
      Swal.fire(
        'Perhatikan!',
        "{{ Session::get('warning') }}",
        'warning'
        );
      @endif

        $('#datatable').DataTable({
            dom: 'Bfrtip'
        });

    } );

</script>
@stop

