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
              <h3 class="mb-0">Multi Images</h3>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush table-hover">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center" scope="col" class="sort" data-sort="name">Id</th>
                    <th class="text-center" scope="col" class="sort" data-sort="budget">Title</th>
                    <th class="text-center" scope="col" class="sort" data-sort="budget">Author</th>
                    <th class="text-center" scope="col" class="sort" data-sort="status">Description</th>
                    <th class="text-center" scope="col">Cover</th>
                    <th class="text-center" scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody class="list">
                  @foreach ($posts as $post)
                    <tr>
                      <td class="text-center">{{ $post->id }}</td>
                      <td class="text-center">{{ $post->title }}</td>
                      <td class="text-center">{{ $post->author }}</td>
                      <td class="text-center">{{ $post->body }}</td>
                      <td class="text-center">
                        <img src="cover/{{ $post->cover }}" width="100px" height="70px" alt="Image">
                      </td>
                      <td class="text-center">
                        {{-- <button type="button" class="btn btn-primary btn-sm float-right" data-bs-toggle="modal" data-bs-target="#editModal-">
                          Edit
                        </button> --}}
                        <a href="/edit/{{ $post->id }}" class="btn btn-primary btn-sm">Update</a>
                        <form action="/delete/{{ $post->id }}" method="post">
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
        @include('layouts.footers.auth')
      </div>
    </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Banyak Gambar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="/post/create" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Cover</label>
                        <input name="cover" type="file" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                      </div>
                      <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Images</label>
                        <input name="images[]" multiple type="file" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                      </div>
                      <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Title</label>
                        <input name="title" type="text" class="form-control" id="exampleInputEmail1">
                      </div>
                      <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Author</label>
                        <input name="author" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                      </div>
                      <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Body</label>
                        <textarea name="body" type="text" class="form-control" id="exampleInputEmail1" rows="3"></textarea>
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

            @foreach ($posts as $post)
            <!-- Modal -->
            <div class="modal fade" id="editModal-" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="/edit/{{ $post->id }}" method="POST">
                        {{csrf_field()}}
                        <div class="mb-3">
                          <label for="exampleInputEmail1" class="form-label">Cover</label>
                          <input name="cover" type="file" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                          <img src="/cover/{{ $post->cover }}" width="100px" height="70px" alt="Image">
                        </div>
                        {{-- <div class="mb-3">
                          @foreach ($images as $img)
                          <label for="exampleInputEmail1" class="form-label">Images</label>
                          <input name="images[]" multiple type="file" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                          <img src="/images/{{ $img->image }}" width="100px" height="70px" alt="Image">
                          @endforeach
                        </div> --}}
                        <div class="mb-3">
                          <label for="exampleInputEmail1" class="form-label">Title</label>
                          <input name="title" type="text" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputEmail1" class="form-label">Author</label>
                          <input name="author" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputEmail1" class="form-label">Body</label>
                          <textarea name="body" type="text" class="form-control" id="exampleInputEmail1" rows="3"></textarea>
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