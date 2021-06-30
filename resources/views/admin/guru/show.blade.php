@extends('adminlte::page')

@section('title', 'Data Guru')

@section('content_header')
<h1>Data Guru {{ $mapel->nama_mapel }}</h1>
@stop

@section('plugins.Datatables', true)
@section('plugins.datatablesPlugins', true)
@section('plugins.sweetalert2', true)

@section('content')
<section class="content">
  <div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <a onclick="goBack()" class="btn btn-default btn-sm  mb-2"><i class='nav-icon fas fa-arrow-left'></i> Kembali</a>
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap" id="datatable">
                <thead>
                  <tr>
                    <th style="width: 5%;"> No </th>
                    <th> Nama </th>
                    <th> NIP </th>
                    <th style="width: 5%;"> Aksi </th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($gurus as $guru)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $guru->nama_guru }}</td>
                    <td>{{ $guru->nip }}</td>
                    <td>
                        <form action="{{ route('guru.destroy', $guru->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <a href="{{ route('guru.show', Crypt::encrypt($guru->id)) }}" class="btn btn-info btn-sm mt-2"><i class="nav-icon fas fa-id-card"></i> Detail</a>
                            <a href="{{ route('guru.edit', Crypt::encrypt($guru->id)) }}" class="btn btn-success btn-sm mt-2"><i class="nav-icon fas fa-edit"></i> Edit</a>
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
        dom: 'Bfrtip',
        buttons: [
          'copy', 'csv', 'excel', 'pdf'
        ]
    });
});

</script>
@stop

