@extends('layouts.app')

@section('content')
    <domain-create old="{{ JS::JSON_parse(old()) }}" errors="{{ JS::JSON_parse($errors) }}" presets="{{ JS::JSON_parse($presets) }}"/>
@stop
