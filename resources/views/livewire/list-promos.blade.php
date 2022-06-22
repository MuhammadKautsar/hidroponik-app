<div>

    @include('layouts.headers.cards')

    <div class="container-fluid mt--8">
      <div class="row">
        @if(session('sukses'))
        <div class="alert alert-light" role="alert">
          {{session('sukses')}}
        </div>
        @endif
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
                <div class="row mb-3">
                    <div class="col form-inline">
                        <h3>Promo</h3>
                    </div>
                    @if (auth()->user()->level=="admin")
                    <div class="col form-inline">
                        <button type="button" class="btn btn-success btn-sm ml-lg-auto float-right" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="fa fa-plus"></i> Tambah
                        </button>
                    </div>
                    @endif
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
                            <input wire:model="search" class="form-control" type="text" placeholder="Cari Promo...">
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
                        <th class="text-center" scope="col">Gambar</th>
                        <th wire:click="sortBy('nama')" style="cursor: pointer;" class="text-center" scope="col">
                            Nama @include('partials._sort-icon',['field'=>'nama'])
                        </th>
                        <th wire:click="sortBy('potongan')" style="cursor: pointer;" class="text-center" scope="col">
                            Potongan @include('partials._sort-icon',['field'=>'potongan'])
                        </th>
                        <th wire:click="sortBy('awal_periode')" style="cursor: pointer;" class="text-center" scope="col">
                            Awal Periode @include('partials._sort-icon',['field'=>'awal_periode'])
                        </th>
                        <th wire:click="sortBy('akhir_periode')" style="cursor: pointer;" class="text-center" scope="col">
                            Akhir Periode @include('partials._sort-icon',['field'=>'akhir_periode'])
                        </th>
                        <th wire:click="sortBy('keterangan')" style="cursor: pointer;" class="text-center" scope="col">
                            Keterangan @include('partials._sort-icon',['field'=>'keterangan'])
                        </th>
                        <th class="text-center" scope="col">Aksi</th>
                    </tr>
                  </thead>
                  <tbody class="list">
                    {{-- @php $no = 0 @endphp --}}
                    @forelse($promo as $item)
                      {{-- @php $no++ @endphp --}}
                      <tr>
                        <td class="text-center">#Promo{{$item['id']}}</td>
                        <td class="text-center">
                        <img src="{{ $item->getPromoImage() }}" width="100px" height="70px" alt="Image">
                        </td>
                        <td class="text-center">{{$item['nama']}}</td>
                        <td class="text-center">{{$item['potongan']}} %</td>
                        <td class="text-center">{!! date('d-m-Y', strtotime($item->awal_periode)) !!}</td>
                        <td class="text-center">{!! date('d-m-Y', strtotime($item->akhir_periode)) !!}</td>
                        <td class="text-center">{{$item['keterangan']}}</td>
                        <td class="text-center">
                        @if (auth()->user()->level=="admin")
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-{{ $item->id }}">
                            <i class="fa fa-edit"></i> Ubah
                        </button>
                        @endif
                        <a href="/promo/{{$item->id}}/delete" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau dihapus ?')"><i class="fa fa-trash"></i> Hapus</a>
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
                            Showing {{$promo->firstItem()}} to {{$promo->lastItem()}} out of {{$promo->total()}} items
                        </li>
                        <li class="ml-lg-auto float-right">
                            {{ $promo->links() }}
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
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Tambah Promo</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="/promo/create" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Gambar</label>
                  <br>
                  <input name="gambar" type="file" id="image" aria-describedby="emailHelp"><br>
                  <br>
                  <div class="col-sm-6">
                    <img id="preview-image" src="/uploads/promos/no-image.png" alt="preview image" width="100px" height="70px">
                  </div>
                </div>
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Nama Promo</label>
                  <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="exampleInputEmail1" aria-describedby="emailHelp">
                  @error('nama')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Potongan(%)</label>
                  <input name="potongan" type="number" class="form-control @error('potongan') is-invalid @enderror" id="exampleInputEmail1">
                  @error('potongan')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1" class="form-label">Awal Periode</label>
                        <input name="awal_periode" type="text" placeholder="dd/mm/yyyy" class="date form-control @error('awal_periode') is-invalid @enderror">
                        @error('awal_periode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1" class="form-label">Akhir Periode</label>
                        <input name="akhir_periode" type="text" placeholder="dd/mm/yyyy" class="date form-control @error('akhir_periode') is-invalid @enderror">
                        @error('akhir_periode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Keterangan</label>
                  <textarea name="keterangan" type="text" class="form-control" id="exampleInputEmail1" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
              <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
              </form>
            </div>
          </div>
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
          <form action="/promo/{{$data->id}}/update" method="POST" enctype="multipart/form-data">
              {{csrf_field()}}
            <div class="mb-3">
              <label for="" class="form-label">Gambar</label><br>
              <input name="gambar" type="file" id="exampleInputEmail1" aria-describedby="emailHelp"><br>
              <br><img src="{{ $data->getPromoImage() }}" width="100px" height="70px" alt="Image">
            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Nama Promo</label>
              <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$data->nama}}">
              @error('nama')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Potongan (%)</label>
              <input name="potongan" type="number" class="form-control @error('potongan') is-invalid @enderror" id="exampleInputEmail1" value="{{$data->potongan}}">
              @error('potongan')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="exampleInputEmail1" class="form-label">Awal Periode</label>
                    <input name="awal_periode" type="text" class="date form-control @error('awal_periode') is-invalid @enderror" value="{!! date('d-m-Y', strtotime($data->awal_periode)) !!}">
                    @error('awal_periode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="exampleInputEmail1" class="form-label">Akhir Periode</label>
                    <input name="akhir_periode" type="text" class="date form-control @error('akhir_periode') is-invalid @enderror" value="{!! date('d-m-Y', strtotime($data->akhir_periode)) !!}">
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
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-times"></i> Close</button>
          <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  @endforeach

  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>

    $(".tm").on("change", function() {
    this.setAttribute(
        "data-date",
        moment(this.value, "YYYY-MM-DD")
        .format( this.getAttribute("data-date-format") )
    )
    }).trigger("change")

</script>

  <script>
    $('#image').change(function(){

      let reader = new FileReader();
      reader.onload = (e) => {
        $('#preview-image').attr('src', e.target.result);
      }
      reader.readAsDataURL(this.files[0]);

     });
     </script>

</div>
