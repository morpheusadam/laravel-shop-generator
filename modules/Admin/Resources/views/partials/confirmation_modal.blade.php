<div class="modal fade" id="confirmation-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M4.00073 11.9996L12 4.00037" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> 
                        <path d="M12 11.9996L4.00073 4.00037" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </button>

                <h4 class="modal-title">{{ trans('admin::admin.delete.confirmation') }}</h4>
            </div>

            <div class="modal-body">
                <div class="default-message">
                    {{ $message ?? trans('admin::admin.delete.confirmation_message') }}
                </div>
            </div>

            <div class="modal-footer">
                <form method="POST" id="confirmation-form">
                    {{ csrf_field() }}
                    {{ method_field('delete') }}

                    <button type="button" class="btn btn-default cancel" data-dismiss="modal">
                        {{ trans('admin::admin.buttons.cancel') }}
                    </button>

                    <button type="submit" class="btn btn-danger delete">
                        {{ trans('admin::admin.buttons.delete') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
