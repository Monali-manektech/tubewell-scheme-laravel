@extends('layouts.admin.app')

@section('contents')
    <div class="row mb-2">
        <div class="col-md-6">
            <button class="ml-2 btn btn-primary" onclick="javascript:history.back()">Go Back</button>
        </div>
    </div>
    <livewire:legend-component :master_phase_slug="$master_phase_slug"/>
@endsection
