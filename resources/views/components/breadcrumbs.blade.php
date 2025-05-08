<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light p-2 rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>

            @foreach ($breadcrumbs as $breadcrumb)
                @if ($loop->last)
                    {{-- This is the dynamic final breadcrumb --}}
                    <li class="breadcrumb-item active" id="breadcrumb-style">
                        {{ $breadcrumb['name'] }}
                    </li>
                @else
                    <li class="breadcrumb-item">
                        <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['name'] }}</a>
                    </li>
                @endif
            @endforeach
        </ol>
    </nav>
</div>
