<div class="modal fade" id="keyboard-shortcuts-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M4.00073 11.9996L12 4.00037" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> 
                        <path d="M12 11.9996L4.00073 4.00037" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </a>
                <h5 class="modal-title">{{ trans('admin::admin.shortcuts.available_shortcuts') }}</h5>
            </div>

            <div class="modal-body">
                <dl class="dl-horizontal">
                    <dt><code>?</code></dt>
                    <dd>{{ trans('admin::admin.shortcuts.this_menu') }}</dd>
                </dl>

                @stack('shortcuts')
            </div>
        </div>
    </div>
</div>

<footer class="main-footer">
    <a href="#" title="{{ trans('admin::admin.shortcuts.keyboard_shortcuts') }}" class="keyboard-shortcuts" data-toggle="modal" data-target="#keyboard-shortcuts-modal">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
            <path d="M64 112c-8.8 0-16 7.2-16 16V384c0 8.8 7.2 16 16 16H512c8.8 0 16-7.2 16-16V128c0-8.8-7.2-16-16-16H64zM0 128C0 92.7 28.7 64 64 64H512c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128zM176 320H400c8.8 0 16 7.2 16 16v16c0 8.8-7.2 16-16 16H176c-8.8 0-16-7.2-16-16V336c0-8.8 7.2-16 16-16zm-72-72c0-8.8 7.2-16 16-16h16c8.8 0 16 7.2 16 16v16c0 8.8-7.2 16-16 16H120c-8.8 0-16-7.2-16-16V248zm16-96h16c8.8 0 16 7.2 16 16v16c0 8.8-7.2 16-16 16H120c-8.8 0-16-7.2-16-16V168c0-8.8 7.2-16 16-16zm64 96c0-8.8 7.2-16 16-16h16c8.8 0 16 7.2 16 16v16c0 8.8-7.2 16-16 16H200c-8.8 0-16-7.2-16-16V248zm16-96h16c8.8 0 16 7.2 16 16v16c0 8.8-7.2 16-16 16H200c-8.8 0-16-7.2-16-16V168c0-8.8 7.2-16 16-16zm64 96c0-8.8 7.2-16 16-16h16c8.8 0 16 7.2 16 16v16c0 8.8-7.2 16-16 16H280c-8.8 0-16-7.2-16-16V248zm16-96h16c8.8 0 16 7.2 16 16v16c0 8.8-7.2 16-16 16H280c-8.8 0-16-7.2-16-16V168c0-8.8 7.2-16 16-16zm64 96c0-8.8 7.2-16 16-16h16c8.8 0 16 7.2 16 16v16c0 8.8-7.2 16-16 16H360c-8.8 0-16-7.2-16-16V248zm16-96h16c8.8 0 16 7.2 16 16v16c0 8.8-7.2 16-16 16H360c-8.8 0-16-7.2-16-16V168c0-8.8 7.2-16 16-16zm64 96c0-8.8 7.2-16 16-16h16c8.8 0 16 7.2 16 16v16c0 8.8-7.2 16-16 16H440c-8.8 0-16-7.2-16-16V248zm16-96h16c8.8 0 16 7.2 16 16v16c0 8.8-7.2 16-16 16H440c-8.8 0-16-7.2-16-16V168c0-8.8 7.2-16 16-16z"/>
        </svg>
    </a>
    
    <div class="version-control">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 122.88 112.99">
            <title>multiple-layers</title>
            <path d="M120.62,39.52,63.1,68.12a3.75,3.75,0,0,1-3.33,0L2.1,39.45a3.78,3.78,0,0,1-.18-6.67L59.59.48a3.78,3.78,0,0,1,3.73,0L121,32.78a3.77,3.77,0,0,1-.33,6.74Zm-9.77,40.93a3.76,3.76,0,0,1,3.6-6.61l6.41,3.38a3.77,3.77,0,0,1,1.58,5.09A3.82,3.82,0,0,1,120.7,84L63.1,112.6a3.75,3.75,0,0,1-3.33,0L2.1,83.93a3.77,3.77,0,0,1-1.71-5A3.69,3.69,0,0,1,2,77.22l6-3.14a3.76,3.76,0,0,1,4,6.35L61.44,105l49.41-24.57ZM111,57.69a3.76,3.76,0,0,1,4.36-6l5.49,2.89a3.76,3.76,0,0,1-.16,6.74L63.1,89.92a3.75,3.75,0,0,1-3.33,0L2.1,61.25a3.78,3.78,0,0,1-1.71-5A3.72,3.72,0,0,1,2,54.54L7.9,51.43A3.77,3.77,0,0,1,12,57.74l49.47,24.6L111,57.69ZM61.44,60.54,111,35.87,61.44,8.09,11.83,35.87,61.44,60.54Z"/>
        </svg>

        <span>
            <strong>
                {{ fleetcart_version() }}
            </strong>
        </span>
    </div>
</footer>
