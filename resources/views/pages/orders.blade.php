@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')

    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
              <h3 class="mb-0">Pesanan</h3>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center" scope="col" class="sort" data-sort="name">Id</th>
                    <th class="text-center" scope="col" class="sort" data-sort="budget">Tanggal</th>
                    <th class="text-center" scope="col" class="sort" data-sort="status">Pembeli</th>
                    <th class="text-center" scope="col">Produk</th>
                    <th class="text-center" scope="col" class="sort" data-sort="completion">Jumlah</th>
                    <th class="text-center" scope="col" class="sort" data-sort="completion">Total Harga</th>
                    <th class="text-center" scope="col" class="sort" data-sort="completion">Status</th>
                    @if (auth()->user()->level=="penjual")
                    <th class="text-center" scope="col">Aksi</th>
                    @endif
                  </tr>
                </thead>
                <tbody class="list">
                  @foreach($data_product as $product)
                  @if ($product->penjual->id == Auth::user()->id)
                    @foreach($data_order as $item)
                    @if ($item->produk->id == $product->id)
                    <tr>
                      <td class="text-center">{{$item['id']}}</td>
                      <td class="text-center">{{$item['created_at']}}</td>
                      <td class="text-center">{{$item->pembeli->nama_lengkap}}</td>
                      <td class="text-center">{{$item->produk->nama}}</td>
                      <td class="text-center">{{$item['jumlah']}}</td>
                      <td class="text-center">Rp {{number_format($item['total_harga'],2,',','.')}}</td>
                      <td class="text-center">{{$item['status_order']}}</td>
                      @if (auth()->user()->level=="penjual")
                      <td class="text-center">
                        <button type="button" class="btn btn-warning btn-sm float-center" data-bs-toggle="modal" data-bs-target="#editModal-{{ $item->id }}">
                          Tinjau
                        </button>
                        {{-- <div class="dropdown">
                          <button class="btn btn-warning btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Tinjau
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                          </div>
                        </div> --}}
                        {{-- <form action="/pesanan/{{$item->id}}/update" method="POST" enctype="multipart/form-data">
                          {{csrf_field()}}
                          <div class="mb-3">
                            <select name="status" id="" class="form-control">
                              <option value="" hidden selected>--Pilih Level--</option>
                              <button type="submit" class="btn btn-primary"><option value="Belum" type="submit">Belum</option></button>
                              <option value="Diproses">Diproses</option>
                              <option value="Selesai">Selesai</option>
                          </select>
                          </div>
                        </form> --}}
                      </td>
                      @endif
                    </tr>
                    @endif
                    @endforeach
                  @endif
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- Card footer -->
            <div class="card-footer py-4">
              <nav aria-label="...">
                <ul class="pagination justify-content-end mb-0">
                  {{ $data_order->links() }}
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
      @include('layouts.footers.auth')
    </div>

    @foreach($data_order as $data)
    <!-- Modal -->
    <div class="modal fade" id="editModal-{{ $data->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Pesanan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="/pesanan/{{$data->id}}/update" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="mb-3">
                  <label for="" class="form-label">Status</label>
                  {{-- <input name="status" type="text" class="form-control" id="exampleInputEmail1" value="{{$data->status}}"> --}}
                  <select name="status_order" id="" class="form-control">
                    <option value="" hidden selected>--Pilih--</option>
                    <option value="Belum">Belum</option>
                    <option value="Diproses">Diproses</option>
                    <option value="Dikirim">Dikirim</option>
                    <option value="Selesai">Selesai</option>
                    <option value="Batal">Batal</option>
                </select>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-warning">Update</button>
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
