<template v-else-if="section === 'downloads'">
    <div class="box-header">
        <h5>{{ trans('product::products.group.downloads') }}</h5>

        <div class="drag-handle">
            <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
            <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
        </div>
    </div>

    <div class="box-body">
        <div class="product-downloads-wrapper clearfix">
            <div class="table-responsive">
                <table class="options table table-bordered">
                    <thead>
                        <tr>
                            <th></th>
                            <th>{{ trans('product::products.downloads.file') }}</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody
                        animation="150"
                        handle=".drag-handle"
                        is="draggable"
                        tag="tbody"
                        :list="form.downloads"
                    >
                        <tr v-for="(download, index) in form.downloads" :key="index">
                            <td class="text-center">
                                <span class="drag-handle">
                                    <i class="fa">&#xf142;</i>
                                    <i class="fa">&#xf142;</i>
                                </span>
                            </td>

                            <td>
                                <div class="choose-file-group">
                                    <input
                                        type="text"
                                        :value="download.filename"
                                        class="form-control downloadable-file-name"
                                        readonly
                                    >

                                    <button
                                        type="button"
                                        class="btn btn-default btn-choose-file"
                                        @click="chooseDownloadableFile(index)"
                                    >
                                        {{ trans('product::products.downloads.choose') }}
                                    </button>
                                </div>
                            </td>

                            <td class="text-center">
                                <button
                                    type="button"
                                    class="btn btn-default delete-row"
                                    @click="deleteDownload(index)"
                                >
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <button type="button" class="btn btn-default" @click="addDownload">
                {{ trans('product::products.downloads.add_file') }}
            </button>
        </div>
    </div>
</template>
