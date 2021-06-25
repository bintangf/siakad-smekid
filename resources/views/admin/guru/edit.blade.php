@extends('adminlte::page')

@section('title', 'Edit Guru')

@section('content_header')
<h1>Edit Guru</h1>
@stop

@section('plugins.sweetalert2', true)

@section('content')
<section class="content">
  <div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
      <form action="{{ route('guru.update', $guru->id) }}" method="post">
        @csrf
        @method('patch')
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nama_guru">Nama Guru</label>
                    <input type="text" id="nama_guru" name="nama_guru" value="{{ $guru->nama_guru }}" class="form-control @error('nama_guru') is-invalid @enderror">
                </div>
                <div class="form-group">
                    <label for="tmp_lahir">Tempat Lahir</label>
                    <input type="text" id="tmp_lahir" name="tmp_lahir" value="{{ $guru->tmp_lahir }}" class="form-control @error('tmp_lahir') is-invalid @enderror">
                </div>
                <div class="form-group">
                    <label for="telp">Nomor Telpon/HP</label>
                    <input type="text" id="telp" name="telp" onkeypress="return inputAngka(event)" value="{{ $guru->telp }}" class="form-control @error('telp') is-invalid @enderror">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nip">NIP</label>
                    <input type="text" id="nip" name="nip" onkeypress="return inputAngka(event)" value="{{ $guru->nip }}" class="form-control @error('nip') is-invalid @enderror" disabled>
                </div>
                <div class="form-group">
                    <label for="jk">Jenis Kelamin</label>
                    <select id="jk" name="jk" class="select2bs4 form-control @error('jk') is-invalid @enderror">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L"
                            @if ($guru->jk == 'L')
                                selected
                            @endif
                        >Laki-Laki</option>
                        <option value="P"
                            @if ($guru->jk == 'P')
                                selected
                            @endif
                        >Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tgl_lahir">Tanggal Lahir</label>
                    <input type="date" id="tgl_lahir" name="tgl_lahir" value="{{ $guru->tgl_lahir }}" class="form-control @error('tgl_lahir') is-invalid @enderror">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="mapel_id">Mapel</label>
                    <?php $i = 0 ?>
                    @foreach ($guru->mapel as $mapel_guru)
                    <div class="row mb-3 hapus">
                      <div class="col-md-10">
                        <select id="mapel_id[]" name="mapel_id[]" class="select2bs4 form-control @error('mapel_id') is-invalid @enderror">
                            <option value="">-- Pilih Mapel --</option>
                            @foreach ($mapels as $mapel)
                                <option value="{{ $mapel->id }}"
                                    @if ($mapel_guru->id == $mapel->id)
                                        selected
                                    @endif
                                >{{ $mapel->nama_mapel }}</option>
                            @endforeach
                        </select>
                      </div>
                      <?php if ($i == 0){ ?>
                      <div class="col-md-2">
                        <button class="btn btn-success add-more" type="button">
                          <i class="nav-icon fas fa-plus"></i>
                        </button>
                      </div>
                      <?php }else{ ?>
                      <div class="col-md-2">
                        <button class="btn btn-danger remove" type="button">
                          <i class="nav-icon fas fa-trash"></i>
                        </button>
                      </div>
                      <?php } ?>
                    </div>
                    <?php $i++ ?>
                    @endforeach
                    <div class="after-add-more"></div>
                </div>
            </div>
          </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <a onclick="goBack()" class="btn btn-default"><i class='nav-icon fas fa-arrow-left'></i> Kembali</a>
          <button name="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp; Simpan</button>
        </div>
      </form>
      </div>
    </div>
  </div>

  <div class="copy invisible">
    <div class="row mb-3 hapus">
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
    $(document).ready(function() {
      
      //tambahkan kolom baru
      $(".add-more").click(function(){ 
          var html = $(".copy").html();
          $(".after-add-more").after(html);
      });
      // saat tombol remove dklik control group akan dihapus 
      $("body").on("click",".remove",function(){ 
          $(this).parents(".hapus").remove();
      });

      @if(Session::has('success'))
        Swal.fire(
          'Berhasil!',
          "{{ Session::get('success') }}",
          'success'
        );
        Session::flush();
      @endif

    } );

</script>
@stop

