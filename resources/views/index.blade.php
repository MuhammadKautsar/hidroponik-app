
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Laravel</title>
  {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous"> --}}
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script
  src="https://code.jquery.com/jquery-3.6.0.js"
  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
  <div class="container pt-5">
    <div class="row m-0">
      <div class="col-4 p-0">
        <label class="font-weight-bold">Search Input</label>
        <input id="inputSearch" type="" name="" class="form-control">
      </div>
    </div>
    <div id="searchResult" class="row m-0 mt-4" style="display: none;">

  </div>

{{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script> --}}

{{-- @push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
@endpush --}}

{{-- <script>
  $(document).ready(function(){
    $('#search').on('keyup', function(){
      var query= $(this).val();
      $.ajax({
        url:"search",
        type:"GET",
        data:{'search':query},
        success:function(data){
          $('#search_list').html(data);
        }
      });
    });
    // end of ajax call
  });
</script> --}}

</body>
</html>

<script type="text/javascript">
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $('#inputSearch').on('keyup',function(){
    $inputSearch = $(this).val();
    if($inputSearch ==''){
      $('#searchResult').html('');
      $('#searchResult').hide();
    }
    else{
      $.ajax({
        method:"post",
        url:'search',
        data:JSON.stringify({
          inputSearch:$inputSearch
        }),
        headers:{
          'Accept':'application/json',
          'Content-Type':'application/json'
        },
        success:function(data){
          var searchResultAjax='';
          data = JSON.parse(data);
          console.log(data);
          $('#searchResult').show();
          for(let i=0;i<data.length;i++){
            searchResultAjax +=`<div class="col-3 p-1">
            <div class="p-3 bg-primary">
              <p class="font-weight-bold text-white float-left">Title:</p>
              <p class="font-weight-bold text-white float-right">`+data[i].title+`</p>
              <div style="clear: both;"></div>
              <p class="font-weight-bold text-white float-left">Description:</p>
              <p class="font-weight-bold text-white float-right">`+data[i].description+`</p>
              <div style="clear: both;"></div>
            </div>
          </div>`
          }
          $('#searchResult').html(searchResultAjax)
        }
      })
    }
  })
</script>