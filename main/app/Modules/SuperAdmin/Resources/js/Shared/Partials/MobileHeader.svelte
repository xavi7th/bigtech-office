<script>
import { Inertia } from "@inertiajs/inertia";


  let logoutUser = () => {
    BlockToast.fire("Securing your dashboard ...");

    Inertia.post(route("app.logout")).then(() => {
      location.reload();
    });
  };
</script>

<style>
  .dashboard-logo{
    max-height: 50px;
  }
</style>

<div class="rui-navbar rui-navbar-mobile">
  <div class="rui-navbar-head">
    <button
      class="rui-yaybar-toggle rui-yaybar-toggle-inverse yay-toggle"
      type="button"
      aria-label="Toggle side navigation">
      <span />
    </button>
    <a class="rui-navbar-logo mr-auto" href="/">
      <img
        src="/img/logo.png"
        data-src-night="/img/logo-white.png"
        data-src-day="/img/logo.png"
        class="dashboard-logo"
        alt=""
        width="45" />
    </a>
    <div class="dropdown dropdown-triangle">
      <a
        class="dropdown-item rui-navbar-avatar"
        href
        data-toggle="dropdown"
        aria-haspopup="true"
        aria-expanded="false">
        <img src="/img/avatar-1.png" alt="" />
      </a>
      <ul class="dropdown-menu nav">
        <li>
          <button class="nav-link btn btn-link" on:click={logoutUser}>
            <span data-feather="log-out" class="rui-icon rui-icon-stroke-1_5" />
            <span>Logout</span>
            <span class="rui-nav-circle" />
          </button>
        </li>
      </ul>
    </div>
  </div>
</div>
<div class="rui-navbar-bg" />
