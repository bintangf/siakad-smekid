@extends('adminlte::page')

@section('title', 'Jadwal')

@section('content_header')
<h1>Jadwal</h1>
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
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".tambah-jadwal">
              <i class="nav-icon fas fa-folder-plus"></i> Tambah Jadwal
            </button>
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap" id="datatable">
                <thead>
                  <tr>
                    <th style="width: 5%;"> No </th>
                    <th> Nama Kelas </th>
                    <th style="width: 20%;"> Lihat Guru </th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($kelas as $kel)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $kel->nama_kelas }}</td>
                    <td>
                      <a href="{{ route('jadwal.show', Crypt::encrypt($kel->id)) }}" class="btn btn-info btn-sm">
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

<!-- modal tambah jadwal -->
<div class="modal fade bd-example-modal-lg tambah-jadwal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title">Tambah Data Jadwal</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
          <form action="{{ route('jadwal.store') }}" method="post">
            @csrf
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="hari_id">Hari</label>
                  <select id="hari_id" name="hari_id" class="form-control @error('hari_id') is-invalid @enderror select2bs4">
                      <option value="">-- Pilih Hari --</option>
                      @foreach ($haris as $hari)
                          <option value="{{ $hari->id }}">{{ $hari->nama_hari }}</option>
                      @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="kelas_id">Kelas</label>
                  <select id="kelas_id" name="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror select2bs4">
                      <option value="">-- Pilih Kelas --</option>
                      @foreach ($kelas as $kel)
                          <option value="{{ $kel->id }}">{{ $kel->nama_kelas }}</option>
                      @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="guru_id">Nama Guru</label>
                  <select id="guru_id" name="guru_id" class="form-control @error('guru_id') is-invalid @enderror select2bs4">
                      <option value="">-- Pilih Guru --</option>
                      @foreach ($gurus as $guru)
                          <option value="{{ $guru->id }}">{{ $guru->nama_guru }}</option>
                      @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="jam_mulai">Jam Mulai</label>
                  <input type='text' id="jam_mulai" name='jam_mulai' class="form-control @error('jam_mulai') is-invalid @enderror jam_mulai" placeholder="{{ Date('H:i') }}">
                </div>
                <div class="form-group">
                  <label for="jam_selesai">Jam Selesai</label>
                  <input type='text' id="jam_selesai" name='jam_selesai' class="form-control @error('jam_selesai') is-invalid @enderror" placeholder="{{ Date('H:i') }}">
                </div>
                <div class="form-group" id="mapel">
                <label for="mapel_id">Mata Pelajaran</label>
                  <select id="mapel_id" name="mapel_id" class="form-control @error('mapel_id') is-invalid @enderror select2bs4">
                      <option value="">-- Pilih Mapel --</option>
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

$(function () {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $('#guru_id').on('change', function () {
        $.ajax({
            url: '{{ route('guru.listMapel') }}',
            method: 'POST',
            data: {id: $(this).val()},
            success: function (response) {
                $('#mapel_id').html('')
                $.each(response, function (id, nama_kelas) {
                    $('#mapel_id').append(new Option(id, nama_kelas))
                })
            }
        })
    });
});

    $(document).ready(function() {

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
        $("#jam_mulai,#jam_selesai").daterangepicker({
            timeFormat: 'HH:mm'
        });


    } );

</script>
@stop
