import "../sass/media-picker.scss";

export default class {
    constructor(options) {
        this.options = _.merge(
            {
                type: null,
                multiple: false,
                route: "admin.file_manager.index",
                title: trans("media::media.file_manager.title"),
            },
            options
        );

        this.events = {};
        this.frame = this.getFrame();

        this.appendModalToBody();
        this.openFrame();
    }

    on(event, handler) {
        this.events[event] = handler;
    }

    getFrame() {
        let src = route(this.options.route, {
            type: this.options.type,
            multiple: this.options.multiple,
        });

        return $(
            `<iframe class="file-manager-iframe" frameborder="0" src="${src}"></iframe>`
        );
    }

    appendModalToBody() {
        if ($(".media-picker-modal").length === 1) {
            return;
        }

        $("body").append(this.getModal());

        this.closeModalOnClickDismiss();
        this.closeModalOnClickOutside();
    }

    openFrame() {
        this.showModal();

        this.frame.on("load", () => {
            this.selectMedia();
        });
    }

    showModal() {
        let modal = $(".media-picker-modal").modal("show");

        this.setFrameHeight();
        this.setFrameHeightOnWindowResize();
        this.setModalTitle(modal);
        this.setModalBody(modal);
        this.closeModalOnEsc(modal);
    }

    setFrameHeight() {
        this.frame.css("height", window.innerHeight * 0.8);
    }

    setFrameHeightOnWindowResize() {
        window.addEventListener("resize", () => {
            this.setFrameHeight();
        });
    }

    setModalTitle(modal) {
        modal.find(".modal-title").text(this.options.title);
    }

    setModalBody(modal) {
        modal.find(".modal-body").html(this.frame);
    }

    closeModalOnEsc(modal) {
        $(document).on("keydown", (e) => {
            if (e.key === "Escape") {
                modal.modal("hide");
            }
        });

        this.frame.on("load keydown", () => {
            this.frame.contents().on("keydown", (e) => {
                if (e.key === "Escape") {
                    modal.modal("hide");
                }
            });
        });
    }

    closeModalOnClickDismiss() {
        const modal = $(".media-picker-modal");

        modal.find('[data-dismiss="modal"]').on("click", () => {
            modal.modal("hide");
        });
    }

    closeModalOnClickOutside() {
        const modal = $(".media-picker-modal");

        modal.find(".modal-content").on("click", (e) => {
            e.stopPropagation();
        });

        modal.on("click", () => {
            modal.modal("hide");
        });
    }

    selectMedia() {
        this.frame
            .contents()
            .find(".table")
            .on("click", ".select-media", (e) => {
                e.preventDefault();

                this.events["select"](e.currentTarget.dataset);

                if (this.options.multiple) {
                    $(e.currentTarget)
                        .attr("disabled", true)
                        .html(`<i class="fa fa-check" aria-hidden="true"></i>`);
                } else {
                    $(".media-picker-modal").modal("hide");
                }
            });
    }

    getModal() {
        return `
            <div class="media-picker-modal modal fade" role="dialog">
                <div class="modal-dialog clearfix">
                    <div class="modal-content col-md-10 col-sm-11 clearfix">
                        <div class="row">
                            <div class="modal-header">
                                <a type="button" class="close" data-dismiss="modal">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M4.00073 11.9996L12 4.00037" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> 
                                        <path d="M12 11.9996L4.00073 4.00037" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </a>

                                <h5 class="modal-title"></h5>
                            </div>

                            <div class="modal-body"></div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
}
