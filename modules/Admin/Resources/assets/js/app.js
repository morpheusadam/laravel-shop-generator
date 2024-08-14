import "bootstrap";
import "flatpickr";
import "mousetrap";
import "./FleetCart";
import "./jquery.keypressAction";

import Admin from "./Admin";
import Form from "./Form";
import DataTable from "./DataTable";
import {
    trans,
    keypressAction,
    notify,
    info,
    success,
    warning,
    error,
} from "./functions";

if (
    !route().current("admin.products.create") &&
    !route().current("admin.products.edit") &&
    !route().current("admin.blog_posts.create") &&
    !route().current("admin.blog_posts.edit")
) {
    window.admin = new Admin();
}

window.form = new Form();
window.DataTable = DataTable;

window.trans = trans;
window.keypressAction = keypressAction;
window.notify = notify;
window.info = info;
window.success = success;
window.warning = warning;
window.error = error;

$.ajaxSetup({
    headers: {
        Authorization: FleetCart.apiToken,
        "X-CSRF-TOKEN": FleetCart.csrfToken,
    },
});
