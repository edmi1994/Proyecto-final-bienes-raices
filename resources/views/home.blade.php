@extends('layouts.app')
@section('content')
@include('menu')
<home-component :tipos="{{$tipos}}"></home-component>
@endsection
