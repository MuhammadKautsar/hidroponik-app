<!DOCTYPE html>
<html>
<head>
    <style>
    #customers {
    font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
    }

    #customers td, #customers th {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: center;
    }

    #customers tr:nth-child(even){background-color: #f2f2f2;}

    #customers tr:hover {background-color: #ddd;}

    #customers th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: center;
    background-color: #04AA6D;
    color: white;
    }
    </style>

    <link href="{{ public_path('argon/img/brand/icon.png') }}" rel="icon" type="image/png">

    @php
        $order=App\Models\Order::where('penjual_id', '=', Auth::user()->id)->orderBy('created_at', 'desc')->first();
    @endphp

    <title>Data Pesanan {{$order->penjual->username}}</title>

</head>
<body>
    <div class="container">
        <div class="row">
            <img style="text-align: left; width: 130px; height: 40px;" src="{{ public_path('argon/img/brand/logo hitam.png') }}" />
        </div>
        {{-- <div class="row">
            <p style="text-align: right">Tanggal/Waktu: <?php echo date('j/m/Y H:i'); ?></p>
        </div> --}}
    </div>
    <center><h2>Data Pesanan {{$order->penjual->username}}</h2></center>

    <p>Berikut merupakan data pesanan dari penjual {{$order->penjual->username}} yang terdaftar di aplikasi AgriHub:</p>

    <table id="customers">
        <thead class="thead-light">
            <tr>
            <th class="text-center" scope="col" class="sort">
                Id
            </th>
            <th class="text-center" scope="col" class="sort">
                Tanggal
            </th>
            <th class="text-center" scope="col">Jam</th>
            <th class="text-center" scope="col" class="sort">
                Pembeli
            </th>
            <th class="text-center" scope="col">Produk</th>
            <th class="text-center" scope="col" class="sort">
                Harga Order
            </th>
            <th class="text-center" scope="col" class="sort">
                Ongkir
            </th>
            <th class="text-center" scope="col" class="sort">
                Status
            </th>
            </tr>
        </thead>
        <tbody class="list">
            @forelse($data_order as $item)
                @php $i = 0 @endphp
                @php $j = 0 @endphp
                <tr>
                    <td class="text-center">#Agri{{$item['id']}}</td>
                    <td class="text-center">{{$item['created_at']->format('d-m-Y')}}</td>
                    <td class="text-center">{{$item['created_at']->format('H:i')}}</td>
                    <td class="text-center">{{$item->pembeli->nama_lengkap}}</td>
                    <td class="text-center">
                        @foreach ($item->order_mappings as $pesanan)
                            @php $j++ @endphp
                                {{$pesanan->produk->nama}}
                            @if($j < $i)
                                ,
                            @endif
                        @endforeach
                    </td>
                    <td class="text-center">Rp{{number_format($item['total_harga'],0,',','.')}},-</td>
                    <td class="text-center">Rp{{number_format($item['harga_jasa_pengiriman'],0,',','.')}},-</td>
                    <td class="text-center">{{$item['status_order']}}</td>
                </tr>
            @empty
            @endforelse
        </tbody>
    </table>
<br>
    <div style="position: fixed; bottom: 0;">
        <div>
            &copy; {{ now()->year }} <a >AgriHub</a>
        </div>
    </div>

<script type="text/javascript">
    window.print();
</script>

</body>
</html>
