@extends('adminlte::page')

@section('title', 'Data User')

@section('content_header')
<h1>Data User {{ $role[0]->name }}</h1>
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
          <a onclick="goBack()" class="btn btn-default btn-sm"><i class='nav-icon fas fa-arrow-left'></i> Kembali</a>
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap" id="datatable">
              <thead>
                  <tr>
                      <th  style="width: 5%;">No.</th>
                      <th>Username</th>
                      <th>Email</th>
                      @if ($role[0]->name == 'Guru')
                        <th>No Induk Pegawai</th>
                      @elseif ($role[0]->name == 'Siswa')
                        <th>No Induk Siswa</th>
                      @else
                            
                      @endif
                      {{-- <th>Tanggal Register</th> --}}
                      <th style="width: 10%;">Aksi</th>
                  </tr>
              </thead>
              <tbody>
                @if ($role[0]->users->count() > 0)
                  @foreach ($role[0]->users as $user)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $user->name }}</td>
                      <td>{{ $user->email }}</td>
                      @if ($role[0]->name == 'Siswa')
                        <td>{{ $user->no_induk }}</td>
                      @elseif ($role[0]->name == 'Guru')
                        <td>{{ $user->nip }}</td>
                      @else
                      @endif
                      {{-- <td>{{ $user->created_at->format('l, d F Y') }}</td> --}}
                      <td>
                        <form action="{{ route('user.destroy', $user->id) }}" method="post">
                          @csrf
                          @method('delete')
                          <button class="btn btn-danger btn-sm"><i class="nav-icon fas fa-trash-alt"></i> &nbsp; Hapus</button>
                        </form>
                      </td>
                    </tr>
                  @endforeach
                @else
                  <tr>
                    <td colspan='5' style='background:#fff;text-align:center;font-weight:bold;font-size:18px;'>Silahkan Buat Akun Terlebih Dahulu!</td>
                  </tr>
                @endif
              </tbody>
              </table>
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

$(document).ready(function(){
  @if(Session::has('warning'))
  Swal.fire(
    'Berhasil!',
    "{{ Session::get('warning') }}",
    'warning'
    );
  @endif
  @if(Session::has('error'))
  Swal.fire(
    'Berhasil!',
    "{{ Session::get('error') }}",
    'error'
    );
  @endif

  $('#datatable').DataTable({
    dom: 'Bfrtip'
  });
});

</script>
@stop

