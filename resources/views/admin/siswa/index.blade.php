@extends('adminlte::page')

@section('title', 'Siswa')

@section('content_header')
<h1>Siswa</h1>
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
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".tambah-siswa">
              <i class="nav-icon fas fa-folder-plus"></i> Tambah Siswa
            </button>
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target=".import-siswa">
              <i class="nav-icon fas fa-file-import"></i> Import Siswa
            </button>
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap" id="datatable">
                <thead>
                  <tr>
                    <th style="width: 5%;"> No </th>
                    <th> Kelas </th>
                    <th style="width: 20%;"> Aksi </th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($kelas as $kel)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $kel->nama_kelas }}</td>
                    <td>
                      <a href="{{ route('siswa.kelas', Crypt::encrypt($kel->id)) }}" class="btn btn-info btn-sm">
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

<!-- tambah siswa -->
<div class="modal fade bd-example-modal-lg tambah-siswa" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title">Tambah Data Siswa</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
          <form action="{{ route('siswa.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="no_induk">Nomor Induk</label>
                        <input type="text" id="no_induk" name="no_induk" onkeypress="return inputAngka(event)" class="form-control @error('no_induk') is-invalid @enderror">
                    </div>
                    <div class="form-group">
                        <label for="nama_siswa">Nama Siswa</label>
                        <input type="text" id="nama_siswa" name="nama_siswa" class="form-control @error('nama_siswa') is-invalid @enderror">
                    </div>
                    <div class="form-group">
                        <label for="jk">Jenis Kelamin</label>
                        <select id="jk" name="jk" class="select2bs4 form-control @error('jk') is-invalid @enderror">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="L">Laki-Laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tmp_lahir">Tempat Lahir</label>
                        <input type="text" id="tmp_lahir" name="tmp_lahir" class="form-control @error('tmp_lahir') is-invalid @enderror">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nis">NIS</label>
                        <input type="text" id="nis" name="nis" onkeypress="return inputAngka(event)" class="form-control @error('nis') is-invalid @enderror">
                    </div>
                    <div class="form-group">
                        <label for="kelas_id">Kelas</label>
                        <select id="kelas_id" name="kelas_id" class="select2bs4 form-control @error('kelas_id') is-invalid @enderror">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach ($kelas as $data)
                                <option value="{{ $data->id }}">{{ $data->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="telp">Nomor Telpon/HP</label>
                        <input type="text" id="telp" name="telp" onkeypress="return inputAngka(event)" class="form-control @error('telp') is-invalid @enderror">
                    </div>
                    <div class="form-group">
                        <label for="tgl_lahir">Tanggal Lahir</label>
                        <input type="date" id="tgl_lahir" name="tgl_lahir" class="form-control @error('tgl_lahir') is-invalid @enderror">
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

<!-- import siswa -->
<div class="modal fade bd-example-modal-lg import-siswa" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title">Import Data Siswa</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
          <form action="{{ route('siswa.import_excel') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card card-outline card-primary">
              <div class="card-header">
                <h5 class="modal-title">Petunjuk :</h5>
              </div>
              <div class="card-body">
                <ul>
                  <li>rows 1 = No Induk Siswa</li>
                  <li>rows 2 = Nama Siswa</li>
                  <li>rows 3 = Jenis Kelamin(L/P)</li>
                  <li>rows 4 = Nama Kelas</li>
                </ul>
              </div>
            </div>
            <label>Pilih file excel</label>
              <div class="form-group">
                <input type="file" name="file" required="required">
              </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Import</button>
            </div>
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

