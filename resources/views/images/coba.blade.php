@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')

    <div class="container">
		<div class="row">
			<div class="col-lg-8 offset-lg-2">
				<div class="form-wrapper py-5">
					<!-- form starts -->
					<form action="{{ route('form.data') }}" name="demoform" id="demoform" method="POST" class="dropzone" enctype="multipart/form-data">

						@csrf
                        <div class="form-group">
                            <div id="dropzoneDragArea" class="dz-default dz-message dropzoneDragArea">
                                <span>Upload file</span>
                            </div>
                            <div class="dropzone-previews"></div>
                        </div>
						<div class="form-group">

							<input type="hidden" class="produkid" name="produkid" id="produkid" value="">

							<label for="nama">Nama Produk</label>
							<input type="text" name="nama" id="nama" class="form-control" required autocomplete="off">
						</div>
						<div class="form-group">
							<label for="promo_id">Promo</label>
							<select name="promo_id" class="form-control @error('promo_id') is-invalid @enderror">
                                <option value="">- Pilih -</option>
                                {{-- @foreach ($promo as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }} - {{ $item->potongan }} %</option>
                                @endforeach --}}
                            </select>
						</div>
                        <div class="form-group">
							<label for="harga">Harga</label>
							<input type="number" name="harga" id="harga" class="form-control" required autocomplete="off">
						</div>
                        <div class="form-group">
							<label for="stok">Stok</label>
							<input type="number" name="stok" id="stok" class="form-control" required autocomplete="off">
						</div>
                        <div class="form-group">
							<label for="keterangan">Keterangan</label>
							<textarea type="text" name="keterangan" id="keterangan" class="form-control" required autocomplete="off" rows="3"></textarea>
						</div>
                  		<div class="form-group">
	        				<button type="submit" class="btn btn-md btn-success">Simpan</button>
	        			</div>
					</form>
					<!-- form end -->
				</div>
			</div>
		</div>
	</div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script> --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    {{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script> --}}

    <script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>

    <!-- Adding a script for dropzone -->
<script>
    Dropzone.autoDiscover = false;
    // Dropzone.options.demoform = false;
    let token = $('meta[name="csrf-token"]').attr('content');
    $(function() {
    var myDropzone = new Dropzone("div#dropzoneDragArea", {
        paramName: "file",
        url: "{{ url('/storeimage') }}",
        previewsContainer: 'div.dropzone-previews',
        addRemoveLinks: true,
        autoProcessQueue: false,
        uploadMultiple: false,
        parallelUploads: 1,
        maxFiles: 1,
        params: {
            _token: token
        },
         // The setting up of the dropzone
        init: function() {
            var myDropzone = this;
            //form submission code goes here
            $("form[name='demoform']").submit(function(event) {
                //Make sure that the form isn't actully being sent.
                event.preventDefault();
                URL = $("#demoform").attr('action');
                formData = $('#demoform').serialize();
                $.ajax({
                    type: 'POST',
                    url: URL,
                    data: formData,
                    success: function(result){
                        if(result.status == "success"){
                            // fetch the useid
                            var produkid = result.produk_id;
                            $("#produkid").val(produkid); // inseting produkid into hidden input field
                            //process the queue
                            myDropzone.processQueue();
                        }else{
                            console.log("error");
                        }
                    }
                });
            });
            //Gets triggered when we submit the image.
            this.on('sending', function(file, xhr, formData){
            //fetch the user id from hidden input field and send that produkid with our image
              let produkid = document.getElementById('produkid').value;
               formData.append('produkid', produkid);
            });

            this.on("success", function (file, response) {
                //reset the form
                $('#demoform')[0].reset();
                //reset dropzone
                $('.dropzone-previews').empty();
            });
            this.on("queuecomplete", function () {

            });

            // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
            // of the sending event because uploadMultiple is set to true.
            this.on("sendingmultiple", function() {
              // Gets triggered when the form is actually being sent.
              // Hide the success button or the complete form.
            });

            this.on("successmultiple", function(files, response) {
              // Gets triggered when the files have successfully been sent.
              // Redirect user or notify of success.
            });

            this.on("errormultiple", function(files, response) {
              // Gets triggered when there was an error sending the files.
              // Maybe show form again, and notify user of error
            });
        }
        });
    });
</script>

@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush
