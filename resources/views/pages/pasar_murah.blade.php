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
              <button type="button" class="btn btn-success btn-sm float-right" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Tambah
              </button>
              <h3 class="mb-0">Pasar Murah</h3>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush table-hover">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center" scope="col" class="sort" data-sort="name">Id</th>
                    <th class="text-center" scope="col" class="sort" data-sort="budget">Gambar</th>
                    <th class="text-center" scope="col" class="sort" data-sort="status">Nama</th>
                    <th class="text-center" scope="col">Lokasi</th>
                    <th class="text-center" scope="col" class="sort" data-sort="completion">Waktu</th>
                    <th class="text-center" scope="col">Keterangan</th>
                    <th class="text-center" scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody class="list">
                  @foreach($pasar_murah as $item)
                    <tr>
                      <td class="text-center">{{$item['id']}}</td>
                      <td class="text-center">
                        <img src="{{ asset('uploads/pasar_murahs/'.$item->gambar) }}" width="100px" height="70px" alt="Image">
                      </td>
                      <td class="text-center">{{$item['nama']}}</td>
                      <td class="text-center">{{$item['lokasi']}}</td>
                      <td class="text-center">{{$item['waktu']}}</td>
                      <td class="text-center">{{$item['keterangan']}}</td>
                      <td class="text-center">
                        <button type="button" class="btn btn-primary btn-sm float-right" data-bs-toggle="modal" data-bs-target="#editModal-{{ $item->id }}">
                          Edit
                        </button>
                        <a href="/pasar_murah/{{$item->id}}/delete" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau dihapus ?')">Delete</a>
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
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Pasar Murah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="/pasar_murah/create" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="mb-3">
                        <label for="" class="form-label">Gambar</label><br>
                        <input name="gambar" type="file" id="exampleInputEmail1" aria-describedby="emailHelp">
                      </div>
                      <div class="mb-3">
                        <label for="" class="form-label">Nama Pasar Murah</label>
                        <input name="nama" type="text" class="form-control" id="exampleInputEmail1">
                      </div>
                      <div class="mb-3">
                        <label for="" class="form-label">Lokasi</label>
                        <input name="lokasi" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                      </div>
                      <div class="mb-3">
                        <label for="" class="form-label">Waktu</label>
                        <input name="waktu" type="date" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                      </div>
                      <div class="mb-3">
                        <label for="" class="form-label">Keterangan</label>
                        <textarea name="keterangan" type="text" class="form-control" id="exampleInputEmail1" rows="3"></textarea>
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

            @foreach($pasar_murah as $data)
            <!-- Modal -->
            <div class="modal fade" id="editModal-{{ $data->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Pasar Murah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="/pasar_murah/{{$data->id}}/update" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="mb-3">
                          <label for="" class="form-label">Gambar</label><br>
                          <input name="gambar" type="file" id="exampleInputEmail1" aria-describedby="emailHelp"><br>
                          <br><img src="{{ asset('uploads/pasar_murahs/'.$data->gambar) }}" width="100px" height="70px" alt="Image">
                        </div>
                        <div class="mb-3">
                          <label for="" class="form-label">Nama Pasar Murah</label>
                          <input name="nama" type="text" class="form-control" id="exampleInputEmail1" value="{{$data->nama}}">
                        </div>
                        <div class="mb-3">
                          <label for="" class="form-label">Lokasi</label>
                          <input name="lokasi" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$data->lokasi}}">
                        </div>
                        <div class="mb-3">
                          <label for="" class="form-label">Waktu</label>
                          <input name="waktu" type="date" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$data->waktu}}">
                        </div>
                        <div class="mb-3">
                          <label for="" class="form-label">Keterangan</label>
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

@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
@endpush