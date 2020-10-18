@extends('layouts.app')
@section('content')
@include('menu')
<propiedades-create-page :tipos="{{$tipos}}"></categorias-create-page>
@endsection
