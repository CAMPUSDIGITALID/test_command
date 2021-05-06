@extends('faturcms::template.admin.main')

@section('title', 'Dashboard')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Dashboard',
        'items' => [
            ['text' => 'Dashboard', 'url' => '#']
        ]
    ]])
    <!-- /Breadcrumb -->

    <div class="row">
        <div class="col-12 col-md-4 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <img width="90" class="mb-3" src="https://image.flaticon.com/icons/svg/3530/3530292.svg">
                    <h5 class="m-0 font-weight-normal">Selamat datang <span class="font-weight-bold text-capitalize">{{ Auth::user()->nama_user }}</span> di {{ setting('site.name') }}.</h5>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8 mb-4">
            <div class="card">
                <div class="card-header bg-transparent d-flex align-items-center">
                    <img width="40" class="mr-4" src="https://image.flaticon.com/icons/svg/4525/4525701.svg">
                    <div>
                        <h5 class="m-0">Komisi</h5>
                        <p class="m-0">Pendapatan anda</p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="media align-items-center">
                        
                        <div class="media-body">
                            <h5>Saldo</h5>
                            <h1 style="color: var(--green)">Rp {{ number_format(Auth::user()->saldo,0,'.','.') }}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header bg-transparent d-flex align-items-center">
                    <img width="40" class="mr-4" src="https://image.flaticon.com/icons/svg/4525/4525691.svg">
                    <div>
                        <h5 class="m-0">Referal</h5>
                        <p class="m-0">Link Referal</p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="media align-items-center">
                        
                        <div class="media-body">
                            <div class="menu-bg-red rounded-1 text-center py-2 mb-2" data-toggle="tooltip" data-placement="top" title="Klik Untuk Menyalin">
                                <h3 class="m-0" id="clicktocopy">{{ URL::to('/') }}?ref={{ Auth::user()->username }}</h3>
                            </div>
                            <p>Promosikan URL Referral Anda dan dapatkan Komisi Sponsor sebesar Rp. 30.000 setiap ada member baru yang bergabung melalui URL Anda. Tidak ada batasan jumlah member yang Anda sponsori, Anda bisa mensponsori puluhan, bahkan ratusan member.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(Auth::user()->status == 1)
    <!-- User Aktif -->
    <!-- Row -->
    <div class="row">
        @if(Auth::user()->role == role('trainer') && !$signature)
        <!-- Signature -->
        <!-- Column -->
        <div class="col-lg-12">
            <div class="alert alert-danger text-center shadow">
                Anda merupakan {{ role(role('trainer')) }} tetapi belum mempunyai Tanda Tangan Digital. <a href="{{ route('member.signature.input') }}">Buat disini</a>.
            </div>
        </div>
        <!-- /Column -->
        <!-- /Signature -->
        @endif
        <!-- Column -->

        <!-- /Column -->
        <!-- Column -->
        <div class="col-md-12">
            <div class="row">
                @if(count($fitur)>0)
                    @foreach($fitur as $data)
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <a href="{{ URL::to('member/'.$data->url_fitur) }}">
                                        <img src="{{ image('assets/images/fitur/'.$data->gambar_fitur, 'fitur') }}" height="100" style="max-width: 100%;">
                                    </a>
                                    <p class="h6 mt-3 mb-0"><a href="{{ URL::to('member/'.$data->url_fitur) }}">{{ $data->nama_fitur }}</a></p>
                                    <p class="mt-2 mb-0">{{ $data->deskripsi_fitur }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <!-- /Column -->
    </div>
    <!-- /Row -->
    <!-- /User Aktif -->
    @endif

    @if(Auth::user()->status == 0 && Auth::user()->email_verified == 1)
    <!-- User Belum Aktif tapi Sudah Memverifikasi Email -->
    <!-- Row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-warning text-center shadow">
                Email Anda sudah terverifikasi. Tahap selanjutnya adalah melakukan pembayaran.
            </div>
        </div>
        <!-- Column -->
        <div class="col-lg-6">
            <!-- Tile -->
            <div class="tile">
                <!-- Tile Body -->
                <div class="tile-body">
                    <h4 class="card-title">Aktivasi Akun Anda</h4>
                    <div class="m-t-20 m-b-20">
                        <div class="alert alert-info">Kode pembayaran Anda adalah <strong>{{ $komisi->inv_komisi }}</strong>. Kode ini akan digunakan saat Anda melakukan konfirmasi pembayaran.</div>
                        <p class="mb-1">Aktivasi akun Anda dengan melakukan pembayaran sejumlah <del>Rp {{ number_format(setting('site.harga_dicoret'),0,'.','.') }}</del> <strong>Rp {{ number_format($komisi->komisi_aktivasi,0,'.','.') }}</strong> ke rekening berikut:</p>
                        <ol>
                            @foreach($default_rekening as $data)
                            <li><strong>{{ $data->nama_platform }}</strong> dengan nomor rekening <strong>{{ $data->nomor }}</strong> a/n <strong>{{ $data->atas_nama }}</strong>.</li>
                            @endforeach
                        </ol>
                    </div>
                </div>
                <!-- /Tile Body -->
            </div>
            <!-- /Tile -->
        </div>
        <!-- /Column -->
        <!-- Column -->
        <div class="col-lg-6">
            <!-- Tile -->
            <div class="tile">
                <!-- Tile Body -->
                <div class="tile-body">
                    <h4 class="card-title">Anda Sudah Membayar?</h4>
                    <div class="m-t-20 m-b-20">
                        @if($komisi->komisi_proof == '')
                        <p>Jika Anda sudah membayar, segera lakukan konfirmasi pembayaran <a href="#" class="font-weight-bold btn-confirm">DISINI</a>.</p>
                        @else
                        <div class="alert alert-success">Anda sudah membayar dan melakukan konfirmasi pembayaran. Tunggu beberapa saat sampai pihak Admin memverifikasi konfirmasi pembayaran Anda.</div>
                        @endif
                    </div>
                </div>
                <!-- /Tile Body -->
            </div>
            <!-- /Tile -->
        </div>
        <!-- /Column -->
    </div>
    <!-- /Row -->
    @endif

    @if(Auth::user()->status == 0 && Auth::user()->email_verified == 0)
    <!-- User Belum Aktif dan Belum Memverifikasi Email -->
    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-lg-12">
            <div class="alert alert-warning text-center shadow">
                <i class="fa fa-exclamation-triangle mr-2"></i> Verifikasi email Anda untuk dapat menuju ke tahap berikutnya. <strong>Cek inbox email Anda atau juga di folder spam untuk melakukan verifikasi email.</strong>
            </div>
        </div>
        <!-- /Column -->
    </div>
    <!-- /Row -->
    <!-- /User Belum Aktif dan Belum Memverifikasi Email -->
    @endif
</main>
<!-- /Main -->

@if(Auth::user()->status == 0 && Auth::user()->email_verified == 1)
<!-- Modal Konfirmasi -->
<div class="modal fade" id="modal-confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Pendaftaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-confirm" method="post" action="{{ route('member.komisi.confirm') }}" enctype="multipart/form-data">
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group col-12">
                            <label>Kode Pembayaran</label>
                            <input type="text" name="kode_pembayaran" class="form-control" value="{{ $komisi->inv_komisi }}" readonly>
                        </div>
                        <div class="form-group col-12">
                            <label>Upload Bukti Transfer <span class="text-danger">*</span></label>
                            <br>
                            <button type="button" class="btn btn-sm btn-info btn-browse-file mr-2"><i class="fa fa-folder-open mr-2"></i>Pilih File...</button>
                            <input type="file" id="file" name="foto" class="d-none" accept="image/*">
                            <br><br>
                            <img id="image" class="img-thumbnail d-none">
                        </div>
                        <input type="hidden" name="id_komisi">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" disabled>Konfirmasi</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Modal Konfirmasi -->
@endif
<div class="modal fade" id="modal-intro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header align-items-center">
                <img width="30" class="mr-3" src="{{asset('assets/images/icon/'.setting('site.icon'))}}">
                <h5 class="modal-title" id="exampleModalLabel">Selamat datang di {{ $deskripsi->judul_deskripsi }}</h5>
                <button type="button" class="close menu-btn-green" data-dismiss="modal" aria-label="Close" style="padding: .5em .7em; border-radius: .5em; margin-right: 0">
                    <span aria-hidden="true"><i class="fa fa-times"></i></span>
                </button>
            </div>
            <form id="form-confirm" method="post" action="{{ route('member.komisi.confirm') }}" enctype="multipart/form-data">
                <div class="modal-body">
                    <p>{{ $deskripsi->deskripsi }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn menu-btn-red" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js-extra')

<script type="text/javascript">
    // Button Confirm
    $(document).on("click", ".btn-confirm", function(e){
        e.preventDefault();
        $("#modal-confirm").modal("show");
    });

    // Change file
    $(document).on("change", "#file", function(){
        change_file(this, "image", 2);
    });
</script>
<script type="text/javascript">
    $(window).on('load', function() {
        $('#modal-intro').modal('show');
    });
</script>
<script type="text/javascript">
const span = document.getElementById('clicktocopy');

span.onclick = function() {
  document.execCommand("copy");
}

span.addEventListener("copy", function(event) {
  event.preventDefault();
  if (event.clipboardData) {
    event.clipboardData.setData("text/plain", span.textContent);
    alert("Berhasil menyalin " + event.clipboardData.getData("text"))
    // console.log(event.clipboardData.getData("text"))
  }
});

</script>
@endsection