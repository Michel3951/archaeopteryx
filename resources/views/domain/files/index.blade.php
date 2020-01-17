@extends('layouts.app')

@section('content')
    <domain-file-list path="{{ $path }}" :files="{{ JS::JSON_parse($files) }}" :domain="{{ JS::JSON_parse($domain) }}"/>
@stop
