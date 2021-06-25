@extends('adminlte::page')

@section('title', 'Profile')

@section('content_header')
<h1>Profile</h1>
@stop

@section('plugins.sweetalert2', true)

@section('content')
<div class="col-12">
    <div class="row">
        <div class="col-5">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title text-center">{{ Auth::user()->name }}</h3>
                </div>
                <div class="card-body">
                    <strong><i class="far fa-address-card mr-1"></i> Role</strong>
                    <p class="text-muted">
                    @foreach (Auth::user()->getRoleNames() as $role)
                        {{ Str::ucfirst($role) }}
                    @endforeach
                    </p>
                    <hr>
                    <strong><i class="far fa-envelope mr-1"></i> Email</strong>
                    <p class="text-muted">{{ Auth::user()->email }}</p>
                    <br>
                    <table class="table" style="margin-top: -21px;">
                    <tr>
                        <td width="50"><i class="nav-icon fas fa-envelope"></i></td>
                        <td>Ubah Email</td>
                        <td width="50"><a href="{{ route('pengaturan.email') }}" class="btn btn-default btn-sm">Edit</a></td>
                    </tr>
                    <tr>
                        <td width="50"><i class="nav-icon fas fa-key"></i></td>
                        <td>Ubah Password</td>
                        <td width="50"><a href="{{ route('pengaturan.password') }}" class="btn btn-default btn-sm">Edit</a></td>
                    </tr>
                    </table>
                    <br>
                    <a href="{{ route('pengaturan.profile') }}" class="btn btn-primary btn-block"><b>Edit Profile</b></a>
                </div>
            </div>
        </div>
        <!-- /.col -->
        
        <div class="col-7">
            <!-- About Me Box -->
            @hasallroles('guru')
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">About Me</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @role('wali kelas')
                        <strong><i class="fas fa-chalkboard mr-1"></i> Wali Kelas</strong>
                        <p class="text-muted">{{ Auth::user()->guru->kelas->nama_kelas }}</p>
                        <hr>
                    @endrole
                    @role('guru')
                        <strong><i class="fas fa-book mr-1"></i> Guru Mapel</strong>
                        <p class="text-muted">
                        @foreach (Auth::user()->guru->mapel as $mapel)
                        @if( count(Auth::user()->guru->mapel) > 1)
                            {{ $mapel->nama_mapel }},
                        @else
                            {{ $mapel->nama_mapel }}
                        @endif 
                        @endforeach
                        </p>
                        <hr>
                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Tempat Lahir</strong>
                        <p class="text-muted">{{ Auth::user()->guru->tmp_lahir }}</p>
                        <hr>
                        <strong><i class="far fa-calendar mr-1"></i> Tanggal Lahir</strong>
                        <p class="text-muted">{{ date('l, d F Y', strtotime(Auth::user()->guru->tgl_lahir)) }}</p>
                        <hr>
                        <strong><i class="fas fa-phone mr-1"></i> No Telepon</strong>
                        <p class="text-muted">{{ Auth::user()->guru->telp }}</p>
                    @endrole
                </div>
                <!-- /.card-body -->
            </div>
            @endhasallroles
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>
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
});
</script>
@stop

