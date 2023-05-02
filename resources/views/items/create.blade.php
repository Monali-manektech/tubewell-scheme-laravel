@extends('layouts.admin.app')

@section('contents')
    <livewire:item-component :master_phase_slug="$master_phase_slug" :parent_id="$parent_id"/>
@endsection
