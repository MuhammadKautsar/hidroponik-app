@extends('layouts.app', ['title' => __('User Profile')])

@section('content')
    @include('layouts.headers.cards')

    <div class="container-fluid mt--7">
        <div class="row">
            {{-- <div class="col-xl-8 order-xl-1"> --}}
            <div class="col">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="mb-0">{{ __('Ubah Produk') }}</h3>
                        </div>
                    </div>
                    {{-- @foreach($data_product as $data) --}}
                    <div class="card-body">

                        <form action="/produk/{{$data_product->id}}/update" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                          <div class="mb-3">
                            <label for="" class="form-label">Gambar</label><br>
                            <input name="gambar[]" multiple type="file" id="image" aria-describedby="emailHelp"><br>
                            <br>{{-- <div class="col-lg-3"> --}}
                              @foreach ($data_product->images as $img)
                              <img src="{{ $img->path_image }}" width="100px" height="70px" alt="">
                              @if (count($data_product->images)>1)
                              <a href="/deleteimage/{{ $img->id }}"
                                 class="text-red"> X

                                {{-- @csrf
                                @method('delete') --}}
                                </a>
                              @endif
                              @endforeach
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
                            <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$data_product->nama}}">
                            @error('nama')
                              <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                          </div>
                          <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Promo</label>
                            <select name="promo_id" class="form-control @error('promo_id') is-invalid @enderror">
                                <option value="">- Pilih -</option>
                                @php($diskon = $data_product->promo)
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
                            <input name="harga" type="number" class="form-control" id="exampleInputEmail1" value="{{$data_product->harga}}">
                          </div>
                          <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Stok</label>
                            <input name="stok" type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$data_product->stok}}">
                          </div>
                          <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Keterangan</label>
                            <textarea name="keterangan" type="text" class="form-control" id="exampleInputEmail1" rows="3">{{$data_product->keterangan}}</textarea>
                          </div>
                      </div>
                      <div class="card-footer">
                        <button type="submit" class="btn btn-primary float-right">Update</button>
                        <a href="/produk" type="button" class="btn btn-secondary float-right mr-2">Close</a>
                        </form>
                      </div>
                      {{-- @endforeach --}}
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection
