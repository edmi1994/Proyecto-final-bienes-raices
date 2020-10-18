@extends('layouts.app')
@section('content')
@include('menu')
<propiedades-edit-page :propiedad="{{$propiedad}}" :tipos="{{$tipos}}"></propiedades-edit-page>
@endsection
