@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')

    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
              <h3 class="mb-0">Ulasan</h3>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center" scope="col" class="sort" data-sort="name">No</th>
                    <th class="text-center" scope="col" class="sort" data-sort="budget">Nama Produk</th>
                    <th class="text-center" scope="col" class="sort" data-sort="status">Pembeli</th>
                    <th class="text-center" scope="col">Komentar</th>
                    <th class="text-center" scope="col" class="sort" data-sort="completion">Rating</th>
                    <th class="text-center" scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody class="list">
                    @php $no = 0 @endphp
                    @foreach($data_product as $product)
                    @if ($product->penjual->id == Auth::user()->id)
                        @foreach($feedbacks as $item)
                        @if ($item->produk->id == $product->id)
                        @php $no++ @endphp
                            <tr>
                            <td class="text-center">{{$no}}</td>
                            <td class="text-center">{{$item->produk->nama}}</td>
                            <td class="text-center">{{ $item->user->nama_lengkap }}</td>
                            <td class="text-center">{{$item['komentar']}}</td>
                            <td class="text-center">
                                @for($i = 0; $i < 5; $i++)
                                    <span><i class="fa fa-star{{ $item->rating <= $i ? '-o' : '' }}" style="color:orange"></i></span>
                                @endfor
                              </td>
                            <td class="text-center">
                                @if (auth()->user()->level=="user")
                                <button type="button" class="btn btn-light btn-sm float-right" data-bs-toggle="modal" data-bs-target="#editModal-{{ $item->id }}">
                                Balas
                                </button>
                                @endif
                                <a href="/ulasan/{{$item->id}}/delete" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau dihapus ?')">Hapus</a>
                            </td>
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
                  {{ $feedbacks->links() }}
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
      @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush
