import DataTable from "datatables.net-bs";

// Initialize state holders.
FleetCart.dataTable = { routes: {}, selected: {} };

let table = null;

export default class {
    constructor(selector, options, callback) {
        this.selector = selector;
        this.element = $(selector);

        if (FleetCart.dataTable.selected[selector] === undefined) {
            FleetCart.dataTable.selected[selector] = [];
        }

        this.initiateDataTable(options, callback);

        this.addErrorHandler();
        this.registerTableProcessingPlugin();
    }

    initiateDataTable(options, callback) {
        let sortColumn = this.element.find("th[data-sort]");

        table = new DataTable(
            this.element,
            _.merge(
                {
                    serverSide: true,
                    processing: true,
                    ajax: this.route("table", { table: true }),
                    stateSave: true,
                    sort: true,
                    info: true,
                    filter: true,
                    lengthChange: true,
                    paginate: true,
                    autoWidth: false,
                    pageLength: 20,
                    lengthMenu: [10, 20, 50, 100, 200],
                    order: [
                        sortColumn.index() !== -1 ? sortColumn.index() : 1,
                        sortColumn.data("sort") || "desc",
                    ],
                    layout: {
                        topEnd: {
                            search: {
                                placeholder: trans(
                                    "admin::admin.table.search_here"
                                ),
                            },
                        },
                    },
                    language: {
                        sInfo: trans("admin::admin.table.showing_start_end_total_entries"),
                        sInfoEmpty: trans("admin::admin.table.showing_empty_entries"),
                        sLengthMenu: trans("admin::admin.table.show_menu_entries"),
                        sInfoFiltered: trans("admin::admin.table.filtered_from_max_total_entries"),
                        sEmptyTable: trans("admin::admin.table.no_data_available_table"),
                        sLoadingRecords: trans("admin::admin.table.loading"),
                        sProcessing: trans("admin::admin.table.processing"),
                        sZeroRecords: trans("admin::admin.table.no_matching_records_found"),
                    },
                    initComplete: () => {
                        if (this.hasRoute("destroy")) {
                            let deleteButton = this.addTableActions();

                            deleteButton.on("click", () => this.deleteRows());

                            this.selectAllRowsEventListener();
                        }

                        if (this.hasRoute("show") || this.hasRoute("edit")) {
                            this.onRowClick(this.redirectToRowPage);
                        }

                        if (callback !== undefined) {
                            callback.call(this);
                        }
                    },
                    rowCallback: (row, data) => {
                        if (this.hasRoute("show") || this.hasRoute("edit")) {
                            this.makeRowClickable(row, data.id);
                        }
                    },
                    drawCallback: () => {
                        this.element.find(".select-all").prop("checked", false);

                        setTimeout(() => {
                            this.selectRowEventListener();
                            this.checkSelectedCheckboxes(
                                this.constructor.getSelectedIds(this.selector)
                            );
                        });
                    },
                    stateSaveParams(settings, data) {
                        delete data.search;
                    },
                },
                options
            )
        );
    }

    addTableActions() {
        let button = `
            <button type="button" class="btn btn-default btn-delete">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16" fill="none">
                    <path d="M12 3.6665L11.5868 10.3499C11.4813 12.0575 11.4285 12.9113 11.0005 13.5251C10.7889 13.8286 10.5164 14.0847 10.2005 14.2772C9.56141 14.6665 8.70599 14.6665 6.99516 14.6665C5.28208 14.6665 4.42554 14.6665 3.78604 14.2765C3.46987 14.0836 3.19733 13.827 2.98579 13.5231C2.55792 12.9082 2.5063 12.0532 2.40307 10.3433L2 3.6665" stroke="#141B34" stroke-width="1.5" stroke-linecap="round"/>
                    <path d="M5 7.82324H9" stroke="#141B34" stroke-width="1.5" stroke-linecap="round"/>
                    <path d="M6 10.436H8" stroke="#141B34" stroke-width="1.5" stroke-linecap="round"/>
                    <path d="M1 3.66659H13M9.70369 3.66659L9.24858 2.72774C8.94626 2.10409 8.7951 1.79227 8.53435 1.59779C8.47651 1.55465 8.41527 1.51628 8.35122 1.48305C8.06248 1.33325 7.71595 1.33325 7.02289 1.33325C6.31243 1.33325 5.95719 1.33325 5.66366 1.48933C5.59861 1.52392 5.53653 1.56385 5.47807 1.6087C5.2143 1.81105 5.06696 2.13429 4.77228 2.78076L4.36849 3.66659" stroke="#020010" stroke-width="1.5" stroke-linecap="round"/>
                </svg>

                <span>${trans("admin::admin.buttons.delete")}</span>
            </button>
        `;

        return $(button).appendTo(
            this.element.closest(".dt-container").find(".dt-length")
        );
    }

