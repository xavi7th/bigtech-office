<script>
  import { page, inertia } from "@inertiajs/inertia-svelte";
</script>

<style>
  .dashboard-logo{
    max-height: 70px;
  }
</style>

<nav class="rui-navbar rui-navbar-top rui-navbar-sticky">
  <div class="rui-navbar-brand">
    <a href="/" class="rui-navbar-logo">
      <img
        src="/img/logo.png"
        data-src-night="/img/logo-white.png"
        data-src-day="/img/logo.png"
        alt=""
        class="dashboard-logo"
        width="45" />
    </a>
    <button class="yay-toggle rui-yaybar-toggle" type="button">
      <span />
    </button>
  </div>
  <div class="container-fluid">
    <div class="rui-navbar-content">
      <ul class="nav" />
      <ul class="nav rui-navbar-right">
        <li
          class="dropdown dropdown-hover dropdown-triangle dropdown-keep-open">
          <span class="navbar-text mr-20">{$page.props.auth.user.full_name}</span>
          <a
            class="dropdown-item rui-navbar-avatar mnr-6"
            href
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false">
            <img src={$page.props.auth.user.avatar || '/img/avatar-1.png'} alt="" />
          </a>
          <ul class="nav dropdown-menu">
            <!-- <li>
              <a href="profile.html" class="nav-link">
                <span
                  data-feather="plus-circle"
                  class="rui-icon rui-icon-stroke-1_5" />
                <span>Create new Post</span>
                <span class="rui-nav-circle" />
              </a>
            </li>
            <li>
              <a href="profile.html" class="nav-link">
                <span
                  data-feather="users"
                  class="rui-icon rui-icon-stroke-1_5" />
                <span>Manage Users</span>
                <span class="rui-nav-circle" />
              </a>
            </li>
            <li>
              <a href="profile.html" class="nav-link">
                <span
                  data-feather="check-circle"
                  class="rui-icon rui-icon-stroke-1_5" />
                <span>Check Updates</span>
                <span class="rui-nav-circle" />
              </a>
            </li> -->
            <li>
              <button class="nav-link btn btn-link" use:inertia="{{ href: route('app.logout'), method: 'post' }}" type="button">
                <span
                  data-feather="log-out"
                  class="rui-icon rui-icon-stroke-1_5" />
                <span>Logout</span>
                <span class="rui-nav-circle" />
              </button>
            </li>
          </ul>
        </li>
        <li
          class="dropdown dropdown-hover dropdown-triangle dropdown-keep-open">
          <a
            class="dropdown-item mnr-5"
            href="#"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
            data-offset="0,12">
            <span class="btn btn-custom-round">
              <span
                data-feather="more-vertical"
                class="rui-icon rui-icon-stroke-1_5" />
            </span>
          </a>
          <ul class="nav dropdown-menu">
            <li>
              <div class="custom-control custom-switch dropdown-item-switch">
                <input
                  type="checkbox"
                  class="custom-control-input rui-nightmode-toggle"
                  id="toggleNightMode" />
                <label
                  class="dropdown-item custom-control-label"
                  for="toggleNightMode">
                  <span
                    data-feather="moon"
                    class="rui-icon rui-icon-stroke-1_5" />
                  <span>Night Mode</span>
                  <span class="rui-dropdown-circle" />
                </label>
              </div>
            </li>
            <li>
              <div class="custom-control custom-switch dropdown-item-switch">
                <input
                  type="checkbox"
                  class="custom-control-input rui-spotlightmode-toggle"
                  id="toggleSpotlightMode" />
                <label
                  class="dropdown-item custom-control-label"
                  for="toggleSpotlightMode">
                  <span
                    data-feather="square"
                    class="rui-icon rui-icon-stroke-1_5" />
                  <span>Spotlight Mode</span>
                  <span class="rui-dropdown-circle" />
                </label>
              </div>
            </li>
            <li>
              <div class="custom-control custom-switch dropdown-item-switch">
                <input
                  type="checkbox"
                  class="custom-control-input rui-sectionLines-toggle"
                  id="toggleSectionLines" />
                <label
                  class="dropdown-item custom-control-label"
                  for="toggleSectionLines">
                  <span
                    data-feather="layout"
                    class="rui-icon rui-icon-stroke-1_5" />
                  <span>Show section lines</span>
                  <span class="rui-dropdown-circle" />
                </label>
              </div>
            </li>
            <li class="dropdown-menu-label">Sidebar</li>
            <li>
              <div class="custom-control custom-switch dropdown-item-switch">
                <input
                  type="checkbox"
                  class="custom-control-input rui-darkSidebar-toggle"
                  id="toggleDarkSidebar" />
                <label
                  class="dropdown-item custom-control-label"
                  for="toggleDarkSidebar">
                  <span
                    data-feather="sidebar"
                    class="rui-icon rui-icon-stroke-1_5" />
                  <span>Dark</span>
                  <span class="rui-dropdown-circle" />
                </label>
              </div>
            </li>
            <li class="dropdown-menu-label">Navbar</li>
            <li>
              <div class="custom-control custom-switch dropdown-item-switch">
                <input
                  type="checkbox"
                  class="custom-control-input rui-darkNavbar-toggle"
                  id="toggleDarkNavbar" />
                <label
                  class="dropdown-item custom-control-label"
                  for="toggleDarkNavbar">
                  <span
                    data-feather="menu"
                    class="rui-icon rui-icon-stroke-1_5" />
                  <span>Dark</span>
                  <span class="rui-dropdown-circle" />
                </label>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
