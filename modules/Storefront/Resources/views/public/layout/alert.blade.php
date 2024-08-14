@if(session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <rect width="24" height="24" rx="6" fill="#E69B00"/>
            <path d="M12 9V14" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
            <circle cx="12" cy="17" r="1" fill="white"/>
        </svg>

        {{ session('success') }}

        <button type="button" data-bs-dismiss="alert" class="close">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                <path opacity="0.6" d="M11 1.00004L1 11M0.999958 1L10.9999 11" stroke="white" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </button>
    </div>
@endif

@if(session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <rect width="24" height="24" rx="6" fill="#E69B00"/>
            <path d="M12 9V14" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
            <circle cx="12" cy="17" r="1" fill="white"/>
        </svg>

        {{ session('error') }}

        <button type="button" data-bs-dismiss="alert" class="close">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                <path opacity="0.6" d="M11 1.00004L1 11M0.999958 1L10.9999 11" stroke="white" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </button>
    </div>
@endif
