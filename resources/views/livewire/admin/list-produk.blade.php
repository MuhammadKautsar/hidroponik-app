<div>
    @include('layouts.headers.cards')

    <div class="container-fluid mt--8">
        @if(session('sukses'))
            <div class="alert alert-success" role="alert">
                {{session('sukses')}}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger" role="alert">
                {{session('error')}}
            </div>
        @endif
      <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
                <div class="row mb-3">
                    <div class="col form-inline">
                        <h3>Produk</h3>
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
                        <select wire:model="bySatuan" class="form-select">
                            <option value="">- Satuan -</option>
                            <option value="gram">Gram</option>
                            <option value="Kg">Kg</option>
                            <option value="Ons">Ons</option>
                            <option value="Pcs">Pcs</option>
                            <option value="Pack">Pack</option>
                        </select>
                    </div>
                    <div class="col-md-3 ml-lg-auto float-right">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input wire:model="search" class="form-control" type="text" placeholder="Cari Produk...">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush table-hover">
                <thead class="thead-light">
                  <tr>
                    <th wire:click="sortBy('id')" style="cursor: pointer;" class="text-center" scope="col">
                        Id @include('partials._sort-icon',['field'=>'id'])
                    </th>
                    <th class="text-center" scope="col">Gambar</th>
                    <th wire:click="sortBy('nama')" style="cursor: pointer;" class="text-center" scope="col">
                        Nama @include('partials._sort-icon',['field'=>'nama'])
                    </th>
                    <th wire:click="sortBy('penjual_id')" style="cursor: pointer;" class="text-center" scope="col" class="sort">
                        Penjual @include('partials._sort-icon',['field'=>'penjual_id'])
                    </th>
                    <th wire:click="sortBy('promo_id')" style="cursor: pointer;" class="text-center" scope="col" class="sort">
                        Promo @include('partials._sort-icon',['field'=>'promo_id'])
                    </th>
                    <th wire:click="sortBy('harga')" style="cursor: pointer;" class="text-center" scope="col" class="sort">
                        Harga @include('partials._sort-icon',['field'=>'harga'])
                    </th>
                    <th wire:click="sortBy('stok')" style="cursor: pointer;" class="text-center" scope="col" class="sort">
                        Stok @include('partials._sort-icon',['field'=>'stok'])
                    </th>
                    <th wire:click="sortBy('satuan')" style="cursor: pointer;" class="text-center" scope="col" class="sort">
                        Satuan @include('partials._sort-icon',['field'=>'satuan'])
                    </th>
                    {{-- <th class="text-center" scope="col">Jumlah/Satuan</th> --}}
                    <th class="text-center" scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody class="list">
                  @php $no = 0 @endphp
                  @forelse($data_product as $item)
                    {{-- @php $no++ @endphp --}}
                    <tr>
                      <td class="text-center">#Produk{{$item['id']}}</td>
                      <td class="text-center">
                        @php($img = $item->images)
                        <img src="{{ $img[0]->path_image }}" width="100px" height="70px" alt="Image">
                      </td>
                      <td class="text-center">{{$item['nama']}}</td>
                      @php($seller = $item->penjual)
                      <td class="text-center">{{$seller->username}}</td>
                      <td class="text-center">
                        @if ($item->promo_id=="")
                          Tidak ada</td>
                        @elseif ($item->promo_id!="")
                        @php($diskon = $item->promo)
                        {{$diskon->potongan}} %</td>
                        @endif
                      <td class="text-center">Rp {{number_format($item['harga'],0,',','.')}}</td>
                      <td class="text-center">{{$item['stok']}}</td>
                      <td class="text-center">{{$item['satuan']}}</td>
                      {{-- <td class="text-center">{{$item['jumlah_per_satuan']}}</td> --}}
                      <td class="text-center">
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#showModal-{{ $item->id }}">
                            <i class="fa fa-eye"></i> Lihat
                        </button>
                        <a href="/produks/{{$item->id}}/delete" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau dihapus ?')"><i class="fa fa-trash"></i> Hapus</a>
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
                        Showing {{$data_product->firstItem()}} to {{$data_product->lastItem()}} out of {{$data_product->total()}} items
                    </li>
                    <li class="ml-lg-auto float-right">
                        {{ $data_product->links() }}
                    </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
      @include('layouts.footers.auth')
    </div>

    @foreach($data_product as $data)
    <!-- Modal Show-->
    <div class="modal fade" id="showModal-{{ $data->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail Produk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="/produk/{{$data->id}}/update" method="POST" enctype="multipart/form-data">
              <div class="mb-3">
                <label for="" class="form-label"><h3>Gambar :</h3></label><br>
                <br>@foreach ($data->images as $img)
                    <img src="{{ $img->path_image }}" width="150px" height="110px" alt="Image">&ensp;
                  @endforeach
              </div>
              <div class="mb-3"><br>
                <label for="" class="form-label"><h3>Jumlah/Satuan :</h3></label><br>
                <td class="text-center">{{$data['jumlah_per_satuan']}}</td>
              </div>
              <div class="mb-3"><br>
                <label for="" class="form-label"><h3>Keterangan :</h3></label><br>
                <td class="text-center">{{$data['keterangan']}}</td>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    @endforeach
</div>
