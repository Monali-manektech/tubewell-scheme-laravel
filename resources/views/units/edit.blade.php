@extends('layouts.admin.app')
@section('contents')
    <livewire:unit-component :master_phase_slug="$master_phase_slug" :unit="$unit"/>
@endsection
