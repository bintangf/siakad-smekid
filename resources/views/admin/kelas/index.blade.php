@extends('adminlte::page')

@section('title', 'Kelas')

@section('content_header')
<h1>Kelas</h1>
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
            <button type="button" class="btn btn-primary btn-sm mb-2" data-toggle="modal" onclick="getCreateKelas()" data-target="#form-kelas">
              <i class="nav-icon fas fa-folder-plus"></i> Tambah Kelas
            </button>
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap" id="datatable">
                <thead>
                  <tr>
                    <th style="width: 5%;"> No</th>
                    <th>Kelas</th>
                    <th>Wali Kelas</th>
                    <th style="width: 5%;"> Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($kelas as $kel)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $kel->nama_kelas }}</td>
                    <td>{{ $kel->guru->nama_guru }}</td>
                    <td>
                        <form action="{{ route('kelas.destroy', $kel->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="button" class="btn btn-info btn-sm" onclick="getSubsSiswa({{$kel->id}})" data-toggle="modal" data-target=".view-siswa">
                              <i class="nav-icon fas fa-users"></i> &nbsp; View Siswa
                            </button>
                            <button type="button" class="btn btn-info btn-sm" onclick="getSubsJadwal({{$kel->id}})" data-toggle="modal" data-target=".view-jadwal">
                              <i class="nav-icon fas fa-calendar-alt"></i> &nbsp; View Jadwal
                            </button>
                            <button type="button" class="btn btn-success btn-sm" onclick="getEditKelas({{$kel->id}})" data-toggle="modal" data-target="#form-kelas">
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
</section>

<!-- modal form kelas -->
<div class="modal fade bd-example-modal-md" id="form-kelas" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title" id="judul"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('kelas.store') }}" method="post">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <input type="hidden" id="id" name="id">
              <input type="hidden" id="guru_id_lama" name="guru_id_lama">
              <div class="form-group" id="form_nama">
                <label for="nama_kelas">Nama Kelas</label>
                <input type='text' id="nama_kelas" onkeyup="this.value = this.value.toUpperCase()" name="nama_kelas" class="form-control @error('nama_kelas') is-invalid @enderror" placeholder="{{ __('Nama Kelas') }}">
              </div>
              <div class="form-group" id="form_jurusan"></div>
              <div class="form-group">
                <label for="guru_id">Wali Kelas</label>
                <select id="guru_id" name="guru_id" class="select2bs4 form-control @error('guru_id') is-invalid @enderror">
                  <option value="">-- Pilih Wali Kelas --</option>
                  @foreach ($gurus as $guru)
                    <option value="{{ $guru->id }}">{{ $guru->nama_guru }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class='nav-icon fas fa-arrow-left'></i> &nbsp; Kembali</button>
            <button type="submit" class="btn btn-primary simpan"><i class="nav-icon fas fa-save"></i> &nbsp; Tambahkan</button>
      </form>
      </div>
    </div>
  </div>
</div>

<!-- modal view siswa -->
<div class="modal fade bd-example-modal-lg view-siswa" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="judul-siswa">View Siswa</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="card-body">
              <table class="table table-bordered table-striped table-hover" width="100%" id="tabel-siswa">
                <thead>
                  <tr>
                    <th style="width: 20%;">No Induk Siswa</th>
                    <th>Nama Siswa</th>
                    <th style="width: 10%;">L/P</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>No Induk Siswa</th>
                    <th>Nama Siswa</th>
                    <th>L/P</th>
                  </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.col -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- modal view jadwal -->
<div class="modal fade bd-example-modal-xl view-jadwal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title" id="judul-jadwal">View Jadwal</h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <div class="row">
        <div class="col-md-12">
          <div class="card-body">
            <table class="table table-bordered table-striped table-hover" width="100%" id="tabel-jadwal">
              <thead>
                <tr>
                  <th>Hari</th>
                  <th>Jadwal</th>
                  <th style="width: 20%;">Jam Pelajaran</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Hari</th>
                  <th>Jadwal</th>
                  <th>Jam Pelajaran</th>
                </tr>
              </tfoot>
            </table>
          </div>
          <!-- /.col -->
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

    function getCreateKelas(){
      $("#judul").text('Tambah Data Kelas');
      $('#id').val('');
      $('#form_jurusan').html('');
      $('#form_jurusan').html(`
        <label for="jurusan_id">Paket Keahlian</label>
        <select id="jurusan_id" name="jurusan_id" class="select2bs4 form-control @error('jurusan_id') is-invalid @enderror">
          <option value="">-- Pilih Paket Keahlian --</option>
          @foreach ($jurusans as $jurusan)
            <option value="{{ $jurusan->id }}">{{ $jurusan->nama }}</option>
          @endforeach
        </select>
      `);
      $('#guru_id').val('');
      $('.simpan').html('<i class="nav-icon fas fa-save"></i> &nbsp; Tambahkan');
    }

    function getEditKelas(id){
      var parent = id;
      var form_jurusan = (`
        <input type="hidden" id="jurusan_id" name="jurusan_id">
      `);
      $.ajax({
        type:"GET",
        data:"id="+parent,
        dataType:"JSON",
        url:"{{ url('/kelas/edit/json') }}",
        success:function(result){
            // console.log(result);
          if(result){
            $.each(result,function(index, val){
              $("#judul").text('Edit Data Kelas ' + val.nama);
              $('.simpan').html('<i class="nav-icon fas fa-save"></i> &nbsp; Simpan');
              $('#id').val(val.id);
              $('#nama_kelas').val(val.nama);
              $('#form_jurusan').html('');
              $("#form_jurusan").append(form_jurusan);
              $('#nama_kelas').val(val.nama);
              $("#jurusan_id").val(val.jurusan_id);
              $('#guru_id').val(val.guru_id);
              $('#guru_id_lama').val(val.guru_id);

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

    function getSubsSiswa(id){
      var parent = id;
      $('#tabel-siswa').DataTable( {
          dom: 'Bfrtip',
          searching: false,
          paging: false,
          destroy: true,
          ajax: {
              url: "{{ url('/siswa/view/json') }}?id="+parent,
              dataSrc: ""
          },
          columns: [
              { data: "no_induk" },
              { data: "nama_siswa" },
              { data: "jk" }
          ],
          buttons: [
              'copy', 'csv', 'excel', 'pdf'
          ]
      });
    }

    function getSubsJadwal(id){
      var parent = id;
      $('#tabel-jadwal').DataTable( {
          dom: 'Bfrtip',
          searching: false,
          paging: false,
          destroy: true,
          ajax: {
              url: "{{ url('/jadwal/view/json') }}?id="+parent,
              dataSrc: ""
          },
          columns: [
              { data: "hari" },
              { data: null,
                render: function ( data, type, row ) {
                    return "<h5 class='card-title'>"+data.mapel+"</h5>"+
                    "<p class='card-text'><small class='text-muted'> - "+data.guru+"</small></p>";
                } 
              },
              { data: null,
                render: function ( data, type, row ) {
                    return data.jam_mulai+' - '+data.jam_selesai;
                } 
              },
          ],
          buttons: [
              'copy', 'csv', 'excel', 'pdf'
          ]
      });;
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

