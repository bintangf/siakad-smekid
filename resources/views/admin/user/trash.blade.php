@extends('adminlte::page')

@section('title', 'Trash User')

@section('content_header')
<h1>Trash User</h1>
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
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Level User</th>
                                    <th style="width: 5%;"> Aksi </th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                      <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-capitalize">{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ ucfirst(trans($user->roles[0]->name)) }}</td>
                                        <td>
                                            <form action="{{ route('user.kill', $user->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <a href="{{ route('user.restore', Crypt::encrypt($user->id)) }}" class="btn btn-success btn-sm mt-2"><i class="nav-icon fas fa-undo"></i> &nbsp; Restore</a>
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

