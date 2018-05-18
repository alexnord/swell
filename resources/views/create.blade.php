@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card card-default">
                <div class="card-header">Create Entry</div>

                <div class="card-body">
                    <create-entry-component
                        :initialuserid="{{ $userId }}"
                        :initiallocations="{{ $locations }}"
                        :initialdirections="{{ $directions }}"
                        :initialtides="{{ $tideDirs }}"
                        :initialconditions="{{ $conditions }}"
                    ></create-entry-component>
                </div>          
            </div>
        </div>
    </div>
</div>
@endsection