    deleteRows() {
        let checked = this.element.find(".select-row:checked");

        if (checked.length === 0) {
            return;
        }

        let confirmationModal = $("#confirmation-modal");
        let deleted = [];

        confirmationModal
            .modal("show")
            .find("form")
            .on("submit", (e) => {
                e.preventDefault();

                confirmationModal.modal("hide");

                let ids = this.constructor.getRowIds(checked);

                // Don't make ajax request if an id was previously deleted.
                if (
                    deleted.length !== 0 &&
                    _.difference(deleted, ids).length === 0
                ) {
                    return;
                }

                $.ajax({
                    type: "DELETE",
                    url: this.route("destroy", { ids: ids.join() }),
                    success: () => {
                        deleted = _.flatten(deleted.concat(ids));

                        this.constructor.setSelectedIds(this.selector, []);
                        this.constructor.reload(this.element);
                    },
                    error: (xhr) => {
                        error(xhr.responseJSON.message);

                        deleted = _.flatten(deleted.concat(ids));

                        this.constructor.setSelectedIds(this.selector, []);
                        this.constructor.reload(this.element);
                    },
                });
            });
    }

    makeRowClickable(row, id) {
        let key = this.hasRoute("show") ? "show" : "edit";
        let url = this.route(key, { id });

        $(row).addClass("clickable-row").data("href", url);
    }

    onRowClick(handler) {
        let row = "tbody tr.clickable-row td";

        if (this.element.find(".select-all").length !== 0) {
            row += ":not(:first-child)";
        }

        this.element.on("click", row, handler);
    }

    redirectToRowPage(e) {
        window.open(
            $(e.currentTarget).parent().data("href"),
            e.ctrlKey ? "_blank" : "_self"
        );
    }

    selectAllRowsEventListener() {
        this.element.find(".select-all").on("change", (e) => {
            this.element
                .find(".select-row")
                .prop("checked", e.currentTarget.checked);

            if (e.currentTarget.checked) {
                this.element.find(".clickable-row").addClass("active");
            } else {
                this.element.find(".clickable-row").removeClass("active");
            }
        });
    }

    selectRowEventListener() {
        this.element.find(".select-row").on("change", (e) => {
            if (e.currentTarget.checked) {
                this.appendToSelected(e.currentTarget.value);
                $(e.currentTarget).parents(".clickable-row").addClass("active");
            } else {
                this.removeFromSelected(e.currentTarget.value);
                $(e.currentTarget)
                    .parents(".clickable-row")
                    .removeClass("active");
            }
        });
    }

    appendToSelected(id) {
        id = parseInt(id);

        if (!FleetCart.dataTable.selected[this.selector].includes(id)) {
            FleetCart.dataTable.selected[this.selector].push(id);
        }
    }

    removeFromSelected(id) {
        id = parseInt(id);

        FleetCart.dataTable.selected[this.selector].remove(id);
    }

    checkSelectedCheckboxes(selectedIds) {
        let rows = this.element.find(".select-row");

        let checkableRows = rows.toArray().filter((row) => {
            return selectedIds.includes(parseInt(row.value));
        });

        $(checkableRows).prop("checked", true);
    }

    route(name, params) {
        let router = FleetCart.dataTable.routes[this.selector][name];

        if (typeof router === "string") {
            router = { name: router, params };
        }

        router.params = _.merge(params, router.params);

        return window.route(router.name, router.params);
    }

    hasRoute(name) {
        return FleetCart.dataTable.routes[this.selector][name] !== undefined;
    }

    static setRoutes(selector, routes) {
        FleetCart.dataTable.routes[selector] = routes;
    }

    static setSelectedIds(selector, selected) {
        FleetCart.dataTable.selected[selector] = selected;
    }

    static getSelectedIds(selector) {
        return FleetCart.dataTable.selected[selector];
    }

    static reload(selector, callback, resetPaging = false) {
        table.ajax.reload(callback, resetPaging);
    }

    static getRowIds(rows) {
        return rows.toArray().reduce((ids, row) => {
            return ids.concat(row.value);
        }, []);
    }

    static removeLengthFields() {
        $(".dt-length select").remove();
    }

    addErrorHandler() {
        DataTable.ext.errMode = (settings, helpPage, message) => {
            this.element.html(message);
        };
    }

    // https://datatables.net/plug-ins/api/processing()
    registerTableProcessingPlugin() {
        DataTable.Api.register("processing()", function (show) {
            return this.iterator("table", function (ctx) {
                ctx.oApi._fnProcessingDisplay(ctx, show);
            });
        });
    }
}
