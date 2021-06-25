@extends('adminlte::page')

@section('title', 'Trash Mata Pelajaran')

@section('content_header')
<h1>Trash Mata Pelajaran</h1>
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
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap" id="datatable">
                                <thead>
                                <tr>
                                    <th style="width: 5%;"> No </th>
                                    <th> Mata Pelajaran </th>
                                    <th> Jurusan </th>
                                    <th> Kelompok </th>
                                    <th style="width: 5%;"> Aksi </th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mapels as $mapel)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $mapel->nama_mapel }}</td>
                                        @if ( $mapel->jurusan_id == 4 )
                                          <td>{{ 'Semua' }}</td>
                                        @else
                                          <td>{{ $mapel->jurusan->nama }}</td>
                                        @endif

                                        @if ( $mapel->kelompok == 'A')
                                          <td>Muatan Nasional</td>
                                        @endif
                                        @if ( $mapel->kelompok == 'B')
                                          <td>Muatan Kewilayahan</td>
                                        @endif
                                        @if ( $mapel->kelompok == 'C')
                                          <td>Muatan Kejuruhan</td>
                                        @endif
                                        
                                        <td>
                                            <form action="{{ route('mapel.kill', $mapel->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <a class="btn-sm btn-primary m-2" href="{{ route('mapel.restore', Crypt::encrypt($mapel->id)) }}" >
                                                  <span class="fas fa-undo"></span> Restore
                                                </a>
                                                <button class="btn-sm btn-danger" style="border: 0">
                                                  <span class="fas fa-trash"></span> Hapus
                                                </button>
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
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>
    $(document).ready(function() {

      @if(Session::has('success'))
        Swal.fire(
          'Berhasil!',
          "{{ Session::get('success') }}",
          'success'
        );
      @endif
      @if(Session::has('info'))
        Swal.fire(
          'Berhasil!',
          "{{ Session::get('info') }}",
          'info'
        );
      @endif

        $('#datatable').DataTable({
            dom: 'Bfrtip'
        });

    } );

</script>
@stop

