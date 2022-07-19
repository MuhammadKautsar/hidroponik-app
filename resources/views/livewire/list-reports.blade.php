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
                        <h3>Keluhan</h3>
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
                    <div class="col-md-3 ml-lg-auto float-right">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input wire:model="search" class="form-control" type="text" placeholder="Cari Keluhan...">
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
                    <th wire:click="sortBy('tanggal')" style="cursor: pointer;" class="text-center" scope="col" class="sort">
                        Tanggal @include('partials._sort-icon',['field'=>'tanggal'])
                    </th>
                    <th wire:click="sortBy('isi_laporan')" style="cursor: pointer;" class="text-center" scope="col" class="sort">
                        Keluhan @include('partials._sort-icon',['field'=>'isi_laporan'])
                    </th>
                    <th wire:click="sortBy('pembeli_id')" style="cursor: pointer;" class="text-center" scope="col" class="sort">
                        Pengirim @include('partials._sort-icon',['field'=>'pembeli_id'])
                    </th>
                    <th wire:click="sortBy('penjual_id')" style="cursor: pointer;" class="text-center" scope="col" class="sort">
                        Penjual @include('partials._sort-icon',['field'=>'penjual_id'])
                    </th>
                    <th class="text-center" scope="col">aksi</th>
                  </tr>
                </thead>
                <tbody class="list">
                  {{-- @php $no = 0 @endphp --}}
                  @forelse($data_report as $item)
                    {{-- @php $no++ @endphp --}}
                    <tr>
                        <td class="text-center">#Keluhan{{$item['id']}}</td>
                      <td class="text-center">{!! date('d-m-Y', strtotime($item->tanggal)) !!}</td>
                      <td class="text-center">{{$item['isi_laporan']}}</td>
                      <td class="text-center">{{$item->pembeli->nama_lengkap}}</td>
                      <td class="text-center">{{$item->penjual->username}}</td>
                      <td class="text-center">
                        {{-- <button type="button" class="btn btn-light btn-sm float-right" data-bs-toggle="modal" data-bs-target="#editModal-{{ $item->id }}">
                          Balas
                        </button> --}}
                        <a href="/laporan/{{$item->id}}/delete" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau dihapus ?')"><i class="fa fa-trash"></i> Hapus</a>
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
                        Showing {{$data_report->firstItem()}} to {{$data_report->lastItem()}} out of {{$data_report->total()}} items
                    </li>
                    <li class="ml-lg-auto float-right">
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
