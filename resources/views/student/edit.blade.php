@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
    
    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col">
            @if(session('status'))
                <h6 class="alert alert-success">{{session('status')}}</h6>
            @endif
          <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
              <h4>ubah image
                <a href="{{ url('students') }}" class="btn btn-danger float-end">kembali</a>
              </h4>
            </div>
            <div class="card-body">
                <form action="{{ url('update-student/'.$student->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                  <div class="mb-3">
                    <label for="" class="form-label">Nama</label>
                    <input type="text" name="name" value="{{$student->name}}" class="form-control">
                  </div>
                  <div class="mb-3">
                    <label for="" class="form-label">email</label>
                    <input type="text" name="email" value="{{$student->email}}" class="form-control">
                  </div>
                  <div class="mb-3">
                    <label for="" class="form-label">course</label>
                    <input type="text" name="course" value="{{$student->course}}" class="form-control">
                  </div>
                  <div class="mb-3">
                    <label for="">profile</label>
                    <input type="file" name="profile_image" class="form-control">
                    <img src="{{ asset('uploads/students/'.$student->profile_image) }}" width="70px" height="70px" alt="Image">
                  </div>
                  <div class="mb-3">
                    <button type="submit" class="btn btn-warning">ubah</button>
                  </div>

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