@extends('layouts.app')
@section('content')
@include('menu')
<clientes-edit-page :cliente="{{$cliente}}"></clientes-edit-page>
@endsection
