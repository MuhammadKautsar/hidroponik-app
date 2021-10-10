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
                    <th class="text-center" scope="col">No</th>
                    <th class="text-center" scope="col">Tanggal</th>
                    <th class="text-center" scope="col">Pembeli</th>
                    <th class="text-center" scope="col">Produk</th>
                    <th class="text-center" scope="col">Jumlah</th>
                    <th class="text-center" scope="col">Ongkir</th>
                    <th class="text-center" scope="col">Total Harga</th>
                    <th class="text-center" scope="col">Status</th>
                    @if (auth()->user()->level=="penjual")
                    <th class="text-center" scope="col">Aksi</th>
                    @endif
                  </tr>
                </thead>
                <tbody class="list">
                  @php $no = 0 @endphp
                  @foreach($data_product as $product)
                  @if ($product->penjual->id == Auth::user()->id)
                    @foreach($data_order as $item)
                    @if ($item->produk->id == $product->id)
                    @php $no++ @endphp
                    <tr>
                      <td class="text-center">{{$no}}</td>
                      <td class="text-center">{{$item['created_at']->format('d-m-Y')}}</td>
                      <td class="text-center">{{$item->pembeli->nama_lengkap}}</td>
                      <td class="text-center">{{$item->produk->nama}}</td>
                      <td class="text-center">{{$item['jumlah']}}</td>
                      <td class="text-center">Rp {{number_format($item['harga_jasa_pengiriman'],0,',','.')}}</td>
                      <td class="text-center">Rp {{number_format($item['total_harga'],0,',','.')}}</td>
                      <td class="text-center">{{$item['status_order']}}</td>
                      @if (auth()->user()->level=="penjual")
                      <td class="text-center">
                        <button type="button" class="btn btn-warning btn-sm float-center" data-bs-toggle="modal" data-bs-target="#editModal-{{ $item->id }}">
                          Tinjau
                        </button>
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
                  {{-- {{ $data_order->links() }} --}}
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
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Pesanan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="/pesanan/{{$data->id}}/update" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Ongkir</label>
                    {{-- @if ($data->harga_jasa_pengiriman==0) --}}
                    <input name="harga_jasa_pengiriman" type="number" class="form-control @error('harga_jasa_pengiriman') is-invalid @enderror" value="{{$data->harga_jasa_pengiriman}}">
                    {{-- @else
                    <span class="form-control">{{$data->harga_jasa_pengiriman}}</span>
                    @endif --}}
                    @error('harga_jasa_pengiriman')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                  <label for="" class="form-label">Status</label>
                  {{-- @if ($data->status_order!="Selesai") --}}
                  <select name="status_order" id="" class="form-control @error('status_order') is-invalid @enderror">
                    <option value="{{$data->status_order}}" hidden selected>{{$data->status_order}}</option>
                    @if ($data->status_order=="Belum")
                    <option value="Diproses">Diproses</option>
                    @elseif ($data->status_order=="Diproses")
                    <option value="Dikirim">Dikirim</option>
                    @elseif ($data->status_order=="Dikirim")
                    <option value="Selesai">Selesai</option>
                    @endif
                  </select>
                  {{-- @else
                  <span class="form-control">{{$data->status_order}}</span>
                  @endif --}}
                  @error('status_order')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
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
