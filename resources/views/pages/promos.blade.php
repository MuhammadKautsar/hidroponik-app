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
            <h3 class="mb-0">Promo</h3>
          </div>
          <!-- Light table -->
          <div class="table-responsive">
            <table class="table align-items-center table-flush table-hover">
              <thead class="thead-light">
                <tr>
                  <th class="text-center" scope="col" class="sort" data-sort="name">Id</th>
                  <th class="text-center" scope="col" class="sort" data-sort="budget">Gambar</th>
                  <th class="text-center" scope="col" class="sort" data-sort="budget">Nama</th>
                  <th class="text-center" scope="col" class="sort" data-sort="status">Potongan</th>
                  <th class="text-center" scope="col">Awal Periode</th>
                  <th class="text-center" scope="col">Akhir Periode</th>
                  <th class="text-center" scope="col" class="sort" data-sort="completion">Keterangan</th>
                  <th class="text-center" scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody class="list">
                @foreach($promo as $item)
                  <tr>
                    <td class="text-center">{{$item['id']}}</td>
                    <td class="text-center">
                      <img src="{{ asset('uploads/promos/'.$item->gambar) }}" width="100px" height="70px" alt="Image">
                    </td>
                    <td class="text-center">{{$item['nama']}}</td>
                    <td class="text-center">{{$item['potongan']}}</td>
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
                <img id="preview-image" src="https://www.riobeauty.co.uk/images/product_image_not_found.gif"
                      alt="preview image" width="100px" height="70px">
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
              <label for="exampleInputEmail1" class="form-label">Potongan</label>
              <input name="potongan" type="number" class="form-control @error('potongan') is-invalid @enderror" id="exampleInputEmail1">
              @error('potongan')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Awal Periode</label>
              <input name="awal_periode" type="date" class="form-control @error('awal_periode') is-invalid @enderror" id="exampleInputEmail1" aria-describedby="emailHelp">
              @error('awal_periode')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Akhir Periode</label>
              <input name="akhir_periode" type="date" class="form-control @error('akhir_periode') is-invalid @enderror" id="exampleInputEmail1" aria-describedby="emailHelp">
              @error('akhir_periode')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Keterangan</label>
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
              <br><img src="{{ asset('uploads/promos/'.$data->gambar) }}" width="100px" height="70px" alt="Image">
            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Nama Promo</label>
              <input name="nama" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$data->nama}}">
            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Potongan</label>
              <input name="potongan" type="number" class="form-control" id="exampleInputEmail1" value="{{$data->potongan}}">
            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Periode</label>
              <input name="periode" type="date" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$data->periode}}">
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

  <script>
  $('#image').change(function(){
           
    let reader = new FileReader();
    reader.onload = (e) => { 
      $('#preview-image').attr('src', e.target.result); 
    }
    reader.readAsDataURL(this.files[0]); 
  
   });
   </script>

@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
@endpush