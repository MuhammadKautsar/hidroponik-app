<div>

    @include('layouts.headers.cards')

    <div class="container-fluid mt--7">
      <div class="row">
        {{-- @if(session('sukses'))
        <div class="alert alert-light" role="alert">
          {{session('sukses')}}
        </div>
        @endif --}}
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
                <!-- Button trigger modal -->
                <button wire:click.prevent='addNew' type="button" class="btn btn-success btn-sm float-right">
                    Tambah
                </button>
                <h3 class="mb-0">Promo</h3>
              </div>
              <!-- Light table -->
              <div class="table-responsive">
                <table class="table align-items-center table-flush table-hover">
                  <thead class="thead-light">
                    <tr>
                        <th class="text-center" scope="col">Id</th>
                        <th class="text-center" scope="col">Gambar</th>
                        <th class="text-center" scope="col">Nama</th>
                        <th class="text-center" scope="col">Potongan</th>
                        <th class="text-center" scope="col">Awal Periode</th>
                        <th class="text-center" scope="col">Akhir Periode</th>
                        <th class="text-center" scope="col">Keterangan</th>
                        <th class="text-center" scope="col">Aksi</th>
                    </tr>
                  </thead>
                  <tbody class="list">
                    @foreach($promo as $item)
                      <tr>
                        <td class="text-center">{{$item['id']}}</td>
                        <td class="text-center">
                        <img src="{{ asset('storage/promo/'.$item->gambar) }}" width="100px" height="70px" alt="Image">
                        </td>
                        <td class="text-center">{{$item['nama']}}</td>
                        <td class="text-center">{{$item['potongan']}} %</td>
                        <td class="text-center">{{$item['awal_periode']}}</td>
                        <td class="text-center">{{$item['akhir_periode']}}</td>
                        <td class="text-center">{{$item['keterangan']}}</td>
                        <td class="text-center">
                        <button type="button" class="btn btn-primary btn-sm float-left" data-bs-toggle="modal" data-bs-target="#editModal-{{ $item->id }}">
                            Edit
                        </button>
                        <a href="/promo/{{$item->id}}/delete" class="btn btn-danger btn-sm float-right" onclick="return confirm('Yakin mau dihapus ?')">Delete</a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- Card footer -->
              <div class="card-footer py-4">
                <nav aria-label="...">
                  <ul class="pagination justify-content-end mb-0">
                    {{ $promo->links() }}
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
      <form wire:submit.prevent='createPromo'>
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Promo</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Gambar</label>
                    <br>
                    <input type="file" wire:model="gambar">
                    <br>
                    @if ($gambar)
                        <br><img src="{{ $gambar->temporaryUrl() }}" width="100px" height="70px">
                    @endif
                    @error('gambar') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Nama Promo</label>
                <input wire:model="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="exampleInputEmail1" aria-describedby="emailHelp">
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                </div>
                <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Potongan(%)</label>
                <input wire:model="potongan" type="number" class="form-control @error('potongan') is-invalid @enderror" id="exampleInputEmail1">
                @error('potongan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1" class="form-label">Awal Periode</label>
                        <input wire:model="awal_periode" type="date" class="form-control @error('awal_periode') is-invalid @enderror" id="exampleInputEmail1" aria-describedby="emailHelp">
                        @error('awal_periode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1" class="form-label">Akhir Periode</label>
                        <input wire:model="akhir_periode" type="date" class="form-control @error('akhir_periode') is-invalid @enderror" id="exampleInputEmail1" aria-describedby="emailHelp">
                        @error('akhir_periode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Keterangan</label>
                <textarea wire:model="keterangan" type="text" class="form-control" id="exampleInputEmail1" rows="3"></textarea>
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

  @foreach($promo as $data)
  <!-- Modal edit -->
  <div class="modal fade" id="editModal-{{ $data->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Promo</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="/promo/{{$data->id}}/update" method="POST">
              {{csrf_field()}}
            <div class="mb-3">
              <label for="" class="form-label">Gambar</label><br>
              <input name="gambar" type="file" id="exampleInputEmail1" aria-describedby="emailHelp"><br>
              <br><img src="{{ asset('storage/promo/'.$data->gambar) }}" width="100px" height="70px" alt="Image">
            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Nama Promo</label>
              <input name="nama" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$data->nama}}">
            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Potongan (%)</label>
              <input name="potongan" type="number" class="form-control" id="exampleInputEmail1" value="{{$data->potongan}}">
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="exampleInputEmail1" class="form-label">Awal Periode</label>
                    <input name="awal_periode" type="date" class="form-control @error('awal_periode') is-invalid @enderror" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$data->awal_periode}}">
                    @error('awal_periode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="exampleInputEmail1" class="form-label">Akhir Periode</label>
                    <input name="akhir_periode" type="date" class="form-control @error('akhir_periode') is-invalid @enderror" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$data->awal_periode}}">
                    @error('akhir_periode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Keterangan</label>
              <textarea name="keterangan" type="text" class="form-control" id="exampleInputEmail1" rows="3">{{$data->keterangan}}</textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  @endforeach

</div>
