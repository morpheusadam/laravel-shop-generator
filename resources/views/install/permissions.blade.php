<div class="has-scrollable-content permissions d-flex flex-column" v-else-if="step === 2" v-cloak>
    <div class="header overflow-hidden">
        <h3>Permissions</h3>
        <p class="excerpt">Please make sure that the PHP has proper access to the following files and directories.</p>
    </div>

    <div class="content position-relative flex-grow-1 overflow-hidden">
        <simplebar class="scrollable-content position-absolute" data-simplebar-auto-hide="false">
            <div class="box">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Files</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($permission->files() as $label => $satisfied)
                                <tr>
                                    <td>{{ $label }}</td>

                                    <td>
                                        <span class="mdi mdi-{{ $satisfied ? 'checkbox-marked-circle' : 'close-circle' }}"></span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="box">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Directories</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($permission->directories() as $label => $satisfied)
                                <tr>
                                    <td>{{ $label }}</td>

                                    <td>
                                        <span class="mdi mdi-{{ $satisfied ? 'checkbox-marked-circle' : 'close-circle' }}"></span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </simplebar>
    </div>
</div>