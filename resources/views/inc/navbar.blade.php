<nav class="navbar fixed-top navbar-dark navbar-expand-sm p-0" style="background-color:#666a77;">
    <div class="container px-0 mx-0 mx-lg-5 px-lg-5 col-12 pr-lg-5">
        <img class="ml-4 ml-md-0 ml-lg-auto" src="{{ URL::to('others/favicon/vdealer-logo-sq300.png') }}" width="65" height="65">
        <button class="navbar-toggler mr-4" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse " id="navbarNav" >
            <ul class="navbar-nav ml-0 ml-sm-auto" >
                @php
                    $user = Auth::user()->id;
                    $itemss = App\Models\Cart::where("user_id",$user)->get();
                    $price = App\Models\Price::where('user_id',$user)->get();

                    foreach($itemss as $item_row){
                        $price_item = App\Models\Price::where('user_id',$user)->where('stock_id',$item_row->stock_id)->get();
                        $array_price = [];
                        foreach($price_item as $price_item_row){
                            if($item_row->amount >= $price_item_row->start_total && $item_row->amount <= $price_item_row->end_total){
                                array_push($array_price,$price_item_row->price); 
                            }
                        }
                        if($array_price == []){
                            $del_item = App\Models\Cart::where('id',$item_row->id)->first();
                            $del_item->delete();
                        }
                    }
                    $level = Auth::user()->level_id ;
                    $cart_count = App\Models\Cart::where('user_id',Auth::user()->id)->count();
                @endphp
                {{-- ลูกทีม --}}
                @if($level == 3)
                <li style="height: 65px;" class="nav-item mx-1 my-auto {{Request::is('stock')  ? 'border-bottom-white' : ''}}">
                    <a class="nav-link navFont py-4 ml-4 ml-md-0" href="{{asset('stock')}}">รายการสินค้า</a>
                </li>
                <li style="height: 65px;" class="nav-item mx-1 my-auto {{Request::is('BuyList') ? 'border-bottom-white' : ''}}">
                    <a class="nav-link navFont py-4 ml-4 ml-md-0" href="{{asset('BuyList')}}">ประวัติการสั่งซื้อ</a>
                </li>


                {{-- ตัวแทน --}}
                @elseif($level == 2)
                <li style="height: 65px;" class="nav-item mx-1 my-auto {{Request::is('stock') ? 'border-bottom-white' : ''}}">
                    <a class="nav-link navFont py-4 ml-4 ml-md-0" href="{{asset('stock')}}">รายการสินค้า</a>
                </li>
                <li style="height: 65px;" class="nav-item mx-1 my-auto {{Request::is('BuyList') ? 'border-bottom-white' : ''}}">
                    <a class="nav-link navFont py-4 ml-4 ml-md-0" href="{{asset('BuyList')}}">ประวัติการสั่งซื้อ</a>
                </li>
                <li style="height: 65px;" class="nav-item mx-1 my-auto {{Request::is('SaleList') ? 'border-bottom-white' : ''}}">
                    <a class="nav-link navFont py-4 ml-4 ml-md-0" href="{{asset('SaleList')}}">ประวัติการขาย</a>
                </li>



                {{-- ผู้ดูแลระบบ --}}
                @else
                <li style="height: 65px;" class="nav-item mx-1 my-auto {{Request::is('stock') ? 'border-bottom-white' : ''}}" style="border-bottom: 5px;" >
                    <a class="nav-link navFont py-4 ml-4 ml-md-0"  href="{{asset('stock')}}" >คลังสินค้า</a>
                </li>
                <li style="height: 65px;" class="nav-item mx-1 my-auto {{Request::is('SaleList') ? 'border-bottom-white' : ''}}">
                    <a class="nav-link navFont py-4 ml-4 ml-md-0" href="{{asset('SaleList')}}">ประวัติการขาย</a>
                </li>
                @endif
                
                
                
                
                @if($level == 3)
                <li style="height: 65px;" class="nav-item mx-1 my-auto {{Request::is('cart') ? 'border-bottom-white' : ''}}">
                    <a class="nav-link navFont py-4 ml-4 ml-md-0"  href="{{asset('cart')}}"><i class="p-0 fas fa-shopping-cart"></i><span class="align-text-top badge badge-pill badge-danger">{{$cart_count}}</span>
                    </a>
                </li>
                @elseif(($level == 1))
                <li style="height: 65px;" class="nav-item mx-1 my-auto {{Request::is('SaleReport') ? 'border-bottom-white' : ''}}">
                    <a class="nav-link navFont py-4 ml-4 ml-md-0" href="{{asset('SaleReport')}}">รายงานยอดขาย</a>
                </li>
                <li style="height: 65px;" class="nav-item mx-1 my-auto {{Request::is('userList') ? 'border-bottom-white' : ''}}">
                    <a class="nav-link navFont py-4 ml-4 ml-md-0" href="{{asset('userList')}}">ตัวแทน</a>
                </li>
                @elseif(($level == 2))
                {{-- <li style="height: 65px;" class="nav-item mx-1 my-auto {{Request::is('SaleReport') ? 'border-bottom-white' : ''}}">
                    <a class="nav-link navFont py-4 ml-4 ml-md-0" href="{{asset('SaleReport')}}">รายงานยอดขาย</a>
                </li> --}}
                <li style="height: 65px;" class="nav-item mx-1 my-auto {{Request::is('userList') ? 'border-bottom-white' : ''}}">
                    <a class="nav-link navFont py-4 ml-4 ml-md-0" href="{{asset('userList')}}">ลูกทีม</a>
                </li>
                <li style="height: 65px;" class="nav-item mx-1 my-auto {{Request::is('cart') ? 'border-bottom-white' : ''}}">
                    <a class="nav-link navFont py-4 ml-4 ml-md-0" href="{{asset('cart')}}"><i class="p-0 fas fa-shopping-cart"></i><span class="align-text-top badge badge-pill badge-danger">{{$cart_count}}</span>
                    </a>
                </li>
                @endif
                
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
                @endif
                @else
                <li style="height: 65px;" class="nav-item dropdown my-auto ml-4 ml-md-0">
                    @php 
                        $level_name = App\Models\UserLevel::where("id",$level)->first();
                    @endphp
                    <a id="navbarDropdown" class="nav-link dropdown-toggle  py-4" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-right " aria-labelledby="navbarDropdown">
                        <a class="dropdown-item px-0 px-md-3" href="{{asset('EditUser')}}">ข้อมูลส่วนตัว ({{$level_name->name}})</a>
                        <a class="dropdown-item px-0 px-md-3" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('ออกจากระบบ') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest
            </ul>



        </div>
    </div>
</nav>
<br>
<br>
<br>
<br>