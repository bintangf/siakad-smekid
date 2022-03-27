@extends('adminlte::page')

@section('title', 'Tagihan')

@section('content_header')
<h1>Tagihan</h1>
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
            <button type="button" class="btn btn-primary btn-sm mb-2" data-toggle="modal" onclick="getCreateTagihan()" data-target="#form-tagihan">
              <i class="nav-icon fas fa-folder-plus"></i> Tambah Tagihan
            </button>
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap" id="datatable">
                <thead>
                  <tr>
                    <th style="width: 5%;"> No</th>
                    <th>Nama Tagihan</th>
                    <th>Nominal</th>
                    <th>Keterangan</th>
                    <th style="width: 5%;"> Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($tagihan as $tag)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $tag->nama }}</td>
                    <td>{{ $tag->jumlah }}</td>
                    @if (  $tag->keterangan == null)
                      <td>-</td>
                    @else
                      <td>{{ $tag->keterangan }}</td>
                    @endif
                    <td>
                        <form action="{{ route('tagihan.destroy', $tag->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="button" class="btn btn-success btn-sm" onclick="getEditTagihan({{$tag->id}})" data-toggle="modal" data-target="#form-tagihan">
                              <i class="nav-icon fas fa-edit"></i> &nbsp; Edit
                            </button>
                            <button class="btn btn-danger btn-sm"><i class="nav-icon fas fa-trash-alt"></i> &nbsp; Hapus</button>
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
  </div>
</section>

<!-- modal form tagihan -->
<div class="modal fade bd-example-modal-md" id="form-tagihan" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title" id="judul"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('tagihan.store') }}" method="post">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <input type="hidden" id="id" name="id">
              <div class="form-group" id="form_nama">
                <label for="nama">Nama Tagihan</label>
                <input type='text' id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="{{ __('Nama Tagihan') }}">
              </div>
              <div class="form-group" id="form_nominal">
                <label for="jumlah">Jumlah Nominal</label>
                <input type='number' id="jumlah" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror" placeholder="{{ __('100000') }}">
              </div>
              <div class="form-group" id="form_keterangan">
                <label for="keterangan">Keterangan</label>
                <input type='text' id="keterangan" name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" placeholder="{{ __('Khusus untuk siswa kelas XII') }}">
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class='nav-icon fas fa-arrow-left'></i> &nbsp; Kembali</button>
              <button type="submit" class="btn btn-primary simpan"><i class="nav-icon fas fa-save"></i> &nbsp; Tambahkan</button>
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

    function getCreateTagihan(){
      $("#judul").text('Tambah Data Tagihan');
      $('#id').val('');
      $('.simpan').html('<i class="nav-icon fas fa-save"></i> &nbsp; Tambahkan');
    }

    function getEditTagihan(id){
      var parent = id;
      $.ajax({
        type:"GET",
        data:"id="+parent,
        dataType:"JSON",
        url:"{{ url('/tagihan/edit/json') }}",
        success:function(result){
          if(result){
            $.each(result,function(index, val){
              $("#judul").text('Edit Data Tagihan ' + val.nama);
              $('#id').val(val.id);
              $('#nama').val(val.nama);
              $('#jumlah').val(val.jumlah);
              $("#keterangan").val(val.keterangan);
              $('.simpan').html('<i class="nav-icon fas fa-save"></i> &nbsp; Simpan');

            });
          }
        },
        error:function(){
          alert("Errors 404!");
        },
        complete:function(){
        }
      });
    }

    $(document).ready(function() {

      @if(Session::has('success'))
        Swal.fire(
          'Berhasil!',
          "{{ Session::get('success') }}",
          'success'
        );
      @endif

      $('#datatable').DataTable({
      });
    });

</script>
@stop

