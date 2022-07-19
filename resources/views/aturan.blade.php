@extends('layouts.app', ['title' => __('User Profile')])

@section('content')
    @include('layouts.headers.cards')

    <div class="container-fluid mt--8">
      <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
                <div class="row mb-3">
                    <div class="col form-inline">
                        <h3>Aturan</h3>
                    </div>
                </div>
                <hr size="5">
                <div class="row">
                    <div class="text-center mb-4">
                            Berikut aturan yang harus dipatuhi oleh para penjual di aplikasi Agrihub yaitu :
                            <br><br>
                            <ol class="text-left mb-4">
                                <li>Gambar produk yang diunggah merupakan foto produk asli.</li>
                                <li>Pemberian nama produk harus lengkap dan jelas.</li>
                                <li>Dilarang menetapkan harga yang tidak wajar pada produk yang dijual.</li>
                                <li>Segera memproses pesanan dari pembeli paling lama 2 hari.</li>
                                <li>Menggunakan foto profil usaha.</li>
                                <li>Menjaga kualitas produk yang dijual.</li>
                            </ol>
                            <br>
                            <h4 class="text-center">Apabila penjual melanggar maka akan dikenakan <strong style="color: red;">sanksi</strong> berupa <strong style="color: red;">pemblokiran akun</strong></h4>
                    </div>
                </div>
                <div class="card-footer mt-4">
                    <nav aria-label="...">
                        <ul class="pagination justify-content mb-0">
                        </ul>
                    </nav>
                </div>
            </div>

          </div>
        </div>
      </div>
      @include('layouts.footers.auth')
    </div>
@endsection
