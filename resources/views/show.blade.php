@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card card-default">
                <div class="card-header">Report #{{ $report->id }}</div>

                <div class="card-body text-center swell-data my-20">

                    <div class="row mb-20">
                        <div class="col">
                            <h2>{{ $report->formatted_date }}</h1>
                            <h3>{{ $report->formatted_start_time }} - {{ $report->formatted_end_time }}</h2>
                        </div>
                    </div>

                    <show-report-component
                        :initialdata="{{ json_encode($report) }}"
                    ></show-report-component>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
