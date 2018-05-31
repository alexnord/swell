@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card card-default">
                <div class="card-header">Report #{{ $report->id }}</div>
                    <div class="card-body text-center swell-data my-20">
                        <show-report-component
                            :initialdata="{{ json_encode($report) }}"
                        ></show-report-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
