
@extends('layouts.admin.app')

@section('contents')
<div class="card text-start">
    <div class="card-header">
    </div>
    <div class="card-body">
        <form action="{{ route('items.import') }}"
            method="POST"
            enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" class="form-control">
            <br>
            <button type="submit" class="btn btn-success">
                Import Item Data
            </button>
        </form>
    </div>
</div>
@endsection