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
  @php
  $myid = Auth::user()->id ;
  $bank = App\Models\UserBank::where('user_id',$myid)->first();
  @endphp
  @if(isset($bank->id))
  @else
  <div id="user-error-msg" class="alert alert-danger alert-dismissible fade show">
    ท่านยังไม่ไม่ได้เพิ่มบัญชีธนาคาร กรุณาเพิ่มบัญชีธนาคารก่อน <a style="color: red" href="{{asset('EditUser')}}">คลิกที่นี่</a> เพื่อเพิ่มธนาคาร
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif  
  <div class="form-row mx-0 my-auto">
    <div class="col-12 my-auto px-0 h3">รายการสินค้า</div>

    <div class="col-12 mt-3 px-0">
      <input type="text" id="search-bar" class="form-control search-input" placeholder="Search..." />
    </div>

  </div>
  <div class="tb-search-wrapper mt-4">
    <table id="tb-stocks" class="re-table table-mobile table-stocks mt-2 mb-0 mb-md-3">
      <col width="auto">
      <col width="auto">
      <col width="auto">

      <col width="350 px">
      <thead>
            <tr>
                <th class="text-lg-center sorting_disabled" scope="col">ลำดับ</th>
                <th class="text-lg-center sorting_disabled" >รายการสินค้า </th>
                <th class="text-lg-right px-lg-0 sorting_disabled">จำนวนคงเหลือ</th>
                <th class="text-lg-center sorting_disabled">ราคา</th>
            </tr>
        </thead>

        <tbody>
          @foreach($Stock as $Stock_row)
            
              <tr>
                
                    <td class="text-xl-center px-0">
                      <div class="pl-2 pl-lg-0">{{$loop->index+1}}</div>
                    </td>
                    <td class="px-0">
                      <div class="pl-2"><span class="stock-extra-unit">{{$loop->index+1}}. </span>{{$Stock_row->name}}</div>
                    </td>
                    <td class="text-xl-right px-0">
                      <div class="pl-2 "><span class="stock-extra-unit">จำนวนคงเหลือ : </span>{{number_format($Stock_row->amount,0)}} {{$Stock_row->spent_unit}}</div>
                    </td>
                    <td class="text-center px-0"><div class="pl-2">
                        @php
                          $priceitem = App\Models\Price::where('user_id',$myid)->where('stock_id',$Stock_row->id)->first();
                        @endphp
                          
                        @if(isset($bank->id))
                          @if(isset($priceitem->stock_id))
                            <form method="POST" action="{{asset('addtocart')}}"  enctype="multipart/form-data">
                              @csrf
                              <button class="btn col-5 ml-1 green-btn btn-sm" name="stock_id" value="{{$Stock_row->id}}" type="submit" >สั่งซื้อ</button>
                            </form>
                          @else
                            <div class="text-center">ไม่กำหนด</div>
                          @endif
                        @else
                          @if(isset($priceitem->stock_id))
                              <button class="btn col-5 ml-1 btn-secondary btn-sm" name="stock_id" value="{{$Stock_row->id}}" type="submit" disabled>สั่งซื้อ</button>

                          @else
                            <div class="text-center">ไม่กำหนด</div>
                          @endif
                        @endif
                      </div>
                      </td>
                </form>
              </tr>
            
          @endforeach
        </tbody>

    </table>
  </div>



    {{-- @foreach($Stock as $Stock_row)
      <div class="modal" id="editModal{{$loop->index+1}}" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-md">
          <div class="modal-content py-4">
            <div class="modal-header col-11 mx-auto">
              <h3 class="modal-title">เรทราคา: {{$Stock_row->name}}</h3>
            </div>
            <div class="modal-body col-11 mx-auto">


              <form method="post" action="{{asset('StoreUpdate').'/'.$Stock_row->id}}" enctype="multipart/form-data">
                {{method_field('PUT')}}
                @csrf
                  <div class="my-2 mx-5">
                    <div class="form-group">
                      <div class="col-12 p-0">ชื่อสินค้า </div>
                      <input class="col-12 p-0 text-center" name="name" type="text" value="{{$Stock_row->name}}" >
                    </div>
                    <div class="form-group">
                      <div class="col-12 p-0">จำนวน</div>
                      <input class="col-12 p-0 text-center" name="amount" type="number" value="{{$Stock_row->amount}}">
                    </div>
                    <div class="row m-0">

                      <div class="form-group col p-0">
                        <div class="col-12 p-0">ราคาขาย</div>
                        <input class="col-12 p-0 text-center" name="spent_price" type="text" value="{{$Stock_row->spent_price}}">
                      </div>
                  
                      <div class="form-group col p-0 ml-2">
                        <div class="col-12 p-0">หน่วยขาย</div>
                        <input class="col-12 p-0 text-center" name="spent_unit" type="text" value="{{$Stock_row->spent_unit}}">
                      </div>
                    </div>
                    <div class="row">
                        <div class="mx-auto my-3">
                            <button class="btn px-4" name="create" type="submit" style="background-color: #D7B0EF; color:white;" value="บันทึกข้อมูล">บันทึก</button>
                            <a class="btn px-4" href="{{asset('stock')}}" type="button" style="background-color: #FF8D8D; color:white;">ยกเลิก</a>
                        </div>
                    </div>
                  </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    @endforeach --}}


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