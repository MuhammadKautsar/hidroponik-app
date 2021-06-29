@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
    
    <div class="container-fluid mt--7">
      @if(session('sukses'))
        <div class="alert alert-success" role="alert">
          {{session('sukses')}}
        </div>
      @endif
      <div class="row">
        <form action="/promo/{{$promo->id}}/update" method="POST">
                        {{csrf_field()}}
                      <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Nama Promo</label>
                        <input name="nama" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$promo->nama}}">
                      </div>
                      <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Potongan</label>
                        <input name="potongan" type="text" class="form-control" id="exampleInputEmail1" value="{{$promo->potongan}}">
                      </div>
                      <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Periode</label>
                        <input name="periode" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$promo->periode}}">
                      </div>
                      <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Keterangan</label>
                        <textarea name="keterangan" type="text" class="form-control" id="exampleInputEmail1" rows="3">{{$promo->keterangan}}</textarea>
                      </div>
                  </div>
                    <button type="submit" class="btn btn-warning">Update</button>
                    </form>
        @include('layouts.footers.auth')
      </div>
    </div>

            
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
@endpush