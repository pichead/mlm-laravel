@extends('layouts.web')

@section('content')
<br>
<div class="container col-11 col-md-11 col-xl-10">
    <div class="row">
      <div class="col-md-4 h3 pl-0">รายการโอน</div>
    </div>
    <br>
    @foreach($Payment as $Payment_row)
    <div class="row mb-3">
      <div class="col-12 mx-auto">
        <div class="row py-3 border border-secondary" style="background-color:white;">
          <div class="col-12 col-md-2 my-md-auto my-1">
            Payment ID: {{$Payment_row->payment_id}}
          </div>
          <div class="col-12 col-md my-md-auto my-1">
            <span class="d-md-none">วันที่ : </span>{{$Payment_row->time}}
          </div>
          <div class="col-12 col-md my-md-auto my-1">
            รวมทั้งหมด {{$Payment_row->price}} บาท
          </div>
          <div class="col-12 col-md-2 my-md-auto my-1">
            สถานะ : {{$Payment_row->payment_status}}
          </div>
          <div class="col-5 col-md-2 my-md-auto my-1">
             <a class="btn col-12" href="{{asset('paymentReport')}}" style="background-color: #72CAFF;color:white">แจ้งโอน</a>
          </div>
        </div>
      </div>
    </div>
    @endforeach
    <div class="row">
      <div class="col-12 text-center">
        {{ $Payment->links() }}
      </div>
    </div>


</div>
@endsection
