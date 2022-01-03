@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')

    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-sm-12 col-11 main-section">
                <h1 class="text-center text-danger">Upload Images</h1>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <input type="file" id="file-1" multiple name="image" class="file" data-overwrite-initial="false" data-mint-file-count="2">
                </div>
                <div class="card-body">
                    <form action="/produk/create" method="POST" enctype="multipart/form-data">
                      @csrf
                      {{-- <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Cover</label><br>
                        <input name="gambar" type="file" id="exampleInputEmail1" aria-describedby="emailHelp">
                      </div> --}}
                      <div class="mb-3">
                        <label for="" class="form-label">Gambar</label><br>
                        <input name="gambar[]" multiple type="file" class="@error('gambar') is-invalid @enderror" id="images" aria-describedby="emailHelp"><br>
                        @error('gambar')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <br>
                        <div class="col-md-12">
                          <div class="mt-1 text-center">
                          <div class="images-preview-div"> </div>
                          </div>
                        </div>
                      </div>
                      <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Nama Produk</label>
                        <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="exampleInputEmail1" aria-describedby="emailHelp">
                        @error('nama')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Promo</label>
                        <select name="promo_id" class="form-control @error('promo_id') is-invalid @enderror">
                            <option value="">- Pilih -</option>
                            {{-- @foreach ($promo as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }} - {{ $item->potongan }} %</option>
                            @endforeach --}}
                        </select>
                        @error('promo_id')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Harga</label>
                        <input name="harga" type="number" class="form-control @error('harga') is-invalid @enderror" id="exampleInputEmail1">
                        @error('harga')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Stok</label>
                        <input name="stok" type="number" class="form-control @error('stok') is-invalid @enderror" id="exampleInputEmail1" aria-describedby="emailHelp">
                        @error('stok')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Keterangan</label>
                        <textarea name="keterangan" type="text" class="form-control @error('keterangan') is-invalid @enderror" id="exampleInputEmail1" rows="3"></textarea>
                        @error('keterangan')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                  </div>
                  <div class="card-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Submit</button>
                    </form>
                  </div>
            </div>
        </div>
    </div>








    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script> --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.2.6/js/fileinput.js" integrity="sha512-HmOH2WRS8drNeqkJULE3NIu32PDpJ5gbHRjccop7PgzuxbeyBco3tizvNQ5DVrXM9NTtcMfNhlW4lHt+iSW/Tg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.2.6/themes/explorer-fas/theme.js" integrity="sha512-ZY8Ju2x1jtJ5kGiPjgo+v4yzWtufr0AFTFdK8AENoo7zfaLneJpG7XOCNMpkRbp/kn6Fbf8qaWWeeLXW+qCOjw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    {{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script> --}}

    <script type="text/javascript">
        $("#file-1").fileinput({
            theme:'fa',
            uploadUrl:"/upload-images",
            uploadExtraData:function(){
                return{
                    _token:$("input[name='_token']").val()
                };
            },
            allowedFileExtensions:['jpg','png','jpeg'],
            overwriteInitial:false,
            maxFileSize:2000,
            maxFileNumber:8,
            slugCallback:function (filename){
                return filename.replace('(','_').replace(']','_');
            }
        });
    </script>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush
