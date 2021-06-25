@extends('adminlte::page')

@section('title', 'Trash Kelas')

@section('content_header')
<h1>Trash Kelas</h1>
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
                      <table class="table table-hover text-nowrap" id="datatable">
                        <thead>
                            <tr>
                                <th style="width: 5%;">No.</th>
                                <th>Kelas</th>
                                <th>Paket Keahlian</th>
                                <th>Wali Kelas</th>
                                <th style="width: 5%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kelas as $kel)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $kel->nama_kelas }}</td>
                                <td>{{ $kel->jurusan->nama }}</td>
                                <td>
                                  @foreach($gurus as $guru )
                                    @if( $kel->guru->guru_id == $guru->id)
                                      {{ $guru->nama_guru }}
                                    @endif
                                  @endforeach
                                </td>
                                <td>
                                    <form action="{{ route('kelas.kill', $kel->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <a href="{{ route('kelas.restore', Crypt::encrypt($kel->id)) }}" class="btn btn-success btn-sm mt-2"><i class="nav-icon fas fa-undo"></i> &nbsp; Restore</a>
                                        <button class="btn btn-danger btn-sm mt-2"><i class="nav-icon fas fa-trash-alt"></i> &nbsp; Hapus</button>
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

