@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card card-default">
                <div class="card-header">Log New Report</div>

                <div class="card-body">
                    <create-entry-component
                        :initialuserid="{{ $userId }}"
                        :initiallocations="{{ $locations }}"
                        :initialconditions="{{ $conditions }}"
                    ></create-entry-component>
                </div>          
            </div>
        </div>
    </div>
</div>
@endsection
