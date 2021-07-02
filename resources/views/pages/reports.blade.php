@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
    
    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
              <h3 class="mb-0">Laporan</h3>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th class="text-center" scope="col" class="sort" data-sort="name">Id</th>
                    <th class="text-center" scope="col" class="sort" data-sort="budget">Tanggal</th>
                    <th class="text-center" scope="col" class="sort" data-sort="status">Laporan</th>
                    <th class="text-center" scope="col">Pelapor</th>
                    <th class="text-center" scope="col" class="sort" data-sort="completion">Penjual</th>
                    <th class="text-center" scope="col">aksi</th>
                  </tr>
                </thead>
                <tbody class="list">
                  @foreach($data_report as $item)
                    <tr>
                      <td class="text-center">{{$item['id']}}</td>
                      <td class="text-center">{{$item['created_at']}}</td>
                      <td class="text-center">{{$item['laporan']}}</td>
                      <td class="text-center">{{$item['pelapor']}}</td>
                      <td class="text-center">{{$item['penjual']}}</td>
                      <td class="text-center">
                        <button type="button" class="btn btn-primary btn-sm float-right" data-bs-toggle="modal" data-bs-target="#editModal-{{ $item->id }}">
                          Edit
                        </button>
                        <a href="/promo/{{$item->id}}/delete" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau dihapus ?')">Delete</a>
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
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush