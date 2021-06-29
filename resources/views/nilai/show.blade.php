@extends('adminlte::page')

@section('title', 'Input Nilai')

@section('content_header')
<h1>Input Nilai</h1>
@stop

@section('plugins.Datatables', true)
@section('plugins.sweetalert2', true)

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
                <table class="table" style="margin-top: -10px;">
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
                        <td>Jumlah Siswa</td>
                        <td>:</td>
                        <td>{{ $siswas->count() }}</td>
                    </tr>
                    <tr>
                        <td>Mata Pelajaran</td>
                        <td>:</td>
                        <td>{{ $mapel->nama_mapel }}</td>
                    </tr>
                    <tr>
                        <td>Guru Mata Pelajaran</td>
                        <td>:</td>
                        <td>{{ $guru->nama_guru }}</td>
                    </tr>
                    @php
                        $bulan = date('m');
                        $tahun = date('Y');
                        if($bulan > 6){
                          $smt = 'Semester Ganjil';
                          $th  = $tahun.'/'.($tahun+1);
                        }else{
                          $smt = 'Semester Genap';
                          $th  = ($tahun-1).'/'.$tahun;
                        };
                    @endphp
                    <tr>
                        <td>Tahun Pelajaran Semester</td>
                        <td>:</td>
                        <td>{{  $th.' '.$smt }}</td>
                    </tr>
                </table>
                <hr>
            </div>
            <div class="col-md-12">
              <table class="table table-hover text-nowrap" id="datatable">
                <thead>
                  <tr>
                    <th style="width: 5%;">No.</th>
                    <th>Nama Siswa</th>
                    <th class="text-center" style="width: 10%;">Rata UH</th>
                    <th class="text-center" style="width: 10%;">Ketrampilan</th>
                    <th class="text-center" style="width: 10%;">UTS</th>
                    <th class="text-center" style="width: 10%;">PAT</th>
                    <th style="width: 5%;"></th>
                </thead>
                <tbody>
                  <form action="" method="post">
                  <tr>
                    @csrf
                  @foreach ($siswas as $siswa)
                    @php
                        $find = [$siswa->id, $kelas->id, $guru->id, $mapel->id, $th.' '.$smt]
                    @endphp
                    <td>{{ $loop->iteration }}</td>
                    <td>
                      {{ $siswa->nama_siswa }}
                      @if ($siswa->nilai($find) && $siswa->nilai($find)['id'])
                      <input type="hidden" name="nilai_id" class="nilai_id_{{$siswa->id}}" value="{{ $siswa->nilai($find)['id'] }}">
                      @else
                      <input type="hidden" name="nilai_id" class="nilai_id_{{$siswa->id}}" value="">
                      @endif
                      <input type="hidden" name="data" class="data_{{$siswa->id}}" value="{{ json_encode($find) }}">
                    </td>
                    <td>
                      @if ($siswa->nilai($find) && $siswa->nilai($find)['ulha'])
                        @if( $siswa->nilai($find) && $siswa->nilai($find)['acc'] == 1)
                          <div class="text-center">{{ $siswa->nilai($find)['ulha'] }}</div>
                          <input type="hidden" name="ulha" class="ulha_{{$siswa->id}}" value="{{ $siswa->nilai($find)['ulha'] }}">
                        @else
                          <input type="text" name="ulha" maxlength="2" onkeypress="return inputAngka(event)" style="margin: auto; width: 50px;" class="form-control text-center ulha_{{$siswa->id}}" autocomplete="off" value="{{ $siswa->nilai($find)['ulha'] }}">
                        @endif
                      @else
                        <input type="text" name="ulha" maxlength="2" onkeypress="return inputAngka(event)" style="margin: auto; width: 50px;" class="form-control text-center ulha_{{$siswa->id}}" autocomplete="off">
                      @endif
                    </td>
                    <td>
                      @if ($siswa->nilai($find) && $siswa->nilai($find)['ketrampilan'])
                        @if( $siswa->nilai($find) && $siswa->nilai($find)['acc'] == 1)
                          <div class="text-center">{{ $siswa->nilai($find)['ketrampilan'] }}</div>
                          <input type="hidden" name="ketrampilan" class="ketrampilan_{{$siswa->id}}" value="{{ $siswa->nilai($find)['ketrampilan'] }}">
                        @else
                          <input type="text" name="ketrampilan" maxlength="2" onkeypress="return inputAngka(event)" style="margin: auto; width: 50px;" class="form-control text-center ketrampilan_{{$siswa->id}}" autocomplete="off" value="{{ $siswa->nilai($find)['ketrampilan'] }}">
                        @endif
                      @else
                        <input type="text" name="ketrampilan" maxlength="2" onkeypress="return inputAngka(event)" style="margin: auto; width: 50px;" class="form-control text-center ketrampilan_{{$siswa->id}}" autocomplete="off">
                      @endif
                    </td>
                    <td>
                      @if ($siswa->nilai($find) && $siswa->nilai($find)['uts'])
                        @if( $siswa->nilai($find) && $siswa->nilai($find)['acc'] == 1)
                          <div class="text-center">{{ $siswa->nilai($find)['uts'] }}</div>
                          <input type="hidden" name="uts" class="uts_{{$siswa->id}}" value="{{ $siswa->nilai($find)['uts'] }}">
                        @else
                          <input type="text" name="uts" maxlength="2" onkeypress="return inputAngka(event)" style="margin: auto; width: 50px;" class="form-control text-center uts_{{$siswa->id}}" autocomplete="off" value="{{ $siswa->nilai($find)['uts'] }}">
                        @endif
                      @else
                        <input type="text" name="uts" maxlength="2" onkeypress="return inputAngka(event)" style="margin: auto; width: 50px;" class="form-control text-center uts_{{$siswa->id}}" autocomplete="off">
                      @endif
                    </td>
                    <td>
                      @if ($siswa->nilai($find) && $siswa->nilai($find)['pat'] )
                        @if( $siswa->nilai($find) && $siswa->nilai($find)['acc'] == 1)
                          <div class="text-center">{{ $siswa->nilai($find)['pat'] }}</div>
                          <input type="hidden" name="pat" class="pat_{{$siswa->id}}" value="{{ $siswa->nilai($find)['pat'] }}">
                        @else
                          <input type="text" name="pat" maxlength="2" onkeypress="return inputAngka(event)" style="margin: auto; width: 50px;" class="form-control text-center pat_{{$siswa->id}}" autocomplete="off" value="{{ $siswa->nilai($find)['pat'] }}">
                        @endif
                      @else
                        <input type="text" name="pat" maxlength="2" onkeypress="return inputAngka(event)" style="margin: auto; width: 50px;" class="form-control text-center pat_{{$siswa->id}}" autocomplete="off">
                      @endif
                    </td>
                    <td class="text-center">
                      @if ( $siswa->nilai($find) && $siswa->nilai($find)['acc'] == 1)
                        <i class="fas fa-check" style="font-weight:bold;"></i>
                      @else
                        <button type="button" id="submit-{{$siswa->id}}" class="btn btn-default btn_click" data-id="{{$siswa->id}}">
                          <i class="nav-icon fas fa-save"></i>
                        </button>
                      @endif
                    </td>
                  </tr>
                  @endforeach
                    </form>
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
  function inputAngka(e) {
    var charCode = (e.which) ? e.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57)){
      return false;
    }
    return true;
  }

$(document).ready(function() {
    $('#datatable').DataTable({
        dom: 'Bfrtip'
    });

    $(".btn_click").click(function(){
      var id = $(this).attr('data-id');
      var datas = JSON.parse($(".data_"+id).val());
      var nilai_id = $(".nilai_id_"+id).val();
      var ulha = $(".ulha_"+id).val();
      var ketrampilan = $(".ketrampilan_"+id).val();
      var uts = $(".uts_"+id).val();
      var pat = $(".pat_"+id).val();

      $.ajax({
        url: "{{ route('nilai.store') }}",
        type: "POST",
        dataType: 'json',
        data  : {
          _token: '{{ csrf_token() }}',
          id : nilai_id,
          siswa_id : id,
          kelas_id : datas[1],
          guru_id : datas[2],
          mapel_id : datas[3],
          tahun_semester : datas[4],
          ulha : ulha,
          ketrampilan : ketrampilan,
          uts : uts,
          pat : pat,
        },
        success: function(data){
          Swal.fire(
            'Berhasil!',
            "Nilai ulangan siswa berhasil ditambahkan!",
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

