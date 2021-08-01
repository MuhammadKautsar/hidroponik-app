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
                <h3 class="mb-0">Update Image</h3>
              </div>
              <div class="col-lg-3">
                <p>cover:</p>
                <form action="/deletecover/{{ $posts->id }}" method="POST">
                <button class="btn text-danger">X</button>
                @csrf
                @method('delete')
                </form>
                <img src="/cover/{{ $posts->cover }}" width="100px" height="70px" alt="">
                <br>

                @if (count($posts->images)>0)
                <p>image:</p>
                @foreach ($posts->images as $img)
                <form action="/deleteimage/{{ $img->id }}" method="POST">
                  <button class="btn text-danger">X</button>
                  @csrf
                  @method('delete')
                </form>
                <img src="/images/{{ $img->image }}" width="100px" height="70px" alt="">
                @endforeach
                @endif
              </div>

              <div class="form-group">
                <form action="/update/{{ $posts->id }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Cover</label>
                        <input name="cover" type="file" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        <img src="/cover/{{ $posts->cover }}" width="100px" height="70px" alt="Image">
                    </div>
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Images</label>
                      <input name="images[]" multiple type="file" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        @foreach ($posts->images as $img)
                        
                        <img src="/images/{{ $img->image }}" width="100px" height="70px" alt="Image">
                        @endforeach
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Title</label>
                        <input name="title" type="text" class="form-control" id="exampleInputEmail1" value="{{ $posts->title }}">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Author</label>
                        <input name="author" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ $posts->author }}">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Body</label>
                        <textarea name="body" type="text" class="form-control" id="exampleInputEmail1" rows="3">{{ $posts->body }}</textarea>
                    </div>
                <button type="submit" class="btn btn-primary">Update</button>
                </form>
              </div>
            </div>
        </div>
        @include('layouts.footers.auth')
      </div>
    </div>
            

@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
@endpush