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
    <div class="container mb-3 col-12">
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
    <div class="row">
    <a class="text-center col-12" style="color: red" href="{{asset('EditUser')}}">ท่านยังไม่ไม่ได้เพิ่มบัญชีธนาคาร กรุณาเพิ่มบัญชีธนาคารก่อน คลิกที่นี่เพื่อเพิ่มธนาคาร</a>
    </div>
    @endif  
    <div class="form-row mx-0 my-auto">
        <div class="col-12 my-auto px-0 h3">คลังสินค้า</div>
        
        <div class="col-7 col-sm-8 col-lg-10 p-0 mt-3">
          <div class="col-12 pl-0">
            <input type="text" id="search-bar" class="form-control search-input m-0" placeholder="Search..." />
          </div>
        </div>
        <div class="col-5 col-sm-4 col-lg-2 mt-3 px-0 clearfix">
          <a class="btn col float-right px-auto blue-btn" href="{{asset('/stock/create')}}" >สร้างสินค้า</a>
        </div>
      </div>



      <div class="tb-search-wrapper mt-4">
        <table id="tb-stocks" class="re-table table-mobile table-stocks mt-2 mb-0 mb-md-3">
          <col width="10%">
          <col width="auto">
          <col width="15%">
          <col width="15%">
          <col width="15%">
          <col width="auto">
          <thead>
              <tr>
                  <th class="text-lg-center sorting_disabled" scope="col">ลำดับ</th>
                  <th class="text-lg-center sorting_disabled" scope="col">รายการสินค้า </th>
                  <th class="text-lg-right pr-lg-3 sorting_disabled" scope="col">ราคาต้นทุน/หน่วย</th>
                  <th class="text-lg-right pr-lg-3 sorting_disabled" scope="col">ราคาขาย/หน่วย</th>
                  <th class="text-lg-right pr-lg-3 sorting_disabled" scope="col">จำนวนคงเหลือ</th>
                  <th class="text-lg-center sorting_disabled" scope="col"></th>
              </tr>
          </thead>

          <tbody>
            @foreach($Stock as $Stock_row)
              <tr>
                <td class="text-xl-center px-0">
                  <div class="pl-2 pl-lg-0">{{$loop->index+1}}</div>
                </td>
                <td class="px-0">
                  <div class="pl-2 pl-lg-0"><span class="stock-extra-unit">{{$loop->index+1}}. </span>{{$Stock_row->name}}</div>
                </td>
                <td class="text-xl-right px-0"><div class="pr-3 pl-2 pl-lg-0"><span class="stock-extra-unit">ราคา/หน่วย : </span>{{number_format($Stock_row->received_price,2)}} <span class="stock-extra-unit">บาท </div></td>
                <td class="text-xl-right px-0"><div class="pr-3 pl-2 pl-lg-0"><span class="stock-extra-unit">ราคาขาย/หน่วย : </span>{{number_format($Stock_row->spent_price,2)}} <span class="stock-extra-unit">บาท </div></td>
                <td class="text-xl-right px-0"><div class="pr-3 pl-2 pl-lg-0"><span class="stock-extra-unit">จำนวน : </span> {{number_format($Stock_row->amount,0)}} {{$Stock_row->spent_unit}}</div></td>
                <td class="text-center px-0">
                    <button class="btn col-5 green-btn btn-sm" type="button" data-toggle="modal" data-target="#editModal{{$loop->index+1}}">แก้ไข</button>
                    <button class="btn col-5 red-btn btn-sm"  type="button" data-toggle="modal" data-target="#delModal{{$loop->index+1}}" >ลบ</button>
                  </td>
                  
              </tr>
            @endforeach
          </tbody>

        </table>
      </div>


      @foreach($Stock as $Stock_row)
        <div class="modal" id="delModal{{$loop->index+1}}" aria-hidden="true" style="display: none;">
          <div class="modal-dialog modal-md">
            <div class="modal-content py-4">
              <div class="modal-header col-11 mx-auto">
                <h3 class="modal-title">ลบสินค้า: {{$Stock_row->name}}</h3>
                <input name="stock_id" class="d-none" value="{{$Stock_row->id}}">
              </div>
              <div class="modal-body col-11 mx-auto">


                <form method="post" action="{{asset('StoreDel').'/'.$Stock_row->id}}" enctype="multipart/form-data">
                  {{method_field('PUT')}}
                  @csrf
                    <div class="my-2">
                      <div class="h5">ต้องการลบสินค้า "{{$Stock_row->name}}" หรือไม่</div>
                      <div class="h5 mt-2">เมื่อกดลบสินค้าแล้วจะไม่สามารถแก้ไขได้</div>
                      <div class="row">
                          <div class="mx-auto my-3">
                              <button class="btn px-4 red-btn" name="create" type="submit"  value="ลบสินค้า" >ลบสินค้า</button>
                              <button class="btn px-4 purple-btn" data-dismiss="modal" type="button">ยกเลิก</button>
                          </div>
                      </div>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      @endforeach

      @foreach($Stock as $Stock_row)
        <div class="modal" id="editModal{{$loop->index+1}}" aria-hidden="true" style="display: none;">
          <div class="modal-dialog modal-md">
            <div class="modal-content py-4">
              <div class="modal-header col-11 mx-auto">
                <h3 class="modal-title">สินค้า: {{$Stock_row->name}}</h3>
              </div>
              <div class="modal-body col-11 mx-auto">


                <form method="post" action="{{asset('StoreUpdate').'/'.$Stock_row->id}}" enctype="multipart/form-data">
                  {{method_field('PUT')}}
                  @csrf
                    <div class="my-2 mx-5">
                      <div class="form-group">
                        <div class="col-12 p-0">ชื่อสินค้า </div>
                        <input class="col-12 p-0 form-control text-center" name="name" type="text" value="{{$Stock_row->name}}" >
                      </div>
                      <div class="form-group">
                        <div class="col-12 p-0">จำนวน</div>
                        <input class="col-12 p-0 form-control text-center" name="amount" type="number" value="{{$Stock_row->amount}}">
                      </div>
                      <div class="row m-0">

                        <div class="form-group col p-0">
                          <div class="col-12 p-0">ราคาต้นทุน</div>
                          <input class="col-12 p-0 form-control text-center" name="recived_price" type="number" value="{{$Stock_row->received_price}}">
                        </div>
                    
                        <div class="form-group col p-0 ml-2">
                          <div class="col-12 p-0">ราคาขาย</div>
                          <input class="col-12 p-0 form-control text-center" name="spent_price" type="number" value="{{$Stock_row->spent_price}}">
                        </div>
                      </div>
                      <div class="row m-0">
                        <div class="form-group col p-0">
                          <div class="col-12 p-0">หน่วยขาย</div>
                          <input class="col-12 p-0 form-control text-center" name="spent_unit" type="text" value="{{$Stock_row->spent_unit}}">
                        </div>
                      </div>
                      <div class="row">
                          <div class="mx-auto my-3">
                              <button class="btn px-4 purple-btn" name="create" type="submit" value="บันทึกข้อมูล">บันทึก</button>
                              <button class="btn px-4 red-btn" data-dismiss="modal" type="button">ยกเลิก</button>
                          </div>
                      </div>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      @endforeach


  
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
