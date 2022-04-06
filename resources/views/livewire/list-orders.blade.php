<div>
    @include('layouts.headers.cards')

    <div class="container-fluid mt--7">
        @if(session('status'))
        <div class="alert alert-danger" role="alert">
          {{session('status')}}
        </div>
        @endif
      <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
                <div class="row mb-3">
                    <div class="col form-inline">
                        <h3>Pesanan</h3>
                    </div>
                </div>
                <hr size="5">
                <div class="row">
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
                    <th wire:click="sortBy('harga_jasa_pengiriman')" style="cursor: pointer;" class="text-center" scope="col" class="sort">
                        Ongkir @include('partials._sort-icon',['field'=>'harga_jasa_pengiriman'])
                    </th>
                    <th wire:click="sortBy('total_harga')" style="cursor: pointer;" class="text-center" scope="col" class="sort">
                        Total Harga @include('partials._sort-icon',['field'=>'total_harga'])
                    </th>
                    <th wire:click="sortBy('status_order')" style="cursor: pointer;" class="text-center" scope="col" class="sort">
                        Status @include('partials._sort-icon',['field'=>'status_order'])
                    </th>
                    <th class="text-center" scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody class="list">
                  {{-- @php $no = 0 @endphp --}}
                  @forelse($data_order as $item)
                    @if ($item->penjual_id == Auth::user()->id)
                        {{-- @php $no++ @endphp --}}
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
                            <td class="text-center">Rp{{number_format($item['harga_jasa_pengiriman'],0,',','.')}},-</td>
                            <td class="text-center">Rp{{number_format($item['total_harga'],0,',','.')}},-</td>
                            <td class="text-center">{{$item['status_order']}}</td>
                            <td class="text-center">
                                @if ($item->status_order != "Selesai" && $item->status_order != "Batal")
                                <button type="button" class="btn btn-warning btn-sm float-center" data-bs-toggle="modal" data-bs-target="#editModal-{{ $item->id }}">
                                    <i class="fa fa-edit"></i> Tinjau
                                </button>
                                @endif
                            </td>
                        </tr>
                    @endif
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
                <ul class="pagination justify-content-end mb-0">
                  {{-- {{ $data_order->links() }} --}}
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
            <h5 class="modal-title" id="exampleModalLabel">Edit Pesanan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="/pesanan/{{$data->id}}/update" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Produk</label><br>
                    @foreach ($data->order_mappings as $pesanan)
                        <label style='text-align:right;' >- {{$pesanan->produk->nama}}</label><br>
                        <img src="{{ $pesanan->produk->images[0]->path_image }}" width="130px" height="90px" alt="Image">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                        <label style='text-align:right;' >Jumlah : {{$pesanan->jumlah}}</label><br>
                    @endforeach
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Nomor Hp Pembeli</label>
                    <span class="form-control">{{$data->pembeli->nomor_hp}}<a type="button" class="btn btn-success btn-sm float-right" href="https://wa.me/62{{$data->pembeli->nomor_hp}}"><i class="fab fa-whatsapp"></i> Hubungi</a></span>
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Ongkir</label>
                    @if (($data->harga_jasa_pengiriman==0))
                    <input name="harga_jasa_pengiriman" type="number" class="form-control @error('harga_jasa_pengiriman') is-invalid @enderror" value="{{$data->harga_jasa_pengiriman}}">
                    <small>Maksimal Rp 10.000 dan tidak dapat diubah lagi setelah diisi</small>
                    @elseif (($data->harga_jasa_pengiriman!=0))
                    <span class="form-control">{{$data->harga_jasa_pengiriman}}</span>
                    <input name="harga_jasa_pengiriman" type="hidden" class="form-control" value="{{$data->harga_jasa_pengiriman}}">
                    @endif
                    @error('harga_jasa_pengiriman')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                  <label for="" class="form-label">Status</label>
                  <select name="status_order" id="" class="form-control @error('status_order') is-invalid @enderror">
                    <option value="{{$data->status_order}}" hidden selected>{{$data->status_order}}</option>
                    @if ($data->status_order=="Belum")
                    <option value="Diproses">Diproses</option>
                    @elseif ($data->status_order=="Diproses")
                    <option value="Dikirim">Dikirim</option>
                    @elseif ($data->status_order=="Dikirim")
                    <option value="Selesai">Selesai</option>
                    @endif
                    <option value="Batal">Batal</option>
                  </select>
                  @error('status_order')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            <button type="submit" class="btn btn-warning"><i class="fa fa-save"></i> Update</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    @endforeach
</div>
