@extends('layouts.web')

@section('style')


@endsection

@section('content')
      
      


      <div class="container mb-5">
      <h1 class="text-center">มุมมองเครือข่าย</h1>
      

      <div class="row mt-5">
        @foreach($top as $tops)
          @php 
            $topname = App\Models\User::where('id',$tops->parent_id)->first();
            $child = App\Models\UserTree::where('parent_id',$topname->id)->get();
          @endphp
          <div class="col-12 col-sm-6 col-lg-4  px-0 my-3">
            <div class="mx-auto card  h-100 px-0 col-11">
              <div class="card-header" style="background-color: #a3a8c1; color:white">
                ตัวแทน : {{$topname->name}}
              </div>
              <div class="card-body">
                @foreach($child as $childs)
                  @php
                    $childname = App\Models\User::where('id',$childs->child_id)->first();
                  @endphp
                  <p class="card-title">ลูกทีม : {{$childname->name}}</p>
                  @endforeach
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>


    </div>





@endsection




@section('script')



@endsection
