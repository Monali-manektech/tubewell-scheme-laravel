@extends('layouts.admin.app')

@section('contents')
    @include('alert')
    <livewire:item-component :master_phase_slug="$master_phase_slug" :item="$item"/>
@endsection
