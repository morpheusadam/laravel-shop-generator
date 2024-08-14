<div class="has-scrollable-content requirements d-flex flex-column" v-if="step === 1" v-cloak>
    <div class="header overflow-hidden">
        <h3>Requirements</h3>
        <p class="excerpt">Make sure the appropriate PHP version is installed and required PHP extensions are both installed and enabled.</p>
    </div>

    <div class="content position-relative flex-grow-1 overflow-hidden">
        <simplebar class="scrollable-content position-absolute" data-simplebar-auto-hide="false">
            <div class="box" v-cloak>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>PHP</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($requirement->php() as $label => $satisfied)
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

            <div class="box" v-cloak>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Extensions</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($requirement->extensions() as $label => $satisfied)
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