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
                        <input wire:model="search" class="form-control" type="text" placeholder="Cari Ulasan...">
                    </div>
                </div>
                <h3 class="mt-2">Ulasan</h3>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center" scope="col" class="sort" data-sort="name">No</th>
                    <th class="text-center" scope="col" class="sort" data-sort="budget">Nama Produk</th>
                    <th class="text-center" scope="col" class="sort" data-sort="status">Pembeli</th>
                    <th class="text-center" scope="col">Komentar</th>
                    <th class="text-center" scope="col" class="sort" data-sort="completion">Rating</th>
                    <th class="text-center" scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody class="list">
                  @php $no = 0 @endphp
                  @forelse($feedbacks as $item)
                  @php $no++ @endphp
                    <tr>
                      <td class="text-center">{{$no}}</td>
                      <td class="text-center">{{$item->produk->nama}}</td>
                      <td class="text-center">{{ $item->user->nama_lengkap }}</td>
                      <td class="text-center">{{$item['komentar']}}</td>
                      <td class="text-center">
                        @for($i = 0; $i < 5; $i++)
                            <span><i class="fa fa-star{{ $item->rating <= $i ? '-o' : '' }}" style="color:orange"></i></span>
                        @endfor
                      </td>
                      <td class="text-center">
                        <a href="/umpanbalik/{{$item->id}}/delete" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau dihapus ?')">Hapus</a>
                      </td>
                    </tr>
                  @empty
                    <tr class="text-center">
                        <td colspan="10">
                            <img src="{{asset('images/not_found.svg')}}" alt="" width="100px" height="70px">
                            @if ($feedbacks != null)
                            <p class="mt-2">Pencarian tidak ditemukan</p>
                            @else
                            <p class="mt-2">Tidak ada data</p>
                            @endif
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
                  {{ $feedbacks->links() }}
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
      @include('layouts.footers.auth')
    </div>
</div>
