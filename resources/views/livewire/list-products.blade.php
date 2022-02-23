<div>
    @include('layouts.headers.cards')

    <div class="container-fluid mt--7">
      @if(session('sukses'))
        <div class="alert alert-light" role="alert">
          {{session('sukses')}}
        </div>
      @endif
      <style>
        .images-preview-div img
        {
        padding: 10px;
        max-width: 100px;
        }
      </style>
      <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
              <!-- Button trigger modal -->
              <button type="button" class="btn btn-success mt-2 btn-sm float-right" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="fa fa-plus"></i> Tambah
              </button>
              <div class="navbar-search navbar-search-light form-inline mr-3 d-none d-md-flex ml-lg-auto float-right">
                <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                    <input wire:model="search" class="form-control" type="text" placeholder="Cari Produk...">
                </div>
            </div>
              <h3 class="mt-2">Produk</h3>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush table-hover">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center" scope="col">No</th>
                    <th class="text-center" scope="col">Gambar</th>
                    <th class="text-center" scope="col">Nama</th>
                    <th class="text-center" scope="col">Promo</th>
                    <th class="text-center" scope="col">Harga</th>
                    <th class="text-center" scope="col">Stok</th>
                    <th class="text-center" scope="col">Satuan</th>
                    <th class="text-center" scope="col">Jumlah/Satuan</th>
                    {{-- <th class="text-center" scope="col">Harga Promo</th> --}}
                    <th class="text-center" scope="col">Keterangan</th>
                    <th class="text-center" scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody class="list">
                  @php $no = 0 @endphp
                  @forelse($data_product as $item)
                  @if ($item->penjual_id == Auth::user()->id)
                    @php $no++ @endphp
                    <tr>
                      <td class="text-center">{{$no}}</td>
                      <td class="text-center">
                        @php($img = $item->images)
                        <img src="{{ $img[0]->path_image }}" width="100px" height="70px" alt="Image">
                      </td>
                      <td class="text-center">{{$item['nama']}}</td>
                      <td class="text-center">
                        @if ($item->promo_id=="")
                            Tidak ada</td>
                        @elseif ($item->promo_id!="")
                        @php($diskon = $item->promo)
                            {{$diskon->potongan}} %</td>
                        @endif
                      <td class="text-center">
                        @if ($item->promo_id=="")
                            Rp {{number_format($item['harga'],0,',','.')}}</td>
                        @elseif ($item->promo_id!="")
                        @php($diskon = $item->promo)
                            Rp {{number_format($item['harga_promo'],0,',','.')}}</td>
                        @endif
                      <td class="text-center">{{$item['stok']}}</td>
                      <td class="text-center">{{$item['satuan']}}</td>
                      <td class="text-center">{{$item['jumlah_per_satuan']}}</td>
                      <td class="text-center">{{ Str::limit($item->keterangan, 25) }}</td>
                      <td class="text-center">
                        <a href="/produk/{{$item->id}}/edit" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Ubah</a>
                        <a href="/produk/{{$item->id}}/delete" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau dihapus ?')"><i class="fa fa-trash"></i> Hapus</a>
                      </td>
                    </tr>
                    @endif
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
                  {{-- {{ $data_product->links() }} --}}
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
      @include('layouts.footers.auth')
    </div>

    <!-- Modal Add-->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Tambah Produk</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="/produk/create" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Cover</label><br>
                  <input name="gambar" type="file">
                </div> --}}
                <div class="mb-3">
                  <label for="" class="form-label">Gambar</label><br>
                  <input name="gambar[]" multiple type="file" class="@error('gambar') is-invalid @enderror" id="images" aria-describedby="emailHelp"><br>
                  @error('gambar')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                  <br>
                  <div class="col-md-12">
                    <div class="mt-1 text-center">
                    <div class="images-preview-div"> </div>
                    </div>
                  </div>
                </div>
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Nama Produk</label>
                  <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror">
                  @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Promo</label>
                  <select name="promo_id" class="form-control @error('promo_id') is-invalid @enderror">
                      <option value="">- Pilih -</option>
                      @foreach ($promo as $item)
                          <option value="{{ $item->id }}">{{ $item->nama }} - {{ $item->potongan }} %</option>
                      @endforeach
                  </select>
                  @error('promo_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Harga</label>
                  <input name="harga" type="number" class="form-control @error('harga') is-invalid @enderror">
                  @error('harga')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Stok</label>
                  <input name="stok" type="number" class="form-control @error('stok') is-invalid @enderror">
                  @error('stok')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Satuan</label>
                    <select name="satuan" class="form-control @error('satuan') is-invalid @enderror">
                        <option value="gram">Gram</Gption>
                        <option value="Kg">Kg</option>
                        <option value="Ons">Ons</option>
                        <option value="Pcs">Pcs</option>
                        <option value="Pack">Pack</option>
                    </select>
                    @error('satuan')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Jumlah per Satuan</label>
                  <input name="jumlah_per_satuan" type="number" class="form-control @error('jumlah_per_satuan') is-invalid @enderror">
                  @error('jumlah_per_satuan')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Keterangan</label>
                  <textarea name="keterangan" type="text" class="form-control @error('keterangan') is-invalid @enderror" rows="3"></textarea>
                  @error('keterangan')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-times"></i> Close</button>
              <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Submit</button>
              </form>
            </div>
          </div>
        </div>
      </div>

    @foreach($data_product as $data)
    <!-- Modal Edit-->
    <div class="modal fade" id="editModal-{{ $data->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit Produk</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

              <form action="/produk/{{$data->id}}/update" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('put')
                <div class="mb-3">
                  <label for="" class="form-label">Gambar</label><br>
                  <input name="gambar[]" multiple type="file" id="image" aria-describedby="emailHelp"><br>
                  <br>{{-- <div class="col-lg-3"> --}}
                    @foreach ($data->images as $img)
                    @if (count($data->images)>1)
                    <img src="{{ $img->path_image }}" width="100px" height="70px" alt="">
                    <a href="/deleteimage/{{ $img->id }}"
                       class="text-red"> X
                      </a>
                    @endif
                    @endforeach
                </div>
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Nama Produk</label>
                  <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" value="{{$data->nama}}">
                  @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Promo</label>
                  <select name="promo_id" class="form-control @error('promo_id') is-invalid @enderror">
                      <option value="">- Pilih -</option>
                      @php($diskon = $data->promo)
                      @foreach ($promo as $diskon)
                          <option value="{{ $diskon->id }}" {{ old('promo_id') == $diskon->id ? 'selected' : null }}>{{ $diskon->nama }} - {{ $diskon->potongan }} %</option>
                      @endforeach
                  </select>
                  @error('promo_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Harga</label>
                  <input name="harga" type="number" class="form-control" value="{{$data->harga}}">
                </div>
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Stok</label>
                  <input name="stok" type="number" class="form-control" value="{{$data->stok}}">
                </div>
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Keterangan</label>
                  <textarea name="keterangan" type="text" class="form-control" rows="3">{{$data->keterangan}}</textarea>
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

<script >
$(function() {
// Multiple images preview with JavaScript
var previewImages = function(input, imgPreviewPlaceholder) {
if (input.files) {
var filesAmount = input.files.length;
for (i = 0; i < filesAmount; i++) {
var reader = new FileReader();
reader.onload = function(event) {
$($.parseHTML('<img>')).attr('src', event.target.result).appendTo(imgPreviewPlaceholder);
}
reader.readAsDataURL(input.files[i]);
}
}
};
$('#images').on('change', function() {
previewImages(this, 'div.images-preview-div');
});
});

  </script>
</div>
