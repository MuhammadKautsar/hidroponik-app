@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
    
    <div class="container-fluid mt--7">
      @if(session('sukses'))
        <div class="alert alert-light" role="alert">
          {{session('sukses')}}
        </div>
      @endif
      <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
              <!-- Button trigger modal -->
              @if (auth()->user()->level=="user")
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
                    @php $no++ @endphp
                    <tr>
                      <td class="text-center">{{$no}}</td>
                      <td class="text-center">
                        <img src="{{ asset('gambar/'.$item->gambar) }}" width="100px" height="70px" alt="Image">
                      </td>
                      <td class="text-center">{{$item['nama']}}</td>
                      <td class="text-center">{{$item['harga']}}</td>
                      <td class="text-center">{{$item['stok']}}</td>
                      <td class="text-center">                        
                        @if (auth()->user()->level=="admin")
                        <button type="button" class="btn btn-success btn-sm float-right" data-bs-toggle="modal" data-bs-target="#showModal-{{ $item->id }}">
                          View
                        </button>
                        @endif
                        @if (auth()->user()->level=="user")
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
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- Card footer -->
            <div class="card-footer py-4">
              <nav aria-label="...">
                <ul class="pagination justify-content-end mb-0">
                  <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">
                      <i class="fas fa-angle-left"></i>
                      <span class="sr-only">Previous</span>
                    </a>
                  </li>
                  <li class="page-item active">
                    <a class="page-link" href="#">1</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                  </li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item">
                    <a class="page-link" href="#">
                      <i class="fas fa-angle-right"></i>
                      <span class="sr-only">Next</span>
                    </a>
                  </li>
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
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Cover</label><br>
                <input name="gambar" type="file" id="exampleInputEmail1" aria-describedby="emailHelp">
              </div>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Gambar</label><br>
                <input name="images[]" multiple type="file" id="exampleInputEmail1" aria-describedby="emailHelp">
              </div>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Nama Produk</label>
                <input name="nama" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
              </div>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Harga</label>
                <input name="harga" type="number" class="form-control" id="exampleInputEmail1">
              </div>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Stok</label>
                <input name="stok" type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
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
            {{-- <div class="col-lg-3">
              <p>cover:</p>
              <form action="/deletecover/{{ $data->id }}" method="POST">
              <button class="btn text-danger">X</button>
              @csrf
              @method('delete')
              </form>
              <img src="/gambar/{{ $data->gambar }}" width="100px" height="70px" alt="">
              <br>

              @if (count($data->images)>0)
              <p>image:</p>
              @foreach ($data->images as $img)
              <form action="/deleteimage/{{ $img->id }}" method="POST">
                <button class="btn text-danger">X</button>
                @csrf
                @method('delete')
              </form>
              <img src="/images/{{ $img->image }}" width="100px" height="70px" alt="">
              @endforeach
              @endif
            </div> --}}
            <form action="/produk/{{$data->id}}/update" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
              <div class="mb-3">
                <label for="" class="form-label">Cover</label><br>
                <input name="gambar" type="file" id="exampleInputEmail1" aria-describedby="emailHelp"><br>
                <br><img src="{{ asset('gambar/'.$data->gambar) }}" width="100px" height="70px" alt="Image">
              </div>
              <div class="mb-3">
                <label for="" class="form-label">Gambar</label><br>
                <input name="images[]" multiple type="file" id="exampleInputEmail1" aria-describedby="emailHelp"><br>
                <br>@foreach ($data->images as $img)
                    <img src="/images/{{ $img->image }}" width="100px" height="70px" alt="Image">
                  @endforeach
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

    @foreach($data_product as $data)
    <!-- Modal -->
    <div class="modal fade" id="showModal-{{ $data->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail Produk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="/produk/{{$data->id}}/update" method="POST" enctype="multipart/form-data">
              <div class="mb-3">
                <label for="" class="form-label">Cover</label><br>
                <br><img src="{{ asset('gambar/'.$data->gambar) }}" width="100px" height="70px" alt="Image">
              </div>
              <div class="mb-3">
                <label for="" class="form-label">Gambar</label><br>
                <br>@foreach ($data->images as $img)
                    <img src="/images/{{ $img->image }}" width="100px" height="70px" alt="Image">
                  @endforeach
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    @endforeach
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
@endpush