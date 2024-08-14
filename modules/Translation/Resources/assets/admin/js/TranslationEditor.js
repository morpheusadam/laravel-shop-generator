import "x-editable/dist/bootstrap3-editable/js/bootstrap-editable";

export default class {
    constructor() {
        $(".translation")
            .editable({
                url: this.update,
                type: "text",
                mode: "inline",
                send: "always",
            })
            .on("shown", (_, editable) => {
                editable.input.postrender = () => {
                    editable.input.$input.select();
                };
            });
    }

    update(data) {
        $.ajax({
            url: route("admin.translations.update", this.dataset.key),
            type: "PUT",
            data: {
                locale: this.dataset.locale,
                value: data.value,
            },
            success(message) {
                success(message);
            },
            error(xhr) {
                error(xhr.responseJSON.message);
            },
        });
    }
}
