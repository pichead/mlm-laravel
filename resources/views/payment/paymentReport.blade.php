@extends('layouts.web')

@section('content')
<br>
<div class="container col-11 col-md-11 col-xl-8">
    <div class="row">
      <div class="col-md-4 h3 pl-0">แจ้งโอน</div>
    </div>
    <br>

    <div class="row mb-3">
      <div class="col-12 mx-auto">
        <div class="row py-3 border border-secondary" style="background-color:white;">
          <div class="col-12 col-md-2 my-md-auto my-1">
            <span class="d-md-none">Payment ID: </span>50342
          </div>
          <div class="col-12 col-md my-md-auto my-1">
            <span class="d-md-none">วันที่ : </span>2020-09-10 04:25:36
          </div>
          <div class="col-12 col-md my-md-auto my-1">
            รวมทั้งหมด 2400 บาท
          </div>
          <div class="col-12 col-md-2 my-md-auto my-1">
            สถานะ : ชำระเงิน
          </div>
        </div>
      </div>
    </div>


    <div class="row mt-3">
      <div class="col-12">
        <div class="row px-4 py-4 border border-secondary" style="background-color:white;">
          <div class="col-md-6 col-12">
            <form>
              <div class="form-row">
                  <div class="col-4 my-auto">
                      วันที่โอนเงิน
                  </div>
                  <div class="col">
                      <input type="date" class="form-control">
                  </div>
              </div>
            </form>
            <br>
            <form>
              <div class="form-row">
                  <div class="col-4 my-auto">
                      เวลาที่โอนเงิน
                  </div>
                  <div class="col">
                      <input type="time" class="form-control">
                  </div>
              </div>
            </form>
            <br>
           
            <form>
              <div class="form-row">
                  <div class="col-4 my-auto">
                      เวลาที่โอนเงิน
                  </div>
                  <div class="col">
                    <div class="row m-0">
                      <input type="number" class="col-9 form-control" placeholder="ระบุจำนวนเงิน">
                      <div class="col-3 my-auto">บาท</div>
                    </div>
                  </div>
              </div>
            </form>
            <br>
            <div>จาก</div>
            <br>
            <form>
              <div class="form-row">
                  <div class="col-4 my-auto">
                      ธนาคาร
                  </div>
                  <div class="col">
                      <input type="text" class="form-control" placeholder="ระบุธนาคาร">
                  </div>
              </div>
            </form>
            <br>
            <form>
              <div class="form-row">
                  <div class="col-4 my-auto">
                      เลขที่บัญชี
                  </div>
                  <div class="col">
                      <input type="text" class="form-control" placeholder="ระบุเลขบัญชี">
                  </div>
              </div>
            </form>
            <br>
            <div>โอนไปที่</div>
            <br>
            <form>
              <div class="form-row">
                  <div class="col-4 my-auto">
                      ธนาคาร
                  </div>
                  <div class="col">
                      <input type="text" class="form-control" placeholder="ระบุธนาคาร">
                  </div>
              </div>
            </form>
            <br>
            <form>
              <div class="form-row">
                  <div class="col-4 my-auto">
                      เลขที่บัญชี
                  </div>
                  <div class="col">
                      <input type="text" class="form-control" placeholder="ระบุเลขบัญชี">
                  </div>
              </div>
            </form> 
          </div>







          <div class="col-md-6 col-12">
            <div class="row align-items-center col-12 w-100 h-100" style="border-style: dashed ;">

                <div class="col text-center">อัพโหลดรูปถาพ</div>

            </div>
          </div>
          <div class="mx-auto mt-3">
              <button class="btn px-4" type="button" style="background-color: #72CAFF; color:white">แจ้งโอน</button>
              <a class="btn px-4" type="button" href="{{asset('paymentList')}}" style="background-color: #FF8D8D; color:white;">ยกเลิก</a>
          </div>
        </div>
      </div>
    </div>
    <br>
</div>
@endsection

@section('script')


@endsection
