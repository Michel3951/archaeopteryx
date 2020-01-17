@extends('layouts.app')

@section('content')
    <domain-file-content path="{{ $path }}" :file="{{ JS::JSON_parse($file) }}" :domain="{{ JS::JSON_parse($domain) }}"/>
@stop
