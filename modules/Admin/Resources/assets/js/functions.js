import { ohSnap } from "./ohsnap";

export function trans(langKey, replace = {}) {
    let line = window.FleetCart.langs[langKey];

    for (let key in replace) {
        line = line.replace(`:${key}`, replace[key]);
    }

    return line;
}

export function keypressAction(actions) {
    $(document).keypressAction({ actions });
}

export function notify(type, message, { duration = 5000, context = document }) {
    let types = {
        info: "blue",
        success: "green",
        warning: "yellow",
        error: "red",
    };

    ohSnap(message, {
        "container-id": "notification-toast",
        context,
        color: types[type],
        duration,
    });
}

export function info(message, duration) {
    notify("info", message, { duration });
}

export function success(message, duration) {
    notify("success", message, { duration });
}

export function warning(message, duration) {
    notify("warning", message, { duration });
}

export function error(message, duration) {
    notify("error", message, { duration });
}

export function generateSlug(name) {
    let slug = "";

    // Change to lower case
    const nameLower = name.toLowerCase();

    // Letter "e"
    slug = nameLower.replace(/e|é|è|ẽ|ẻ|ẹ|ê|ế|ề|ễ|ể|ệ/gi, "e");
    // Letter "a"
    slug = slug.replace(/a|á|à|ã|ả|ạ|ă|ắ|ằ|ẵ|ẳ|ặ|â|ấ|ầ|ẫ|ẩ|ậ/gi, "a");
    // Letter "o"
    slug = slug.replace(/o|ó|ò|õ|ỏ|ọ|ô|ố|ồ|ỗ|ổ|ộ|ơ|ớ|ờ|ỡ|ở|ợ/gi, "o");
    // Letter "u"
    slug = slug.replace(/u|ú|ù|ũ|ủ|ụ|ư|ứ|ừ|ữ|ử|ự/gi, "u");
    // Letter "c"
    slug = slug.replace(/ć|ĉ|č|ċ|ç/gi, "c");
    // Letter "i"
    slug = slug.replace(/î|ï|í|ī|į|ì/gi, "i");
    // Letter (/, ', ")
    slug = slug.replace(/\/|'|"|′|’|,|\?|\.|;|]|\[|\+|=|\$|%|&|<|>|:/g, " ");
    // Letter "d"
    slug = slug.replace(/đ/gi, "d");
    // Trim the last whitespace
    slug = slug.replace(/\s*$/g, "");
    // Change whitespace to "-"
    slug = slug.replace(/\s+/g, "-");

    return slug;
}

/**
 * @see https://stackoverflow.com/a/3955096
 */
if (!Array.prototype.remove) {
    Array.prototype.remove = function () {
        let what,
            a = arguments,
            L = a.length,
            ax;

        while (L && this.length) {
            what = a[--L];

            while ((ax = this.indexOf(what)) !== -1) {
                this.splice(ax, 1);
            }
        }

        return this;
    };
}

/**
 * @see https://stackoverflow.com/a/4673436
 */
if (!String.prototype.format) {
    String.prototype.format = function () {
        return this.replace(/%(\d+)%/g, (match, number) => {
            return typeof arguments[number] !== "undefined"
                ? arguments[number]
                : match;
        });
    };
}
