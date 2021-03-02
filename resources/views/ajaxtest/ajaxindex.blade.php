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
<div class="container col-11 col-md-9">
  <div class="mx-auto col-12 p-0">
      @include('inc.error')
  </div>

  <div class="form-row mx-0 my-auto">
      <div class="col-12 my-auto px-0 h3">AJAXคลังสินค้า</div>
      
      <div class="col-7 col-sm-8 col-lg-10 p-0 mt-3">
        <div class="col-12 pl-0">
          <input type="text" id="search-bar" class="form-control search-input m-0" placeholder="Search..." />
          <button data-toggle="modal" data-target="#addStockModal">ADD</button>
        </div>
      </div>
    </div>



    <div class="tb-search-wrapper mt-4">
      <table id="tb-stocks" class="re-table table-mobile table-stocks mt-2 mb-4">
        <thead>
            <tr>
                <th class="text-lg-center sorting_disabled" scope="col">No.</th>
                <th class="text-lg-center sorting_disabled" scope="col">รายการสินค้า </th>
                <th class="text-lg-right px-lg-0 sorting_disabled" scope="col">ราคา/หน่วย</th>
                <th class="text-lg-right px-lg-0 sorting_disabled" scope="col">จำนวนคงเหลือ</th>
                <th class="text-lg-center sorting_disabled" scope="col"></th>
            </tr>
        </thead>

        <tbody>
            @foreach($stocks as $stock)
            <tr>
              <td class="text-xl-center px-0">
                <div class="pl-2">{{$stock->id}}</div>
              </td>
              <td class="px-0">
                <div class="pl-2"><span class="stock-extra-unit"></span>{{$stock->name}}</div>
              </td>
              <td class="text-xl-right px-0"><div class="pl-2"><span class="stock-extra-unit">ราคา/หน่วย : </span>{{$stock->spent_price}}<span class="stock-extra-unit"> บาท </div></td>
              <td class="text-xl-right px-0"><div class="pl-2"><span class="stock-extra-unit">จำนวน : </span>{{$stock->amount}}<span class="stock-extra-unit"></span></div></td>
              <td class="text-center px-0">
                  <button class="btn col-4 green-btn btn-sm" type="button" data-toggle="modal" data-target="">แก้ไข</button>
                  <button class="btn col-4 red-btn btn-sm"  type="button" data-toggle="modal" data-target="" >ลบ</button>
                </td>
            </tr>
            @endforeach
        </tbody>

      </table>
    </div>
    
    <div class="modal fade" id="addStockModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">เพิ่มสินค้า</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="addform">
              {{-- {{ csrf_field() }} --}}

              <div class="modal-body">
                <label>ชื่อสินค้า</label>
                <input name="stock_name" />
                <br>
                <label>ราคารับ</label>
                <input name="recived_price" />
                <br>
                <label>ราคาขาย</label>
                <input name="spent_price" />
                <br>
                <label>หน่วย</label>
                <input name="unit" />
                <br>
                <label>จำนวน</label>
                <input name="amount" />
                <br>
              </div>
            
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">เพิ่มสินค้า</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
              </div>
            </form>
          </div>
        </div>
      </div>


</div>
@endsection


@section('script')



<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

<script type="text/javascript">

    $(document).ready(function(){
        $('#addform').on('submit',function(e){
            e.prevenDefault();

            $.ajax({
                type:   "post",
                url:    "/ajaxstoreadd",
                data: $('#addform').serialize(),
                success: function(response){
                  console.log(response)
                  $('addStockModal').model('hide');
                  alert('data saved')
                },
                error: function(error){
                  console.log(error);
                  alert('data not  saved')
                }
            });
        }); 
    });

</script>

@endsection
