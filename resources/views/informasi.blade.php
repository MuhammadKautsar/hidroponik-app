@extends('layouts.app', ['class' => 'bg-silver'])
<div class="content">
@section('content')
    @include('layouts.headers.guest')

    <div class="container mt--9 pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-7">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="text-center mb-4">
                            <h2>
                                    Informasi Pendaftaran
                            </h2>
                        </div>
                        <div class="text-center mb-4">
                            <small>
                                Bagi yang ingin mendaftar menjadi Penjual di aplikasi AgriHub, silahkan hubungi Admin dibawah ini :
                                <br><br>
                                082167303899 &ensp;
                                082299887401
                                <br>
                                <normal style="color: blue;">ismuliajuli@gmail.com &ensp;
                                fachruddin@gmail.com</normal>
                                <br><br>
                                Dan memberikan data nama lengkap, username, email, nomor hp, alamat dan password yang akan digunakan oleh admin untuk keperluan pendaftaran akun penjual.
                            </small>
                        </div>
                        <hr size="5">
                        <div class="text-center mb-4">
                            <h2>
                                    Syarat Mendaftar
                            </h2>
                        </div>
                        <div class="text-center mb-4">
                            <small>
                                Berikut syarat untuk mendaftar sebagai penjual di aplikasi Agrihub yaitu :
                                <br><br>
                                <ol class="text-left mb-4">
                                    <li>Minimal usaha tanaman hidroponik sudah berjalan 1 tahun</li>
                                    <li>Siap mengikuti harga yang sudah ditetapkan bersama</li>
                                    <li>Memiliki minimal 1000 lubang tanam</li>
                                    <li>Sayuran yang dijual tidak disemprot pestisida</li>
                                </ol>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
</div>
