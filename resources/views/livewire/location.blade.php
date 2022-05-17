<div>
    @include('layouts.headers.cards')

    <div class="container-fluid mt--8">
      <div class="row">
        <div class="col">
            <div>
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @elseif (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                @endif
            </div>
          <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
                <div class="row mb-3">
                    <div class="col form-inline">
                        <h3>Tambah Lokasi</h3>
                    </div>
                </div>
                <hr size="5">
                <form autocomplete="off" wire:submit.prevent='saveLoc'>
                    <div class="row">
                        <div class="col-md-2 mt-2">
                            Kabupaten/Kota :
                        </div>
                        <div class="col-md-4 mt-1">
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
                        <div class="col form-inline">
                            <button type="submit" class="btn btn-success btn-sm ml-lg-auto float-right" data-bs-toggle="modal" data-bs-target="#form">
                                <i class="fa fa-plus"></i> Tambah Lokasi
                            </button>
                        </div>
                    </div>
                </form>
            </div>
          </div>
          <div class="card mt-4">
            <!-- Card header -->
            <div class="card-header border-0">
                <div class="row">
                    <div class="col form-inline">
                        <h3>Lokasi Aktif</h3>
                </div>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center" scope="col">
                        No.
                    </th>
                    <th class="text-center" scope="col">
                        Kode
                    </th>
                    <th class="text-center" scope="col">
                        Kabupaten/Kota
                    </th>
                    <th class="text-center" scope="col">aksi</th>
                  </tr>
                </thead>
                <tbody class="list">
                  @php $no = 0 @endphp
                  @foreach($data_lokasi as $item)
                    @foreach ($kotas as $kota)
                        @if($item->kode == $kota->kode)
                        @php $no++ @endphp
                        <tr>
                            <td class="text-center">{{$no}}</td>
                            <td class="text-center">{{$item['kode']}}</td>
                            <td class="text-center">{{$kota['nama']}}</td>
                            <td class="text-center">
                            @if(count($data_lokasi) > 1)
                                <a href="#" wire:click="remove({{$item->id}})" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</a>
                            @endif
                        </td>
                        </tr>
                        @endif
                    @endforeach
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- Card footer -->
            <div class="card-footer py-3">
            </div>
          </div>
        </div>
      </div>
      @include('layouts.footers.auth')
    </div>
</div>
