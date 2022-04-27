<div>
    @include('layouts.headers.cards')

    <div class="container-fluid mt--8">
      <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
                <div class="row mb-3">
                    <div class="col form-inline">
                        <h3>Pesanan</h3>
                    </div>
                    <div class="col form-inline">
                        <a href="{{ route('cetak-pesanan') }}" target="_blank" type="button" class="btn btn-warning btn-sm ml-lg-auto float-right text-white">
                            <i class="fa fa-file-pdf"></i> Export PDF
                        </a>
                    </div>
                </div>
                <hr size="5">
                <div class="row">
                    <div class="col-md-1 mt-2">
                        Page :
                    </div>
                    <div class="col-md-1 mt-1">
                        <select wire:model="perPage" class="form-select">
                            <option>5</option>
                            <option>10</option>
                            <option>25</option>
                        </select>
                    </div>
                    <div class="col-md-1 mt-2">
                        Filter :
                    </div>
                    <div class="col-md-2 mt-1">
                        <select wire:model="byStatus" class="form-select">
                            <option value="">- Status -</option>
                            <option value="Belum">Belum</option>
                            <option value="Diproses">Diproses</option>
                            <option value="Dikirim">Dikirim</option>
                            <option value="Selesai">Selesai</option>
                            <option value="Batal">Batal</option>
                        </select>
                    </div>
                    <div class="col-md-3 ml-lg-auto float-right">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input wire:model="search" class="form-control" type="text" placeholder="Cari Pesanan...">
                        </div>
                    </div>

                </div>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th wire:click="sortBy('id')" style="cursor: pointer;" class="text-center" scope="col" class="sort">
                        Id @include('partials._sort-icon',['field'=>'id'])
                    </th>
                    <th wire:click="sortBy('created_at')" style="cursor: pointer;" class="text-center" scope="col" class="sort">
                        Tanggal @include('partials._sort-icon',['field'=>'created_at'])
                    </th>
                    <th class="text-center" scope="col">Jam</th>
                    <th wire:click="sortBy('pembeli_id')" style="cursor: pointer;" class="text-center" scope="col" class="sort">
                        Pembeli @include('partials._sort-icon',['field'=>'pembeli_id'])
                    </th>
                    <th class="text-center" scope="col">Jumlah Item</th>
                    <th wire:click="sortBy('total_harga')" style="cursor: pointer;" class="text-center" scope="col" class="sort">
                        Total Harga @include('partials._sort-icon',['field'=>'total_harga'])
                    </th>
                    <th wire:click="sortBy('penjual_id')" style="cursor: pointer;" class="text-center" scope="col" class="sort">
                        Penjual @include('partials._sort-icon',['field'=>'penjual_id'])
                    </th>
                    <th wire:click="sortBy('status_order')" style="cursor: pointer;" class="text-center" scope="col" class="sort">
                        Status @include('partials._sort-icon',['field'=>'status_order'])
                    </th>
                    <th class="text-center" scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody class="list">
                  @forelse($data_order as $item)
                        @php $i = 0 @endphp
                        <tr>
                            <td class="text-center">#Agri{{$item['id']}}</td>
                            <td class="text-center">{{$item['created_at']->format('d-m-Y')}}</td>
                            <td class="text-center">{{$item['created_at']->format('H:i')}}</td>
                            <td class="text-center">{{$item->pembeli->nama_lengkap}}</td>
                            <td class="text-center">
                                @foreach ($item->order_mappings as $pesanan)
                                    @php $i++ @endphp
                                @endforeach
                                    {{$i}}
                            </td>
                            <td class="text-center">Rp{{number_format($item['total_harga']+$item['harga_jasa_pengiriman'],0,',','.')}},-</td>
                            <td class="text-center">{{$item->penjual->username}}</td>
                            <td class="text-center">{{$item['status_order']}}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-light btn-sm float-center" data-bs-toggle="modal" data-bs-target="#editModal-{{ $item->id }}">
                                    <i class="fa fa-info-circle"></i> Detail
                                </button>
                            </td>
                        </tr>
                  @empty
                    <tr class="text-center">
                        <td colspan="10">
                            <img src="{{asset('images/not_found.svg')}}" alt="" width="100px" height="70px">
                            <p class="mt-2">Tidak ada data</p>
                        </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
            <!-- Card footer -->
            <div class="card-footer py-4">
              <nav aria-label="...">
                <ul class="pagination justify-content mb-0">
                    <li class="ml-lg float-left">
                        Showing {{$data_order->firstItem()}} to {{$data_order->lastItem()}} out of {{$data_order->total()}} items
                    </li>
                    <li class="ml-lg-auto float-right">
                        {{ $data_order->links() }}
                    </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
      @include('layouts.footers.auth')
    </div>

    @foreach($data_order as $data)
    <!-- Modal -->
    <div class="modal fade" id="editModal-{{ $data->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail Pesanan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="/pesanan/{{$data->id}}/update" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Produk</label><br>
                    @foreach ($data->order_mappings as $pesanan)
                        <label style='text-align:right;' >- {{$pesanan->produk->nama}}</label><br>
                        <img src="{{ $pesanan->produk->images[0]->path_image }}" width="130px" height="90px" alt="Image">&emsp;&emsp;&emsp;&emsp;
                        <label style='text-align:right;' >Jumlah : {{$pesanan->jumlah}}</label>
                        @if ($pesanan->produk->promo_id=="")
                            <label style='text-align:right;' >&emsp;&emsp; Harga : Rp{{number_format($pesanan->produk->harga*$pesanan->jumlah,0,',','.')}},-</label><br>
                        @elseif ($pesanan->produk->promo_id!="")
                            <label style='text-align:right;' >&emsp;&emsp; Harga : Rp{{number_format(($pesanan->produk->harga-$pesanan->produk->harga*$pesanan->produk->promo->potongan/100)*$pesanan->jumlah,0,',','.')}},-</label><br>
                        @endif
                    @endforeach
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Nomor Hp Pembeli</label>
                    <input class="form-control" disabled placeholder="{{$data->pembeli->nomor_hp}}">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Harga Orderan</label>
                    <input class="form-control" disabled placeholder="Rp{{number_format($data['total_harga'],0,',','.')}},-">
                  </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Ongkir</label>
                    <input class="form-control" disabled placeholder="Rp{{number_format($data['harga_jasa_pengiriman'],0,',','.')}},-">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Alamat</label>
                    <textarea class="form-control" rows="3" disabled>{{$data->pembeli->alamat}}, Kec. {{$data->pembeli->kecamatan}}, {{$data->pembeli->kota}}</textarea>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    @endforeach
</div>
