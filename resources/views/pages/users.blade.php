@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')

    <div class="container-fluid mt--7">
      {{-- @if(session('sukses'))
        <div class="alert alert-light" role="alert">
          {{session('sukses')}}
        </div>
      @endif --}}
      <div class="row">
        <div class="col">

            <div id="success_message"></div>

          <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
              <!-- Button trigger modal -->
              <button type="button" class="btn btn-success btn-sm float-right" data-bs-toggle="modal" data-bs-target="#addUserModal">
                @if (auth()->user()->level=="superadmin")
                Tambah Admin
                @elseif (auth()->user()->level=="admin")
                Tambah Penjual
                @endif
              </button>
              <h3 class="mb-0">Pengguna</h3>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush table-hover">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center" scope="col">No</th>
                    <th class="text-center" scope="col">Foto</th>
                    <th class="text-center" scope="col">Nama</th>
                    <th class="text-center" scope="col">Email</th>
                    <th class="text-center" scope="col">No Hp</th>
                    <th class="text-center" scope="col">Alamat</th>
                    <th class="text-center" scope="col">Level</th>
                    <th class="text-center" scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody class="list">
                  @foreach($data_user as $item)
                    <tr>
                      <td class="text-center">{{$item['id']}}</td>
                      <td class="text-center">
                        <img src="{{ $item->getProfileImage() }}" class="avatar avatar-sm rounded-circle" alt="Image">
                      </td>
                      <td class="text-center">{{$item['nama_lengkap']}}</td>
                      <td class="text-center">{{$item['email']}}</td>
                      <td class="text-center">{{$item['nomor_hp']}}</td>
                      <td class="text-center">{{$item['alamat']}}</td>
                      <td class="text-center">{{$item['level']}}</td>
                      <td class="text-center">
                        {{-- <button type="button" class="btn btn-primary btn-sm float-right" data-bs-toggle="modal" data-bs-target="#editModal-{{ $item->id }}">
                          Edit
                        </button> --}}
                        @if ($item->status == 1)
                        <a href="{{ route('users.status.update', ['user_id' => $item->id, 'status_code' => 0]) }}"
                          class="btn btn-danger m-2">
                            <i class="fa fa-ban"></i>
                        </a>
                        @else
                        <a href="{{ route('users.status.update', ['user_id' => $item->id, 'status_code' => 1]) }}"
                          class="btn btn-success m-2">
                            <i class="fa fa-check"></i>
                        </a>
                        @endif
                        {{-- <a href="/pengguna/{{$item->id}}/delete" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau dihapus ?')">Nonaktif</a> --}}
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
                  {{ $data_user->links() }}
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
      @include('layouts.footers.auth')
    </div>

  <!-- Modal add -->
  <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">
            @if (auth()->user()->level=="superadmin")
            Tambah Admin
            @elseif (auth()->user()->level=="admin")
            Tambah Penjual
            @endif
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

            <ul id="saveform_errList"></ul>

          <form action="/pengguna/create" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label for="" class="form-label">Nama Lengkap</label>
              <input name="nama_lengkap" type="text" class="nama_lengkap form-control @error('nama_lengkap') is-invalid @enderror" aria-describedby="emailHelp">
              @error('nama_lengkap')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="" class="form-label">Username</label>
              <input name="username" type="text" class="username form-control @error('username') is-invalid @enderror" aria-describedby="emailHelp">
              @error('username')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="" class="form-label">Email</label>
              <input name="email" type="email" class="email form-control @error('email') is-invalid @enderror">
              @error('email')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="" class="form-label">Password</label>
              <input name="password" type="password" class="password form-control @error('password') is-invalid @enderror" aria-describedby="emailHelp">
              @error('password')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="" class="form-label">Level</label>
              <select name="level" id="" class="level form-control">
                @if (auth()->user()->level=="superadmin")
                <option value="admin">Admin</option>
                @elseif (auth()->user()->level=="admin")
                <option value="penjual">Penjual</option>
                @endif
              </select>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success add_user">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')

<script>
  $(document).ready(function () {

    $(document).on('click', '.add_user', function (e) {
      e.preventDefault();

      var data = {
        'nama_lengkap': $('.nama_lengkap').val(),
        'username': $('.username').val(),
        'email': $('.email').val(),
        'password': $('.password').val(),
        'level': $('.level').val(),
      }
      // console.log(data);

      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      $.ajax({
        type: "POST",
        url: "/pengguna/create",
        data: data,
        dataType: "json",
        success: function (response) {
        //   console.log(response.errors.nama_lengkap);
            if(response.status == 400)
            {
                $('#saveform_errList').html("");
                $('#saveform_errList').addClass('alert alert-danger');
                $.each(response.errors, function (key, err_values) {
                    $('#saveform_errList').append('<li>'+err_values+'<li>');
                });
            }
            else
            {
                $('#saveform_errList').html("");
                $('#success_message').addClass('alert alert-success')
                $('#success_message').text(response.message)
                $('#addUserModal').modal('hide');
                $('#addUserModal').find('input').val("");
                fetchuser();
            }
        }
      })
    });
  });
</script>

@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
@endpush
