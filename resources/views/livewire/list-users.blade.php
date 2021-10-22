<div>

    @include('layouts.headers.cards')

    <div class="container-fluid mt--8">
      <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-success btn-sm mt-2 float-right" data-bs-toggle="modal" data-bs-target="#form">
                  @if (auth()->user()->level=="superadmin")
                  Tambah Admin
                  @elseif (auth()->user()->level=="admin")
                  Tambah Penjual
                  @endif
                </button>
                {{-- <form class="navbar-search navbar-search-light form-inline mr-3 d-none d-md-flex ml-lg-auto float-right" method="GET" > --}}
                    <div class="navbar-search navbar-search-light form-inline mr-3 d-none d-md-flex ml-lg-auto float-right">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input wire:model="search" class="form-control" type="text" placeholder="Cari Pengguna...">
                        </div>
                    </div>
                {{-- </form> --}}
                <h3 class="mt-2">Pengguna</h3>
            </div>

              <!-- Light table -->
            <div class="table-responsive">
                <table class="table align-items-center table-flush table-hover">
                  <thead class="thead-light">
                    <tr>
                      <th class="text-center" scope="col">No</th>
                      <th class="text-center" scope="col">Foto</th>
                      <th class="text-center" scope="col">Nama</th>
                      <th class="text-center" scope="col">Username</th>
                      <th class="text-center" scope="col">Email</th>
                      <th class="text-center" scope="col">No Hp</th>
                      <th class="text-center" scope="col">Alamat</th>
                      <th class="text-center" scope="col">Level</th>
                      <th class="text-center" scope="col">Aksi</th>
                    </tr>
                  </thead>
                  <tbody class="list">
                    @forelse($data_user as $item)
                      <tr>
                        <td class="text-center">{{$item['id']}}</td>
                        <td class="text-center">
                          <img src="{{ $item->getProfileImage() }}" class="avatar avatar-sm rounded-circle" alt="Image">
                        </td>
                        <td class="text-center">{{$item['nama_lengkap']}}</td>
                        <td class="text-center">{{$item['username']}}</td>
                        <td class="text-center">{{$item['email']}}</td>
                        <td class="text-center">{{$item['nomor_hp']}}</td>
                        <td class="text-center">{{$item['alamat']}}</td>
                        <td class="text-center">{{$item['level']}}</td>
                        <td class="text-center">
                          @if ($item->status == 1)
                          <a href="{{ route('users.status.update', ['user_id' => $item->id, 'status_code' => 0]) }}"
                            class="btn btn-danger m-2">
                              <i class="fa fa-ban"></i>
                          </a>
                          @else
                          <a href="{{ route('users.status.update', ['user_id' => $item->id, 'status_code' => 1]) }}"
                            class="btn btn-success m-2">
                              <i class="fa fa-check"></i>
                          </a>
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
                  <ul class="pagination justify-content-end mb-0">
                    {{ $data_user->links() }}
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
              <label for="" class="form-label">Password</label>
              <input wire:model="password" type="password" class="form-control @error('password') is-invalid @enderror">
              @error('password')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="" class="form-label">Level</label>
              <select wire:model="level" class="form-control @error('level') is-invalid @enderror">
                <option value="">-Pilih-</option>
                @if (auth()->user()->level=="superadmin")
                <option value="admin">Admin</option>
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
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Submit</button>
        </div>
      </div>
      </form>
    </div>
  </div>

</div>
