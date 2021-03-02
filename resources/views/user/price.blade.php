@extends('layouts.web')

@section('style')

<link rel="stylesheet" type="text/css" href="{{asset('others/styles/Datatable.css')}}">

<style>

  .dataTables_length{
    display: none;
  }
  .dataTables_filter{
    display: none;
  }

</style>

@endsection

@section('content')
<div class="container col-12 mb-5 col-md-9">
    <div class="mx-auto col-12 p-0">
        @include('inc.error')
    </div>
    <div class="form-row">
      <div class="col-md-12 h3">เรทราคาสินค้า : {{$user_id->name}}</div>

        <div class="col-md-12 mt-3">
            <div class="col-12 px-0">
              <input type="text" id="search-bar" class="form-control search-input" placeholder="Search..." />
            </div>
        </div>

    </div>
    <br>

    <div class="col-12 mt-4 px-0">
      <table id="tb-stocks" class="re-table table-mobile table-stocks mt-2 mb-4">
        <thead>
          <tr>
              <th class="text-lg-center" scope="col">ลำดับ</th>
              <th class="text-lg-center" scope="col">รายการสินค้า</th>
              <th class="text-lg-center" scope="col">สถานะ</th>
              <th class="text-lg-center" scope="col">กำหนดเรท</th>
          </tr>
      </thead>

        <tbody>
          @foreach($stock as $stock_row)
              <tr>
                <td class="text-xl-center px-0"><div class="pl-2">{{$loop->index+1}}</div></td>
                <td class="px-0"><div class="pl-2"><span class="stock-extra-unit">{{$loop->index+1}}. </span>{{$stock_row->name}}</div></td>
                <td class="text-xl-center px-0">
                    @php
                        
                      $priceitem = App\Models\Price::where('user_id',$user_id->id)->where('stock_id',$stock_row->id)->first();
                    @endphp
                    @if(isset($priceitem->stock_id))
                    <div class="pl-2"><span class="stock-extra-unit">สถานะ : </span><span style="color: green">กำหนดแล้ว</span></div>
                    @else
                    <div class="pl-2"><span class="stock-extra-unit">สถานะ : </span><span style="color: red">ยังไม่กำหนด</span></div>
                    @endif
                </td>
                <td class="d-flex justify-content-center px-0">
                    <a class="btn mx-1 green-btn btn-sm" href="{{asset('price').'/'.$user_id->id.'/'.$stock_row->id}}" >เรทราคา</a>
                </td>
              </tr>
            </form>
          @endforeach
        </tbody>

    </table>



</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


@endsection

@section('script')



<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>


<script type="text/javascript">


  $(document).ready( function () {


  $('#modal-btn-yes').click(function(){
      deleteStock();
  });

  $('#tb-stocks').dataTable( {
      "ordering":false,
      "info":true,
      // "dom": '<"top"i>rt<"bottom"><"clear">'
  } );


  $('#search-bar').on( 'keyup click', function () {
        // table.search($('#mySearchText').val()).draw();
        $('#tb-stocks').dataTable().fnFilter(this.value);

  } );


} );

</script>


<script type="text/javascript">

  function confirmDelete(id){

    var name = $('#btn-delete-' + id).data('name');


    $('#modal-btn-yes').data('id',id);

    $('#modal-stock-name').html('"' + name + '"');

    $('#deleteModal').modal('show');
  }
  function deleteStock(){

        var id = $('#modal-btn-yes').data('id');
        var token = $("meta[name='csrf-token']").attr("content");

        console.log(id);


        $.ajax({
        type:     "delete",
        url:      "./api/stocks/"+id,
        data: {
              _token: token,
          },
        success:function(response){
          location.reload();
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
        }
        });


    }

</script>
@endsection

