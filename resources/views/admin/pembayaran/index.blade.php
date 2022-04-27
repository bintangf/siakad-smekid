@extends('adminlte::page')

@section('title', 'Pembayaran')

@section('content_header')
<h1>Pembayaran</h1>
@stop

@section('plugins.Datatables', true)
@section('plugins.datatablesPlugins', true)
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
                    <th style="width: 5%;"> No</th>
                    <th>Kelas</th>
                    <th>Nama Siswa</th>
                    <th>Nama Tagihan</th>
                    <th>Nominal</th>
                    <th style="width: 5%;"> Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($detailTagihan as $tag)
                  @php $bayar = $tag->tagihan->jumlah - $tag->pembayaran->sum('jumlah'); @endphp
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $tag->siswa->kelas->nama_kelas }}</td>
                    <td>{{ $tag->siswa->nama_siswa }}</td>
                    <td>{{ $tag->tagihan->nama }}</td>
                    @if($tag->keterangan == 'lunas')
                      <td style="color:green;">Lunas</td>
                    @else
                      <td style="color:red;">@currency ($bayar)</td>
                    @endif
                    <td>
                      @if($tag->keterangan == 'lunas')
                        <button type="button" class="btn btn-info btn-sm" disabled>
                          <i class="nav-icon fas fa-money-bill"></i> &nbsp; Bayar
                        </button>
                      @else
                        <button type="button" class="btn btn-info btn-sm" onclick="tagih({{$tag->id}},{{$bayar}})" data-toggle="modal" data-target="#form-pembayaran">
                          <i class="nav-icon fas fa-money-bill"></i> &nbsp; Bayar
                        </button>
                      @endif
                      <button type="button" class="btn btn-success btn-sm" onclick="histori({{$tag->id}})" data-toggle="modal" data-target="#histori">
                        <i class="nav-icon fas fa-clock"></i> &nbsp; Histori
                      </button>
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
  </div>
</section>

<!-- modal form pembayaran -->
<div class="modal fade bd-example-modal-md" id="form-pembayaran" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title" id="judul">Pembayaran</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('pembayaran.store') }}" method="post">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <input type="hidden" id="detail_tagihan_id" name="detail_tagihan_id">
              <div class="form-group" id="form_nominal">
                <label for="jumlah">Jumlah Nominal</label>
                <input type='number' id="jumlah" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror" placeholder="100000">
              </div>
              <div class="form-group" id="form_keterangan">
                <label for="keterangan">Keterangan</label>
                <input type='text' id="keterangan" name="keterangan" class="form-control @error('keterangan') is-invalid @enderror">
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class='nav-icon fas fa-arrow-left'></i> &nbsp; Kembali</button>
              <button type="submit" class="btn btn-primary simpan"><i class="nav-icon fas fa-save"></i> &nbsp; Tambahkan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- modal view histori -->
<div class="modal fade bd-example-modal-md" id="histori" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Histori Pembayaran</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="card-body">
              <table class="table table-bordered table-striped table-hover" width="100%" id="tabel-histori">
                <thead>
                  <tr>
                    <th>Nominal</th>
                    <th>Keterangan</th>
                    <th>Tanggal</th>
                  </tr>
                </thead>
              </table>
            </div>
            <!-- /.col -->
          </div>
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

function tagih(id,bayar){
  $('#detail_tagihan_id').val(id);
  document.getElementsByName('jumlah')[0].placeholder=bayar;
}

function histori(id){
      $('#tabel-histori').DataTable( {
          dom: 'Bfrtip',
          searching: false,
          paging: false,
          destroy: true,
          ajax: {
              url: "{{ url('/pembayaran/view/json') }}?id="+id,
              dataSrc: ""
          },
          columns: [
              { data: "jumlah",  render: $.fn.dataTable.render.number( '.', '.', 0, 'Rp. ' ) },
              { data: "keterangan" },
              { data: "tanggal" }
          ],
          buttons: [
              'copy', 'csv', 'excel', 'pdf'
          ]
      });
    }

$(document).ready(function() {

  @if(Session::has('error'))
    Swal.fire(
      'Error!',
      "{{ Session::get('error') }}",
      'error'
    );
  @endif

  @if(Session::has('success'))
    Swal.fire(
      'Berhasil!',
      "{{ Session::get('success') }}",
      'success'
    );
  @endif

  $('#datatable').DataTable({
  });
});

</script>
@stop

