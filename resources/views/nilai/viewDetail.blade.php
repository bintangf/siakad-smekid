@extends('adminlte::page')

@section('title', 'Detail Nilai')

@section('content_header')
<h1>Detail Nilai {{ $nilai[0]->kelas->nama_kelas }} - {{ $nilai[0]->mapel->nama_mapel }} - {{ $nilai[0]->tahun_semester }}</h1>
@stop

@section('plugins.Datatables', true)
@section('plugins.sweetalert2', true)

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
          <div class="row">
            @role('wali kelas')
              @if(Auth::user()->guru->id == $nilai[0]->kelas->guru_id)
                <div class="col-md-12">
                    <table class="table" style="margin-top: -10px;">
                          <tr>
                              <td>Nama Guru Mata Pelajaran</td>
                              <td>:</td>
                              <td>{{ $nilai[0]->guru->nama_guru }}</td>
                          </tr>
                    </table>
                    <hr>
                  </div>
              @endif
              @endrole
            <div class="col-md-12">
              <table class="table table-hover text-nowrap" id="datatable">
                <thead>
                  <tr>
                    <th style="width: 5%;">No.</th>
                    <th>Nama Siswa</th>
                    <th style="width: 10%;">Rata UH</th>
                    <th style="width: 10%;">Ketrampilan</th>
                    <th style="width: 10%;">UTS</th>
                    <th style="width: 10%;">PAT</th>
                    @role('wali kelas')
                      @if(Auth::user()->guru->id == $nilai[0]->kelas->guru_id)
                        <th style="width: 10%;">Aksi</th>
                      @endif
                    @endrole
                </thead>
                <tbody>
                  <tr>
                  @foreach ($nilai as $data)
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data->siswa->nama_siswa }}</td>
                    <td>{{ $data->ulha }}</td>
                    <td>{{ $data->ketrampilan }}</td>
                    <td>{{ $data->uts }}</td>
                    <td>{{ $data->pat }}</td>
                    @role('wali kelas')
                      @if(Auth::user()->guru->id == $data->kelas->guru_id)
                      <td class="text-center">
                        @if ($data->acc == 1)
                          <i class="fas fa-check" style="font-weight:bold;"></i>
                        @else
                          <button type="button" class="btn btn-default btn_click" data-id="{{$data->id}}">
                            <i class="nav-icon fas fa-save"></i>
                          </button>
                        @endif
                      </td>
                      @endif
                    @endrole
                  </tr>
                  @endforeach
                </tbody>
              </table>
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
    $('#datatable').DataTable({
        dom: 'Bfrtip'
    });

    $(".btn_click").click(function(){
      var id = $(this).attr('data-id');
      var acc = 1;

      $.ajax({
        url: "{{ route('nilai.store') }}",
        type: "POST",
        dataType: 'json',
        data  : {
          _token: '{{ csrf_token() }}',
          id : nilai_id,
          acc : acc,
        },
        success: function(data){
          Swal.fire(
            'Berhasil!',
            "Nilai ulangan siswa berhasil diapprove!",
            'success'
          ).then((result) => {
            location.reload();
          })
        },
        error: function (data) {
          Swal.fire(
            'Error!',
            "Errors 404!",
            'error'
          )
        }
      });
    });
});
</script>
@stop

