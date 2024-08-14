import NProgress from "nprogress";

export const nprogress = () => {
    NProgress.configure({ showSpinner: false });

    $(document).ajaxStart(() => NProgress.start());
    $(document).ajaxComplete(() => NProgress.done());
};
