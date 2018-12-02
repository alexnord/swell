@extends('layouts.app')

@section('content')
<dashboard-component
    :initialdata="{{ $data }}"
></dashboard-component>
@endsection
