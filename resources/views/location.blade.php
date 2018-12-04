@extends('layouts.app')

@section('content')
<location-component
    :initialdata="{{ $data }}"
></location-component>
@endsection
