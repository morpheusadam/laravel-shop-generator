<div class="complete d-flex flex-column justify-content-center align-items-center" v-if="appInstalled" v-cloak>
    <div class="check-icon">
        <span class="icon-line line-tip"></span>
        <span class="icon-line line-long"></span>

        <div class="icon-circle"></div>
        <div class="icon-fix"></div>
    </div>

    <h3 class="title text-center animate__animated animate__fadeInUp">Installed Successfully!</h3>

    <ul class="links list-inline d-flex animate__animated animate__fadeInUp">
        <li>
            <a href="{{ url('admin') }}" target="_blank" class="link d-block text-center">
                <span class="mdi mdi-account-cog d-inline-block"></span>
                <span class="d-block">
                    <b>Admin Panel</b>
                </span>
            </a>
        </li>
        <li>
            <a href="{{ url('/') }}" target="_blank" class="link d-block text-center">
                <span class="mdi mdi-storefront-outline d-inline-block"></span>
                <span class="d-block">
                    <b>Store</b>
                </span>
            </a>
        </li>
    </ul>
</div>