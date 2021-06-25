@extends('adminlte::page')

@section('title', 'Mata Pelajaran')

@section('content_header')
<h1>Mata Pelajaran</h1>
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
                      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".tambah-mapel">
                          <i class="nav-icon fas fa-folder-plus"></i> &nbsp; Tambah Data Mapel
                      </button>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap" id="datatable">
                                <thead>
                                <tr>
                                    <th style="width: 5%;"> No </th>
                                    <th> Mata Pelajaran </th>
                                    <th> Jurusan </th>
                                    <th> Kelompok </th>
                                    <th style="width: 5%;"> Aksi </th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mapels as $mapel)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $mapel->nama_mapel }}</td>
                                        @if ( $mapel->jurusan_id == 4 )
                                          <td>{{ 'Semua' }}</td>
                                        @else
                                          <td>{{ $mapel->jurusan->nama }}</td>
                                        @endif

                                        @if ( $mapel->kelompok == 'A')
                                          <td>Muatan Nasional</td>
                                        @endif
                                        @if ( $mapel->kelompok == 'B')
                                          <td>Muatan Kewilayahan</td>
                                        @endif
                                        @if ( $mapel->kelompok == 'C')
                                          <td>Muatan Kejuruhan</td>
                                        @endif
                                        
                                        <td>
                                            <form action="{{ route('mapel.destroy', $mapel->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <a class="btn btn-success btn-sm" href="{{ route('mapel.edit', Crypt::encrypt($mapel->id)) }}" >
                                                  <span class="fas fa-edit"></span> Edit
                                                </a>
                                                <button class="btn btn-danger btn-sm">
                                                  <span class="fas fa-trash"></span> Hapus
                                                </button>
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

<!-- tambah mapel -->
<div class="modal fade bd-example-modal-md tambah-mapel" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">Tambah Data Mapel</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form action="{{ route('mapel.store') }}" method="post">
          @csrf
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="nama_mapel">Nama Mapel</label>
                  <input type="text" id="nama_mapel" name="nama_mapel" class="form-control @error('nama_mapel') is-invalid @enderror" placeholder="{{ __('Nama Mata Pelajaran') }}">
                </div>
                <div class="form-group">
                  <label for="jurusan_id">Jurusan</label>
                  <select id="jurusan_id" name="jurusan_id" class="form-control @error('jurusan_id') is-invalid @enderror select2bs4">
                    <option value="">-- Pilih Jurusan Mapel --</option>
                    <option value="4">Semua</option>
                    @foreach ($jurusans as $jurusan)
                      <option value="{{ $jurusan->id }}">{{ $jurusan->nama }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                    <label for="kelompok">Kelompok</label>
                    <select id="kelompok" name="kelompok" class="select2bs4 form-control @error('kelompok') is-invalid @enderror">
                      <option value="">-- Pilih Kelompok Mapel --</option>
                      <option value="A">Muatan Nasional</option>
                      <option value="B">Muatan Kewilayahan</option>
                      <option value="C">Muatan Kejuruhan</option>
                    </select>
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

    } );

</script>
@stop

