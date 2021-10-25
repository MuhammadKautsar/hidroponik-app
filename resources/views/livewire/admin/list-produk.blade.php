<div>
    @include('layouts.headers.cards')

    <div class="container-fluid mt--8">
      @if(session('sukses'))
        <div class="alert alert-light" role="alert">
          {{session('sukses')}}
        </div>
      @endif
      <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
              <!-- Button trigger modal -->
              <div class="navbar-search navbar-search-light form-inline mr-3 d-none d-md-flex ml-lg-auto float-right">
                <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                    <input wire:model="search" class="form-control" type="text" placeholder="Cari Produk...">
                </div>
              </div>
              <h3 class="mt-2">Produk</h3>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush table-hover">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center" scope="col">No</th>
                    <th class="text-center" scope="col">Gambar</th>
                    <th class="text-center" scope="col">Nama</th>
                    <th class="text-center" scope="col">Penjual</th>
                    <th class="text-center" scope="col">Promo</th>
                    <th class="text-center" scope="col">Harga</th>
                    <th class="text-center" scope="col">Stok</th>
                    <th class="text-center" scope="col">Keterangan</th>
                    <th class="text-center" scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody class="list">
                  @php $no = 0 @endphp
                  @forelse($data_product as $item)
                    @php $no++ @endphp
                    <tr>
                      <td class="text-center">{{$no}}</td>
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
                      <td class="text-center">{{$item['keterangan']}}</td>
                      <td class="text-center">
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#showModal-{{ $item->id }}">
                          Lihat
                        </button>
                        {{-- <form action="/produks/{{$item->id}}/delete" method="post">
                          <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau dihapus ?');" type="submit">Delete</button>
                          @csrf
                          @method('delete')
                        </form> --}}
                        <a href="/produks/{{$item->id}}/delete" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau dihapus ?')">Hapus</i></a>
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
                <ul class="pagination justify-content-end mb-0">
                  {{ $data_product->links() }}
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
                <label for="" class="form-label">Gambar</label><br>
                <br>@foreach ($data->images as $img)
                    <img src="{{ $img->path_image }}" width="150px" height="110px" alt="Image">
                  @endforeach
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
