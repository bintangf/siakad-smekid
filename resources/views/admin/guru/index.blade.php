@extends('adminlte::page')

@section('title', 'Guru')

@section('content_header')
<h1>Guru</h1>
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
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".tambah-guru">
              <i class="nav-icon fas fa-folder-plus"></i> Tambah Guru
            </button>
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap" id="datatable">
                <thead>
                  <tr>
                    <th style="width: 5%;"> No </th>
                    <th> Mata Pelajaran </th>
                    <th style="width: 20%;"> Lihat Guru </th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($mapels as $mapel)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $mapel->nama_mapel }}</td>
                    <td>
                      <a href="{{ route('guru.mapel', Crypt::encrypt($mapel->id)) }}" class="btn btn-info btn-sm">
                        <i class="nav-icon fas fa-search-plus"></i> 
                        Details
                      </a>
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

<!-- tambah guru -->
<div class="modal fade bd-example-modal-md tambah-guru" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">Tambah Data Guru</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
          <form action="{{ route('guru.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nama_guru">Nama Guru</label>
                        <input type="text" id="nama_guru" name="nama_guru" class="form-control @error('nama_guru') is-invalid @enderror">
                    </div>
                    <div class="form-group">
                        <label for="tmp_lahir">Tempat Lahir</label>
                        <input type="text" id="tmp_lahir" name="tmp_lahir" class="form-control @error('tmp_lahir') is-invalid @enderror">
                    </div>
                    <div class="form-group">
                        <label for="jk">Jenis Kelamin</label>
                        <select id="jk" name="jk" class="select2bs4 form-control @error('jk') is-invalid @enderror">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="L">Laki-Laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nip">NIP</label>
                        <input type="text" id="nip" name="nip" onkeypress="return inputAngka(event)" class="form-control @error('nip') is-invalid @enderror">
                    </div>
                    <div class="form-group">
                        <label for="tgl_lahir">Tanggal Lahir</label>
                        <input type="date" id="tgl_lahir" name="tgl_lahir" class="form-control @error('tgl_lahir') is-invalid @enderror">
                    </div>
                    <div class="form-group">
                        <label for="telp">Nomor Telpon/HP</label>
                        <input type="text" id="telp" name="telp" onkeypress="return inputAngka(event)" class="form-control @error('telp') is-invalid @enderror">
                    </div>
                </div>
                <div class="col-md-12 after-add-more">
                  <div class="form-group">
                    <label for="mapel_id">Mata Pelajaran</label>
                      <div class="row">
                        <div class="col-md-10">
                          <select id="mapel_id[]" name="mapel_id[]" class="form-control @error('mapel_id.*') is-invalid @enderror">
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach ($mapels as $mapel)
                            <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="col-md-2">
                          <button class="btn btn-success add-more" type="button">
                            <i class="nav-icon fas fa-plus"></i>
                          </button>
                        </div>
                      </div>
                  </div>
                </div>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class='nav-icon fas fa-arrow-left'></i> &nbsp; Kembali</button>
              <button type="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp; Tambahkan</button>
          </form>

        <div class="copy invisible">
          <div class="col-md-12">
            <div class="form-group">
              <div class="row">
                <div class="col-md-10">
                  <select id="mapel_id[]" name="mapel_id[]" class="form-control @error('mapel_id.*') is-invalid @enderror">
                    <option value="">-- Pilih Mata Pelajaran --</option>
                    @foreach ($mapels as $mapel)
                    <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-2">
                  <button class="btn btn-danger remove" type="button">
                    <i class="nav-icon fas fa-trash"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
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

      //tambahkan kolom baru
      $(".add-more").click(function(){ 
          var html = $(".copy").html();
          $(".after-add-more").after(html);
      });
      // saat tombol remove dklik control group akan dihapus 
      $("body").on("click",".remove",function(){ 
          $(this).parents(".form-group").remove();
      });

      @if(Session::has('success'))
        Swal.fire(
          'Berhasil!',
          "{{ Session::get('success') }}",
          'success'
        );
      @endif

        $('#datatable').DataTable({
            dom: 'Bfrtip'
        });

    } );

</script>
@stop

