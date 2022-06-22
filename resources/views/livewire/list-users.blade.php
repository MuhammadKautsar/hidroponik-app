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
                        <h3>Pengguna</h3>
                    </div>
                    <div class="col-md-3 ml-lg-auto float-right">
                        {{-- <a href="lokasi" type="button" class="btn btn-primary btn-sm">
                            <i class="bi bi-geo-alt-fill"></i> Atur Lokasi
                        </a> --}}
                        <button type="button" class="btn btn-success btn-sm ml-lg-auto float-right" data-bs-toggle="modal" data-bs-target="#form">
                            @if (auth()->user()->level=="superadmin")
                            <i class="fa fa-plus"></i> Tambah Admin
                            @elseif (auth()->user()->level=="admin")
                            <i class="fa fa-plus"></i> Tambah Penjual
                            @endif
                        </button>
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
                        <select wire:model="byLevel" class="form-select">
                            <option value="">- Level -</option>
                            <option value="admin">Admin</option>
                            <option value="penjual">Penjual</option>
                            <option value="Pembeli">Pembeli</option>
                        </select>
                    </div>
                    <div class="col-md-3 ml-lg-auto float-right">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input wire:model="search" class="form-control" type="text" placeholder="Cari Pengguna...">
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
                        <th class="text-center" scope="col">Foto</th>
                        <th wire:click="sortBy('nama_lengkap')" style="cursor: pointer;" class="text-center" scope="col">
                            Nama @include('partials._sort-icon',['field'=>'nama_lengkap'])
                        </th>
                        <th wire:click="sortBy('username')" style="cursor: pointer;" class="text-center" scope="col">
                            Username @include('partials._sort-icon',['field'=>'username'])
                        </th>
                        <th wire:click="sortBy('email')" style="cursor: pointer;" class="text-center" scope="col">
                            Email @include('partials._sort-icon',['field'=>'email'])
                        </th>
                        <th wire:click="sortBy('nomor_hp')" style="cursor: pointer;" class="text-center" scope="col">
                            No Hp @include('partials._sort-icon',['field'=>'nomor_hp'])
                        </th>
                        <th wire:click="sortBy('level')" style="cursor: pointer;" class="text-center" scope="col">
                            Level @include('partials._sort-icon',['field'=>'level'])
                        </th>
                        <th class="text-center" scope="col">Aksi</th>
                    </tr>
                  </thead>
                  <tbody class="list">
                    {{-- @php $no = 0 @endphp --}}
                    @forelse($data_user as $item)
                      {{-- @php $no++ @endphp --}}
                      @php $tidak = 0 @endphp
                      @php $boleh = 0 @endphp
                      <tr>
                        <td class="text-center">#User{{$item['id']}}</td>
                        <td class="text-center">
                          <img src="{{ $item->getProfileImage() }}" class="avatar avatar-sm rounded-circle" alt="Image">
                        </td>
                        <td class="text-center">{{$item['nama_lengkap']}}</td>
                        <td class="text-center">{{$item['username']}}</td>
                        <td class="text-center">{{$item['email']}}</td>
                        <td class="text-center">{{$item['nomor_hp']}}</td>
                        <td class="text-center">{{$item['level']}}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-light btn-sm float-center" data-bs-toggle="modal" data-bs-target="#showModal-{{ $item->id }}">
                                <i class="fa fa-info-circle"></i>
                            </button>
                            @if ($item->level == "pembeli")
                                @foreach ($item->orderpembelis as $pesanan)
                                    @if($pesanan->status_order == "Belum" || $pesanan->status_order == "Diproses" || $pesanan->status_order == "Dikirim")
                                        @php $tidak++ @endphp
                                    @else
                                        @php $boleh++ @endphp
                                    @endif
                                @endforeach
                            @elseif ($item->level == "penjual")
                                @foreach ($item->orderpenjuals as $pesanan)
                                    @if($pesanan->status_order == "Belum" || $pesanan->status_order == "Diproses" || $pesanan->status_order == "Dikirim")
                                        @php $tidak++ @endphp
                                    @else
                                        @php $boleh++ @endphp
                                    @endif
                                @endforeach
                            @endif
                            @if (auth()->user()->level=="superadmin")
                                @if ($tidak == 0 && $item->level != "superadmin")
                                    @if ($item->status == 1)
                                    <a href="{{ route('users.status.update', ['user_id' => $item->id, 'status_code' => 0]) }}"
                                    class="btn btn-warning btn-sm m-2">
                                        <i class="fa fa-ban"></i>
                                    </a>
                                    @else
                                    <a href="{{ route('users.status.update', ['user_id' => $item->id, 'status_code' => 1]) }}"
                                   class="btn btn-success btn-sm m-2">
                                        <i class="fa fa-check"></i>
                                    </a>
                                    @endif
                                    <a href="/pengguna/{{$item->id}}/delete" class="btn btn-danger btn-sm m-2" onclick="return confirm('Yakin mau dihapus ?')"><i class="fa fa-trash"></i></a>
                                @endif
                            @elseif(auth()->user()->level=="admin")
                                @if ($tidak == 0 && $item->level != "superadmin" && $item->level != "admin")
                                    @if ($item->status == 1)
                                    <a href="{{ route('users.status.update', ['user_id' => $item->id, 'status_code' => 0]) }}"
                                    class="btn btn-warning btn-sm m-2">
                                        <i class="fa fa-ban"></i>
                                    </a>
                                    @else
                                    <a href="{{ route('users.status.update', ['user_id' => $item->id, 'status_code' => 1]) }}"
                                    class="btn btn-success btn-sm m-2">
                                        <i class="fa fa-check"></i>
                                    </a>
                                    @endif
                                    <a href="/pengguna/{{$item->id}}/delete" class="btn btn-danger btn-sm m-2" onclick="return confirm('Yakin mau dihapus ?')"><i class="fa fa-trash"></i></a>
                                @endif
                            @endif
                        </td>
                      </tr>
                    @empty
                      <tr class="text-center">
                          <td colspan="10">
                              <img src="{{asset('images/not_found.svg')}}" alt="" width="100px" height="70px">
                              <p class="mt-2">Pencarian tidak ditemukan</p>
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
                            Showing {{$data_user->firstItem()}} to {{$data_user->lastItem()}} out of {{$data_user->total()}} items
                        </li>
                        <li class="ml-lg-auto float-right">
                            {{ $data_user->links() }}
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
      </div>
    </div>
      @include('layouts.footers.auth')
    </div>

    <!-- Modal add -->
  <div class="modal fade" id="form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog">
      <form autocomplete="off" wire:submit.prevent='createUser'>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">
            @if (auth()->user()->level=="superadmin")
            Tambah Admin
            @elseif (auth()->user()->level=="admin")
            Tambah Penjual
            @endif
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
              <label for="" class="form-label">Nama Lengkap</label>
              <input wire:model="nama_lengkap" type="text" class="form-control @error('nama_lengkap') is-invalid @enderror">
              @error('nama_lengkap')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="" class="form-label">Username</label>
              <input wire:model="username" type="text" class="form-control @error('username') is-invalid @enderror">
              @error('username')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="" class="form-label">Email</label>
              <input wire:model="email" type="text" class="form-control @error('email') is-invalid @enderror">
              @error('email')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="" class="form-label">Nomor Hp</label>
              <input wire:model="nomor_hp" type="number" class="form-control @error('nomor_hp') is-invalid @enderror">
              @error('nomor_hp')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="exampleInputEmail1" class="form-label">Kabupaten/Kota</label>
                    <select name="kota" wire:model="selectedKota" class="form-select @error('kota') is-invalid @enderror">
                        <option value="">- Pilih -</option>
                        @foreach ($kotas as $kota)
                            <option value="{{ $kota->kode }}">{{ $kota->nama }}</option>
                        @endforeach
                    </select>
                    @error('kota')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="exampleInputEmail1" class="form-label">Kecamatan</label>
                    <select name="kecamatan" wire:model="selectedKecamatan" class="form-select @error('kecamatan') is-invalid @enderror">
                        <option value="">- Pilih -</option>
                        @foreach ($kecamatans as $kecamatan)
                            <option value="{{ $kecamatan->nama }}">{{ $kecamatan->nama }}</option>
                        @endforeach
                    </select>
                    @error('kecamatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Alamat</label>
                <textarea wire:model="alamat" type="text" class="form-control @error('alamat') is-invalid @enderror" rows="2"></textarea>
                @error('alamat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            @if(auth()->user()->level=="admin")
            <div class="mb-3">
                <label for="" class="form-label">Foto KTP</label>
                <input wire:model="foto_ktp" type="file" class="form-control @error('foto_ktp') is-invalid @enderror">
                @error('foto_ktp')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            @endif
            <div class="mb-3">
                <label for="" class="form-label">Password</label>
                <input wire:model="password" type="password" class="form-control @error('password') is-invalid @enderror">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
              <label for="" class="form-label">Level</label>
              <select wire:model="level" class="form-select @error('level') is-invalid @enderror">
                <option value="">- Pilih -</option>
                @if (auth()->user()->level=="superadmin")
                <option value="admin">Admin</option>
                {{-- <option value="penjual">Penjual</option> --}}
                @elseif (auth()->user()->level=="admin")
                <option value="penjual">Penjual</option>
                @endif
              </select>
              @error('level')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
          <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
        </div>
      </div>
      </form>
    </div>
  </div>

  @foreach($data_user as $data)
    <!-- Modal -->
    <div class="modal fade" id="showModal-{{ $data->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Info Pengguna</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="/pesanan/{{$data->id}}/update" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Status</label>
                  @if ($data->email_verified_at != "")
                  <input disabled class="form-control" placeholder="Sudah Verifikasi"></input>
                  @else
                  <input disabled class="form-control" placeholder="Belum Verifikasi"></input>
                  @endif
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Alamat</label>
                    <textarea disabled class="form-control" rows="3" placeholder="{{$data->alamat}}, {{$data->kecamatan}}, {{$data->kota}}"></textarea>
                </div>
                @if ($data->level == "penjual")
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Foto KTP</label><br>
                    @if($data->foto_ktp!="")
                    <img src="{{ asset('images/' .$data->foto_ktp) }}" width="170px" height="120px">
                    @else
                    <img src="{{ asset('uploads/promos/no-image.png') }}" width="150px" height="110px">
                    @endif
                </div>
                @endif
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    @endforeach

</div>
