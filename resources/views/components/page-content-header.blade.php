<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ $title ?? '' }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    @forelse ($breadcrumb as $key => $value)
                        @if(isset($value['link']))
                            <li class="breadcrumb-item">
                                <a href="{{ $value['link'] ?? '#' }}">{{ $value['title'] ?? '' }}</a>
                            </li>
                        @else
                        <li class="breadcrumb-item">
                            {{ $value['title'] ?? '' }}
                        </li>
                        @endif
                    @empty
                    @endforelse
                </ol>
            </div>
        </div>
    </div>
</div>
