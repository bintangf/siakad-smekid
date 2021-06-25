@extends('adminlte::page')

@section('title', 'Nilai Rapor')

@section('content_header')
<h1>Nilai Rapor {{ $kelas->nama_kelas }}</h1>
@stop

@section('plugins.Datatables', true)

@section('content')
<div class="col-md-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Show Rapot</h3>
      </div>
      <!-- /.card-header -->
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
                <table class="table" style="margin-top: -10px;">
                    <tr>
                        <td>No Induk Siswa</td>
                        <td>:</td>
                        <td>{{ $siswa->no_induk }}</td>
                    </tr>
                    <tr>
                        <td>Nama Siswa</td>
                        <td>:</td>
                        <td>{{ $siswa->nama_siswa }}</td>
                    </tr>
                    <tr>
                        <td>Nama Kelas</td>
                        <td>:</td>
                        <td>{{ $kelas->nama_kelas }}</td>
                    </tr>
                    <tr>
                        <td>Wali Kelas</td>
                        <td>:</td>
                        <td>{{ $kelas->guru->nama_guru }}</td>
                    </tr>
                    <tr>
                        <td>Tahun Pelajaran Semester</td>
                        <td>:</td>
                        <td>{{  $nilai[0]->tahun_semester }}</td>
                    </tr>
                </table>
                <hr>
            </div>
            <div class="col-md-12">
                <table class="table table-bordered table-striped table-hover text-center" >
                    <thead>
                        <tr>
                            <th rowspan="2">No.</th>
                            <th rowspan="2">Mata Pelajaran</th>
                            <th rowspan="2">KKM</th>
                            <th colspan="2">Pengetahuan</th>
                            <th colspan="2">Keterampilan</th>
                        </tr>
                        <tr>
                            <th>Nilai</th>
                            <th>Predikat</th>
                            <th>Nilai</th>
                            <th>Predikat</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach ($nilai as $data)
                            @php
                              $nr = ceil((($data->ulha*2)+$data->uts+$data->pat)/4);
                            @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->mapel->nama_mapel }}</td>
                                    <td>75</td>
                                    <td>{{ $nr }}</td>
                                    <td>
                                      @if($nr >= 94)
                                        A+
                                      @elseif($nr >= 90)
                                        A
                                      @elseif($nr >= 86)
                                        A-
                                      @elseif($nr >= 82)
                                        B+
                                      @elseif($nr >= 78)
                                        B
                                      @elseif($nr >= 74)
                                        B-
                                      @elseif($nr >= 70)
                                        C
                                      @else
                                        D
                                      @endif
                                    </td>
                                    <td>{{ $data->ketrampilan }}</td>
                                    <td>
                                      @if($data->ketrampilan >= 94)
                                        A+
                                      @elseif($data->ketrampilan >= 90)
                                        A
                                      @elseif($data->ketrampilan >= 86)
                                        A-
                                      @elseif($data->ketrampilan >= 82)
                                        B+
                                      @elseif($data->ketrampilan >= 78)
                                        B
                                      @elseif($data->ketrampilan >= 74)
                                        B-
                                      @elseif($data->ketrampilan >= 70)
                                        C
                                      @else
                                        D
                                      @endif
                                    </td>
                                </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>
$(document).ready(function() {
    $('#datatable').DataTable({
    });
});
</script>
@stop

