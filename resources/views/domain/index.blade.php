@extends('layouts.app')

@section('content')
    <domain-list domains="{{ JS::JSON_parse($domains) }}"/>
@stop
