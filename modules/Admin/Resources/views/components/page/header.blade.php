@section('title')
    @isset($subtitle)
        {{  "{$subtitle} - {$title}" }}
    @else
        {{ $title }}
    @endisset
@endsection

@section('content_header')
    <h3>{{ $title }}</h3>

    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard.index') }}" class="breadcrumb-home-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M12 18V15" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M10.07 2.81997L3.13999 8.36997C2.35999 8.98997 1.85999 10.3 2.02999 11.28L3.35999 19.24C3.59999 20.66 4.95999 21.81 6.39999 21.81H17.6C19.03 21.81 20.4 20.65 20.64 19.24L21.97 11.28C22.13 10.3 21.63 8.98997 20.86 8.36997L13.93 2.82997C12.86 1.96997 11.13 1.96997 10.07 2.81997Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </li>

        {{ $slot }}
    </ol>
@endsection
