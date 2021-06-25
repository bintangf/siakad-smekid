@extends('adminlte::page')

@section('title', 'Edit Jadwal')

@section('content_header')
<h1>Edit Jadwal</h1>
@stop

@section('plugins.sweetalert2', true)

@section('content')
<section class="content">
  <div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
      <form action="{{ route('jadwal.store') }}" method="post">
        @csrf
        <div class="card-body">
          <div class="row">
            <input type="hidden" name="jadwal_id" value="{{ $jadwal->id }}">
            <div class="col-md-6">
              <div class="form-group">
                <label for="hari_id">Hari</label>
                <select id="hari_id" name="hari_id" class="form-control @error('hari_id') is-invalid @enderror select2bs4">
                  <option value="">-- Pilih Hari --</option>
                  @foreach ($haris as $hari)
                    <option value="{{ $hari->id }}"
                      @if ($jadwal->hari_id == $hari->id)
                        selected
                      @endif
                    >{{ $hari->nama_hari }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="kelas_id">Kelas</label>
                <select id="kelas_id" name="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror select2bs4">
                  <option value="">-- Pilih Kelas --</option>
                  @foreach ($kelas as $kel)
                  <option value="{{ $kel->id }}"
                      @if ($jadwal->kelas_id == $kel->id)
                        selected
                      @endif
                    >{{ $kel->nama_kelas }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="guru_id">Nama Guru</label>
                <select id="guru_id" name="guru_id" class="form-control @error('guru_id') is-invalid @enderror select2bs4">
                  <option value="" @if ($jadwal->guru_id)
                    selected
                  @endif>-- Pilih Guru Mapel --</option>
                  @foreach ($gurus as $guru)
                    <option value="{{ $guru->id }}"
                      @if ($jadwal->guru_id == $guru->id)
                        selected
                      @endif
                    >{{ $guru->nama_guru }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="jam_mulai">Jam Mulai</label>
                <input type='time' value="{{ $jadwal->jam_mulai }}" id="jam_mulai" name='jam_mulai' class="form-control @error('jam_mulai') is-invalid @enderror" placeholder='JJ:mm:dd'>
              </div>
              <div class="form-group">
                <label for="jam_selesai">Jam Selesai</label>
                <input type='time' value="{{ $jadwal->jam_selesai }}" name='jam_selesai' class="form-control @error('jam_selesai') is-invalid @enderror" placeholder='JJ:mm:dd'>
              </div>
              <div class="form-group">
                <label for="mapel_id">Mata Pelajaran</label>
                <select id="mapel_id" name="mapel_id" class="form-control @error('mapel_id') is-invalid @enderror select2bs4">
                  <option>-- Pilih Mata Pelajaran --</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <a href="#" name="kembali" class="btn btn-default" id="back"><i class='nav-icon fas fa-arrow-left'></i> Kembali </a>
          <button name="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp; Update</button>
        </div>
      </form>
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
                $('#mapel_id').empty();

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

        $('#back').click(function() {
        window.location="{{ route('jadwal.show', Crypt::encrypt($jadwal->kelas_id)) }}";
        });

        var guruid = document.getElementById("guru_id").value;
        $.ajax({
            url: '{{ route('guru.listMapel') }}',
            method: 'POST',
            data: {id: guruid},
            success: function (response) {
                $('#mapel_id').empty();

                $.each(response, function (id, nama_kelas) {
                    $('#mapel_id').append(new Option(id, nama_kelas))
                })
            }
        })

    } );

</script>
@stop

