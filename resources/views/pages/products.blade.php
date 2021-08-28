@extends('layouts.app')

@section('content')
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
              @if (auth()->user()->level=="penjual")
              <button type="button" class="btn btn-success btn-sm float-right" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Tambah
              </button>
              @endif
              <h3 class="mb-0">Produk</h3>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush table-hover">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center" scope="col">No</th>
                    <th class="text-center" scope="col">Gambar</th>
                    <th class="text-center" scope="col">Nama</th>
                    <th class="text-center" scope="col">Harga</th>
                    <th class="text-center" scope="col">Stok</th>
                    <th class="text-center" scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody class="list">
                  @php $no = 0 @endphp
                  @foreach($data_product as $item)
                  @if ($item->penjual->id == Auth::user()->id)
                    @php $no++ @endphp
                    <tr>
                      <td class="text-center">{{$no}}</td>
                      <td class="text-center">
                        @php($img = $item->images)
                        <img src="{{ $img[0]->path_image }}" width="100px" height="70px" alt="Image">
                      </td>
                      <td class="text-center">{{$item['nama']}}</td>
                      <td class="text-center">{{$item['harga']}}</td>
                      <td class="text-center">{{$item['stok']}}</td>
                      <td class="text-center">                        
                        @if (auth()->user()->level=="admin")
                        <button type="button" class="btn btn-success btn-sm float-right" data-bs-toggle="modal" data-bs-target="#showModal-{{ $item->id }}">
                          Show
                        </button>
                        @endif
                        @if (auth()->user()->level=="penjual")
                        <button type="button" class="btn btn-primary btn-sm float-right" data-bs-toggle="modal" data-bs-target="#editModal-{{ $item->id }}">
                          Edit
                        </button>
                        @endif
                        <form action="/produk/{{$item->id}}/delete" method="post">
                          <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau dihapus ?');" type="submit">Delete</button>
                          @csrf
                          @method('delete')
                        </form>
                      </td>
                    </tr>
                    @endif
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- Card footer -->
            <div class="card-footer py-4">
              <nav aria-label="...">
                <ul class="pagination justify-content-end mb-0">
                  {{ $data_product->links() }}
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
      @include('layouts.footers.auth')
    </div>

    <!-- Modal -->
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
                <input name="gambar" type="file" id="exampleInputEmail1" aria-describedby="emailHelp">
              </div> --}}
              <div class="mb-3">
                <label for="images" class="form-label">Gambar</label><br>
                <input name="images[]" multiple type="file" class="@error('images') is-invalid @enderror" id="images" aria-describedby="emailHelp"><br>
                @error('images')
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
                <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="exampleInputEmail1" aria-describedby="emailHelp">
                @error('nama')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Harga</label>
                <input name="harga" type="number" class="form-control @error('harga') is-invalid @enderror" id="exampleInputEmail1">
                @error('harga')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Stok</label>
                <input name="stok" type="number" class="form-control @error('stok') is-invalid @enderror" id="exampleInputEmail1" aria-describedby="emailHelp">
                @error('stok')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    @foreach($data_product as $data)
    <!-- Modal -->
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
                <input name="images[]" multiple type="file" id="image" aria-describedby="emailHelp"><br>
                <br>{{-- <div class="col-lg-3"> --}}
                  @if (count($data->images)>0)
                  @foreach ($data->images as $img)
                  <img src="{{ $img->path_image }}" width="85px" height="70px" alt="">
                  <a href="/deleteimage/{{ $img->id }}" 
                     class="text-red"> X
                    
                    {{-- @csrf
                    @method('delete') --}}
                    </a>
                  @endforeach
                  @endif
                {{-- </div> --}}
                {{-- <br>@foreach ($data->images as $img)
                    <img src="{{ $img->path_image }}" width="100px" height="70px" alt="Image">
                  @endforeach
                  <div class="col-md-12">
                    <div class="mt-1 text-center">
                    <div class="images-preview"> </div>
                    </div>  
                  </div> --}}
              </div>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Nama Produk</label>
                <input name="nama" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$data->nama}}">
              </div>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Harga</label>
                <input name="harga" type="number" class="form-control" id="exampleInputEmail1" value="{{$data->harga}}">
              </div>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Stok</label>
                <input name="stok" type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$data->stok}}">
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
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
@endpush