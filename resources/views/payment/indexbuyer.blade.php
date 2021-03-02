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
<div class="col-11 mx-auto">
  <div class="content-wrapper">
    <div class="container  mb-3 col-12">
      <div class="mx-auto col-12 p-0">
        @include('inc.error')
      </div>
      <div class="form-row mx-0 my-auto">
        <div class="col-12 my-auto px-0 h3">ประวัติการสั่งซื้อ</div>
        
        <div class="col-12 p-0 mt-3">
          <div class="col-12 px-0">
            <input type="text" id="search-bar" class="form-control search-input m-0" placeholder="Search..." />
          </div>
        </div>
        <br>
        
        <div class="tb-search-wrapper col-12 px-0 mt-4">
          <table id="tb-stocks" class="re-table table-mobile table-stocks mt-2 mb-0 mb-md-3">
            <thead>
                <tr>
                    <th class="text-lg-center sorting_disabled" scope="col">No.</th>
                    <th class="text-lg-center sorting_disabled" scope="col">เลขคำสั่งซื้อ</th>
                    <th class="text-lg-center sorting_disabled" scope="col">วันที่</th>
                    <th class="text-lg-center sorting_disabled" scope="col">ตัวแทน</th>
                    <th class="text-lg-right sorting_disabled" scope="col">ยอดสั่งซื้อ</th>
                    <th class="text-lg-center sorting_disabled" scope="col">สถานะ</th>
                    <th class="text-lg-center sorting_disabled" scope="col"></th>
                </tr>
            </thead>

            <tbody>
              @foreach($PurchaseOrder as $PurchaseOrder_row)
                @php
                  $user = App\Models\User::where('id',$PurchaseOrder_row->buyer_id)->first();                   
                  $price = App\Models\Order::where('purchase_order_id',$PurchaseOrder_row->id)->sum('price');                   
                  $status = App\Models\PurchaseOrderStatus::where('id',$PurchaseOrder_row->status_id)->first();         
                @endphp
                <tr>
                  <td class="text-xl-center px-0"><div class="pl-2 pl-lg-0">{{$loop->index+1}}</div></td>
                  <td class="text-xl-center px-0">
                    <div class="px-2">
                      <span class="stock-extra-unit">
                        {{$loop->index+1}}. </span>{{number_format($PurchaseOrder_row->purchase_no,0,",","-")}}
                      
                    </div>
                  </td>
                  <td class="text-xl-center px-0">
                    <div class="px-2">
                      <span class="stock-extra-unit">วันที่สั่งซื้อ : </span>{{DateTime::createFromFormat('Y-m-d H:i:s', $PurchaseOrder_row->created_at)->format('d/m/Y H:i:s')}}
                    </div>
                  </td>
                  <td class="text-xl-left px-0">
                    <div class="px-2">
                      <span class="stock-extra-unit">ตัวแทน : </span>{{$user->name}}
                    </div>
                  </td>
                  <td class="text-xl-right px-0">
                    <div class="px-2"><span class="stock-extra-unit">ยอดสั่งซื้อ : </span>{{number_format($price,2)}}</div>
                  </td>
                  <td class="text-xl-center px-0">
                    <div class="px-2"><span class="stock-extra-unit">สถานะ : </span>{{$status->name}}</div>
                  </td>
                  <td class="text-center px-0">
                    <div class="px-2">
                      <a class="btn blue-btn btn-sm" href="{{asset('payment'.'/'.$PurchaseOrder_row->id)}}">แจ้งโอน</a>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>

          </table>
        </div>

      </div>


    </div>
  </div>
</div>
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
