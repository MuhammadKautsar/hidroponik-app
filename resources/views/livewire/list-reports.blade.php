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
                        <input wire:model="search" class="form-control" type="text" placeholder="Cari Laporan...">
                    </div>
                </div>
                <h3 class="mt-2">Laporan</h3>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center" scope="col" class="sort" data-sort="name">Id</th>
                    <th class="text-center" scope="col" class="sort" data-sort="budget">Tanggal</th>
                    <th class="text-center" scope="col" class="sort" data-sort="status">Laporan</th>
                    <th class="text-center" scope="col">Pelapor</th>
                    <th class="text-center" scope="col" class="sort" data-sort="completion">Penjual</th>
                    <th class="text-center" scope="col">aksi</th>
                  </tr>
                </thead>
                <tbody class="list">
                  @forelse($data_report as $item)
                    <tr>
                      <td class="text-center">{{$item['id']}}</td>
                      <td class="text-center">{!! date('d-m-Y', strtotime($item->tanggal)) !!}</td>
                      <td class="text-center">{{$item['isi_laporan']}}</td>
                      <td class="text-center">{{$item->pembeli->nama_lengkap}}</td>
                      <td class="text-center">{{$item->penjual->username}}</td>
                      <td class="text-center">
                        {{-- <button type="button" class="btn btn-light btn-sm float-right" data-bs-toggle="modal" data-bs-target="#editModal-{{ $item->id }}">
                          Balas
                        </button> --}}
                        <a href="/laporan/{{$item->id}}/delete" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau dihapus ?')">Hapus</a>
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
                  {{ $data_report->links() }}
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
      @include('layouts.footers.auth')
    </div>
</div>
