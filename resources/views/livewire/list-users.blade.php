<div>
    @extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')

    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
              <h3 class="mb-0">Pengguna</h3>
                <label>Title</label>
                <input wire:model="title" type="text" class="form-control">
                <label>Content</label>
                <input wire:model="content" type="text" class="form-control">
                <br>
                <button wire:click='sdsasfsaf'>Save</button>
            </div>
          </div>
        </div>
      </div>
      @include('layouts.footers.auth')
    </div>
@endsection

</div>
