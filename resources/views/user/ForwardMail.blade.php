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
<div class="container mb-5 col-11 col-md-9">
  <div class="mx-auto col-12 p-0">
    @include('inc.error')
</div>
    <div class="form-row mx-0 my-auto">
      <div class="col-12 my-auto px-0 h3">ส่งต่ออีเมล</div>
      <div class="col-12 col-md-8 col-lg-10 p-0 mt-3">
        <div class="col-12 pl-lg-0 px-0">
          <input type="text" id="search-bar" class="form-control search-input m-0" placeholder="Search..." />
        </div>
      </div>
      <div class="col-12 col-md-4 col-lg-2 mt-3 d-flex justify-content-center px-0 ">
        <button class="btn blue-btn col ml-md-3" data-toggle="modal" data-target="#CreateMail" type="button" >เพิ่มอีเมล</button>
      </div>
    </div>
    

    <div class="tb-search-wrapper mt-4">
      <table id="tb-stocks" class="re-table table-mobile table-stocks mt-2 mb-4">
        <col width="auto">
      <col width="auto">
      <col width="auto">
      <col width="350px">
        <thead>
            <tr>
                <th class="text-lg-center sorting_disabled" scope="col">ลำดับ</th>
                <th class="text-lg-center sorting_disabled" scope="col">ชื่อ-นามสกุล</th>
                <th class="text-lg-right sorting_disabled" scope="col">อีเมล</th>
                <th class="text-lg-center sorting_disabled" scope="col"></th>
            </tr>
        </thead>

        <tbody>
          @foreach($Forward_Mails as $Forward_Mail)
            <tr>
              <td class="text-lg-center px-0"><div class="pl-2">{{$loop->index+1}}</div></td>
              <td class="px-0"><div class="pl-2">
                  <span class="stock-extra-unit">{{$loop->index+1}}. </span>{{$Forward_Mail->name}}</div>
              </td>
              <td class="text-xl-right px-0"><div class="pl-2"><span class="stock-extra-unit">อีเมล : </span>{{$Forward_Mail->forward_email}}</div></td>
              <td class="d-flex justify-content-center px-0">
                  <button class="btn col-4 green-btn mr-2 btn-sm" type="button" data-toggle="modal" data-target="#editModal{{$loop->index+1}}">แก้ไข</button>
                  <button class="btn col-4 red-btn btn-sm"  type="button" data-toggle="modal" data-target="#delModal{{$loop->index+1}}" >ลบ</button>
              </td>
            </tr>
          @endforeach
        </tbody>

      </table>
    </div>

    {{-- del model --}}
    @foreach($Forward_Mails as $Forward_Mail)
      <div class="modal" id="delModal{{$loop->index+1}}" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-md">
          <div class="modal-content py-4">
            <div class="modal-header col-11 mx-auto">
              <h3 class="modal-title">ลบอีเมล: {{$Forward_Mail->name}}</h3>
              <input name="mail_id" class="d-none" value="{{$Forward_Mail->id}}">
            </div>
            <div class="modal-body col-11 mx-auto">
              <div class="my-2">
                <div class="h5">ต้องการลบอีเมลชื่อ : {{$Forward_Mail->name}}</div>
                <div class="h5">อีเมล : {{$Forward_Mail->forward_email}} หรือไม่</div>
                <div class="h5 mt-2">เมื่อกดลบแล้วจะไม่สามารถแก้ไขได้</div>
                <div class="row">
                    <div class="mx-auto my-3">
                        <a class="btn px-4 red-btn" href="{{asset('ForwardMailDel').'/'.$Forward_Mail->id}}" >ลบอีเมล</a>
                        <button class="btn px-4 purple-btn" data-dismiss="modal" type="button" >ยกเลิก</button>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endforeach


    {{-- edit model --}}
    @foreach($Forward_Mails as $Forward_Mail)

      <div class="modal" id="editModal{{$loop->index+1}}" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-md">
          <div class="modal-content py-4">
            <div class="modal-header col-11 mx-auto">
              <h3 class="modal-title">แก้ไขอีเมล</h3>
            </div>
            <div class="modal-body col-11 mx-auto">

              <form method="post" class="was-validated" action="{{asset('ForwardMailUpdate').'/'.$Forward_Mail->id}}" enctype="multipart/form-data">
                {{method_field('PUT')}}
                @csrf
                  <div class="my-2 mx-5">
                    <div class="form-group">
                      <div class="col-12 p-0">ชื่อบัญชี</div>
                      <input class="col-12 p-0 text-center form-control" name="name" type="text" value="{{$Forward_Mail->name}}" required>
                    </div>
                    <div class="form-group">
                      <div class="col-12 p-0">อีเมล</div>
                      <input class="col-12 p-0 text-center form-control" name="email" type="text" value="{{$Forward_Mail->forward_email}}" required>
                    </div>
                    <div class="row">
                        <div class="mx-auto my-3">
                            <button class="btn px-4 purple-btn" name="create" type="submit"  value="บันทึกข้อมูล">บันทึก</button>
                            <button class="btn px-4 red-btn" data-dismiss="modal" type="button" >ยกเลิก</button>
                        </div>
                    </div>
                  </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    @endforeach

    {{-- create model --}}
    <div class="modal" id="CreateMail" aria-hidden="true" style="display: none;">
      <div class="modal-dialog modal-md">
        <div class="modal-content py-4">
          <div class="modal-header col-11 mx-auto">
            <h3 class="modal-title">เพิ่มอีเมลใหม่</h3>
          </div>
          <div class="modal-body col-11 mx-auto">
            <form method="post" class="was-validated" action="{{asset('ForwardMailCreate')}}" enctype="multipart/form-data">
              @csrf
                <input class="d-none" name="user_id" value="{{$user->id}}">
                <div class="my-2 mx-5">
                  <div class="form-group">
                    <div class="col-12 p-0">ชื่อบัญชี</div>
                    <input class="col-12 p-0 text-center form-control" name="name" type="text" required>
                  </div>
                  <div class="form-group">
                    <div class="col-12 p-0">อีเมล</div>
                    <input class="col-12 p-0 text-center form-control" name="email" type="email" required>
                  </div>
                  <div class="row">
                      <div class="mx-auto my-3">
                          <button class="btn px-4" name="create" type="submit" style="background-color: #D7B0EF; color:white;" value="บันทึกข้อมูล">บันทึก</button>
                          <a class="btn px-4" data-dismiss="modal" type="button" style="background-color: #FF8D8D; color:white;">ยกเลิก</a>
                      </div>
                  </div>
                </div>
            </form>
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
