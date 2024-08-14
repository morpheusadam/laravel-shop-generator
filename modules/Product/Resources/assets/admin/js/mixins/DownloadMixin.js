export default {
    watch: {
        "form.downloads": {
            immediate: true,
            handler(newValue) {
                if (newValue.length === 0) {
                    this.addDownload({ preventMediaPicker: true });
                }
            },
        },
    },

    methods: {
        addDownload({ preventMediaPicker }) {
            const downloads = this.form.downloads;

            downloads.push({
                id: null,
                filename: null,
            });

            if (!preventMediaPicker) {
                this.chooseDownloadableFile(downloads.length - 1);
            }
        },

        deleteDownload(index) {
            this.form.downloads.splice(index, 1);
        },

        chooseDownloadableFile(index) {
            let picker = new MediaPicker();

            picker.on("select", ({ id, filename }) => {
                this.form.downloads.splice(index, 1, {
                    id,
                    filename,
                });
            });
        },
    },
};
