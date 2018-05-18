@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card card-default">
                <div class="card-header">Records</div>

                <div class="card-body">
                    <list-reports-component
                        :initialreports="{{ $reports }}"
                    ></list-reports-component>
                </div>          
            </div>
        </div>
    </div>
</div>
@endsection
