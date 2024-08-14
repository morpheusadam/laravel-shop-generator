$("#refresh-rates").on("click", (e) => {
    $.ajax({
        type: "GET",
        url: route("admin.currency_rates.refresh"),
        success() {
            DataTable.reload();

            window.admin.stopButtonLoading($(e.currentTarget));
        },
        error(xhr) {
            error(xhr.responseJSON.message);

            window.admin.stopButtonLoading($(e.currentTarget));
        },
    });
});
