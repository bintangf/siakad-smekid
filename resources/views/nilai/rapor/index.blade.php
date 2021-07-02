@extends('adminlte::page')

@section('title', 'Nilai Rapor')

@section('content_header')
<h1>Nilai Rapor</h1>
@stop

@section('plugins.Datatables', true)

@section('content')
<div class="col-md-12">
    <!-- general form elements -->
    <div class="card card-primary">
      <!-- /.card-header -->
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <table id="datatable" class="table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Nama Kelas</th>
                  <th>Tahun Semester</th>
                  <th>Aksi</th>
              </thead>
              <tbody>
                @php $i=1; @endphp
                @foreach ($kelas as $kel)
                @foreach ($kel as $val => $data)
                  <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $data[0]->kelas->nama_kelas }}</td>
                    <td>{{ $val }}</td>
                    <td><a href="{{ route('rapor.show', Crypt::encrypt([$data[0]->kelas_id, $val])) }}" class="btn btn-info btn-sm"><i class="nav-icon fas fa-search-plus"></i> &nbsp; Details</a></td>
                  </tr>
                @endforeach
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
        dom: 'Bfrtip'
    });
});
</script>
@stop

