@if (session()->has('success'))
    <div class="alert alert-success">
        <strong>Success!</strong> {{ session()->get('success') }}
    </div>
@endif
@if (session()->has('error'))
    <div class="alert alert-danger">
        <strong>Danger!</strong> {{ session()->get('error') }}
    </div>
@endif
@if (session()->has('info'))
    <div class="alert alert-info">
        <strong>Info!</strong> {{ session()->get('info') }}
    </div>
@endif

@if (session()->has('warning'))
    <div class="alert alert-warning">
        <strong>Warning!</strong> {{ session()->get('warning') }}
    </div>
@endif