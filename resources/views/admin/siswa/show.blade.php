@extends('adminlte::page')

@section('title', 'Data Siswa')

@section('content_header')
<h1>Data Siswa {{ $kelas->nama_kelas }}</h1>
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
                    <th style="width: 5%;"> No </th>
                    <th>Nama Siswa</th>
                    <th>No Induk</th>
                    <th style="width: 5%;"> Aksi </th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($siswas as $siswa)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $siswa->nama_siswa }}</td>
                    <td>{{ $siswa->no_induk }}</td>
                    <td>
                        <form action="{{ route('siswa.destroy', $siswa->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <a href="{{ route('siswa.show', Crypt::encrypt($siswa->id)) }}" class="btn btn-info btn-sm mt-2"><i class="nav-icon fas fa-id-card"></i> Detail</a>
                            <a href="{{ route('siswa.edit', Crypt::encrypt($siswa->id)) }}" class="btn btn-success btn-sm mt-2"><i class="nav-icon fas fa-edit"></i> Edit</a>
                            <button class="btn btn-danger btn-sm mt-2"><i class="nav-icon fas fa-trash-alt"></i> Hapus</button>
                        </form>
                    </td>
                  </tr>
                  @endforeach
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
  @if(Session::has('success'))
  Swal.fire(
    'Berhasil!',
    "{{ Session::get('success') }}",
    'success'
    );
  @endif
  @if(Session::has('warning'))
  Swal.fire(
    'Berhasil!',
    "{{ Session::get('warning') }}",
    'warning'
    );
  @endif

  $('#datatable').DataTable({
    dom: 'Bfrtip'
  });
});

</script>
@stop

