@extends('layouts.web')



@section('content')

<div class="col-6 mx-auto">
  @foreach($user as $user_row)
    {{$user_row->id}} {{$user_row->name}}
    <br>
  @endforeach

</div>
@endsection
