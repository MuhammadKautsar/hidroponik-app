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
                        <h3>Ulasan</h3>
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
                        <select wire:model="byRating" class="form-select">
                            <option value="">- Rating -</option>
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{$i}}" style="color:orange">
                                    @for($j = 1; $j <= $i; $j++)
                                            &#xf005;
                                    @endfor
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-3 ml-lg-auto float-right">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input wire:model="search" class="form-control" type="text" placeholder="Cari Ulasan...">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th wire:click="sortBy('id')" style="cursor: pointer;" class="text-center" scope="col">
                        Id @include('partials._sort-icon',['field'=>'id'])
                    </th>
                    <th wire:click="sortBy('produk_id')" style="cursor: pointer;" class="text-center" scope="col">
                        Nama Produk @include('partials._sort-icon',['field'=>'produk_id'])
                    </th>
                    <th wire:click="sortBy('user_id')" style="cursor: pointer;" class="text-center" scope="col">
                        Pembeli @include('partials._sort-icon',['field'=>'user_id'])
                    </th>
                    <th wire:click="sortBy('komentar')" style="cursor: pointer;" class="text-center" scope="col">
                        Komentar @include('partials._sort-icon',['field'=>'komentar'])
                    </th>
                    <th wire:click="sortBy('rating')" style="cursor: pointer;" class="text-center" scope="col">
                        Rating @include('partials._sort-icon',['field'=>'rating'])
                    </th>
                    <th class="text-center" scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody class="list">
                  @forelse($feedbacks as $item)
                    {{-- @if ($item->produk->penjual_id == Auth::user()->id && $item->produk->id == $item->produk_id) --}}
                        <tr>
                            <td class="text-center">#Ulasan{{$item['id']}}</td>
                            <td class="text-center">{{$item->produk->nama}}</td>
                            <td class="text-center">{{ $item->user->nama_lengkap }}</td>
                            <td class="text-center">{{$item['komentar']}}</td>
                            <td class="text-center">
                                @for($i = 0; $i < 5; $i++)
                                    <span><i class="fa fa-star{{ $item->rating <= $i ? '-o' : '' }}" style="color:orange"></i></span>
                                @endfor
                              </td>
                            <td class="text-center">
                                <a href="/ulasan/{{$item->id}}/delete" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau dihapus ?')"><i class="fa fa-trash"></i> Hapus</a>
                            </td>
                        </tr>
                    {{-- @endif --}}
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
                        Showing {{$feedbacks->firstItem()}} to {{$feedbacks->lastItem()}} out of {{$feedbacks->total()}} items
                    </li>
                    <li class="ml-lg-auto float-right">
                        {{ $feedbacks->links() }}
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
