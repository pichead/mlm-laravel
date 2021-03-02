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
@php
    $level = Auth::user()->level_id ;
@endphp
<div class="col-11 mx-auto">
  <div class="content-wrapper">
    <div class="container  mb-5 col-12">
    <div class="mx-auto col-12 p-0">
        @include('inc.error')
    </div>
    @if ($level == 1)
    <div class="form-row mx-0 my-auto">
        <div class="col-12 my-auto px-0 h3">รายการตัวแทน</div>
        <div class="col-12 col-md-6 col-lg-8 p-0 mt-3">
            <div class="col-12 pl-lg-0 px-0">
              <input type="text" id="search-bar" class="form-control search-input m-0" placeholder="Search..." />
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-4 mt-3 d-flex justify-content-center px-0">
            <a class="btn col ml-md-3 px-auto blue-btn" href="{{asset('userSignup')}}" >สร้างตัวแทน</a>
            <a class="btn col ml-3 px-auto hblue-btn" href="{{asset('Treeview')}}" >มุมมองเครือข่าย</a>
          </div>
    </div>
    @elseif($level == 2)
    <div class="form-row mx-0 my-auto">
      <div class="col-12 my-auto px-0 h3">รายการลูกทีม</div>
      <div class="col-12 col-md-8 col-lg-10 p-0 mt-3">
        <div class="col-12 pl-lg-0 px-0">
          <input type="text" id="search-bar" class="form-control search-input m-0" placeholder="Search..." />
        </div>
      </div>
      <div class="col-12 col-md-4 col-lg-2 mt-3 d-flex justify-content-center px-0 ">
        <a class="btn col ml-md-3 blue-btn" href="{{asset('userSignup')}}" >สร้างลูกทีม</a>
      </div>
    </div>
    @endif


    
    <div class=" mt-4">
        <table id="tb-stocks" class="re-table table-mobile table-stocks mt-2 mb-4">
          <col width="7%">
          <col width="auto">
          <col width="20%">
          <col width="27%">
          <col width="18%">
          <thead>
            <tr>
                <th class="text-lg-center" scope="col">ลำดับ</th>
                <th class="text-lg-center" scope="col">ชื่อ-สกุล</th>
                <th class="text-lg-center" scope="col">เบอร์ติดต่อ</th>
                <th class="text-lg-center" scope="col">อีเมล</th>
                <th class="text-lg-center" scope="col"></th>
            </tr>
        </thead>

        <tbody>
            @php
                $count = 0;
            @endphp
            @foreach($UserTree as $User_row)
                
                @php
                    $childs = App\Models\User::where('id',$User_row->child_id)->get();                   
                @endphp
                
                
                @foreach($childs as $child)
                  @php
                      $count = $count+1;
                  @endphp
                <tr>
                    <td class="text-xl-center px-0"><div class="pl-2 pl-lg-0">{{$count}}</div></td>
                    <td class="px-0"><div class="pl-2"><span class="stock-extra-unit">{{$count}}. </span>{{$child->name}}</div></td>
                    <td class="text-xl-center px-0" ><div class="pl-2"><span class="stock-extra-unit">เบอร์ติดต่อ : </span>0{{$child->tel}}</div></td>
                    <td class=" px-0"><div class="pl-2 pl-lg-4"><span class="stock-extra-unit">อีเมล : </span>{{$child->email}}</div></td>
                    <form method="POST" class="col px-0" action="{{asset('ResetPassword')}}"  enctype="multipart/form-data">
                      {{method_field('PUT')}}
                      @csrf
                    <td class="d-flex justify-content-center px-0">
                        <a class="btn mr-2 green-btn btn-sm col-5 col-lg-5"  href="{{asset('price').'/'.$child->id}}">เรทราคา</a>
                        
                        <button class="btn red-btn btn-sm col-5 col-lg-5" type="submit" name="id" value="{{$child->id}}">รีเซ็ตรหัสผ่าน</button>
                        
                    </td>
                  </form>
                </tr>
                @endforeach
                
            @endforeach

            
        </tbody>
        </table>
    </div>


</div>
  </div>
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
