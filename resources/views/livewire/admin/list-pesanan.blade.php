<div>
    @include('layouts.headers.cards')

    <div class="container-fluid mt--8">
      <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
                <div class="navbar-search navbar-search-light form-inline mr-3 d-none d-md-flex ml-lg-auto float-right">
                    <div class="input-group input-group-alternative">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                        <input wire:model="search" class="form-control" type="text" placeholder="Cari Pesanan...">
                    </div>
                </div>
                <h3 class="mt-2">Pesanan</h3>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center" scope="col" class="sort" data-sort="name">Id</th>
                    <th class="text-center" scope="col" class="sort" data-sort="budget">Tanggal</th>
                    <th class="text-center" scope="col" class="sort" data-sort="status">Pembeli</th>
                    <th class="text-center" scope="col">Produk</th>
                    <th class="text-center" scope="col" class="sort" data-sort="completion">Jumlah</th>
                    <th class="text-center" scope="col" class="sort" data-sort="completion">Total Harga</th>
                    <th class="text-center" scope="col" class="sort" data-sort="completion">Status</th>
                    @if (auth()->user()->level=="penjual")
                    <th class="text-center" scope="col">Aksi</th>
                    @endif
                  </tr>
                </thead>
                <tbody class="list">
                  @foreach($data_order as $item)
                    <tr>
                      <td class="text-center">{{$item['id']}}</td>
                      <td class="text-center">{{$item['created_at']->format('d-m-Y')}}</td>
                      <td class="text-center">{{$item->pembeli->nama_lengkap}}</td>
                      <td class="text-center">{{$item->produk->nama}}</td>
                      <td class="text-center">{{$item['jumlah']}}</td>
                      <td class="text-center">Rp {{number_format($item['total_harga'],0,',','.')}}</td>
                      <td class="text-center">{{$item['status_order']}}</td>
                      @if (auth()->user()->level=="penjual")
                      <td class="text-center">
                        <button type="button" class="btn btn-warning btn-sm float-center" data-bs-toggle="modal" data-bs-target="#editModal-{{ $item->id }}">
                          Tinjau
                        </button>
                      </td>
                      @endif
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- Card footer -->
            <div class="card-footer py-4">
              <nav aria-label="...">
                <ul class="pagination justify-content-end mb-0">
                  {{ $data_order->links() }}
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
      @include('layouts.footers.auth')
    </div>
</div>
