<script>
  import { InertiaLink } from "@inertiajs/inertia-svelte";
  export let routes;
</script>

<div class="yaybar yay-hide-to-small yay-shrink yay-gestures rui-yaybar">
  <div class="yay-wrap-menu">
    <div class="yaybar-wrap">
      <ul>
        <li class="yay-label">Menu Items</li>
        {#each Object.entries(routes) as [route_name, route_cont]}
          {#if route_cont.length == 1}
            <li class:yay-item-active={route().current(route_cont[0].name)}>
              <InertiaLink
                href={route(route_cont[0].name)}
                class="yay-sub-toggle">
                <span class="yay-icon">
                  <span stroke-width="1.5" data-feather={route_cont[0].icon} />
                </span>
                <span>{route_cont[0].menu_name}</span>
                <span class="rui-yaybar-circle" />
              </InertiaLink>
            </li>
          {:else if route_cont.length > 1}
            <li>
              <a href class="yay-sub-toggle">
                <span class="yay-icon">
                  <span stroke-width="1.5" data-feather={route_cont[0].icon} />
                </span>
                <span>{route_name}</span>
                <span class="rui-yaybar-circle" />
                <span class="yay-icon-collapse">
                  <span
                    data-feather="chevron-right"
                    class="rui-icon rui-icon-collapse rui-icon-stroke-1_5" />
                </span>
              </a>
              <ul class="yay-submenu dropdown-triangle">
                {#each route_cont as elem}
                  <li class:yay-item-active={route().current(elem.name)}>
                    <InertiaLink href={route(elem.name)}>
                      {elem.menu_name}
                    </InertiaLink>
                  </li>
                {/each}
              </ul>
            </li>
          {/if}
        {/each}

      </ul>
    </div>
  </div>
  <div class="rui-yaybar-icons">
      <div class="row no-gutters justify-content-around">
        <div class="col-auto">
          <a class="btn btn-custom-round" href="#">
            <span data-feather="settings" class="rui-icon"></span>
          </a>
        </div>
        <div class="col-auto">
          <a class="btn btn-custom-round" href="#">
            <span data-feather="bell" class="rui-icon"></span>
          </a>
        </div>
        <div class="col-auto d-flex">
          <div class="dropdown dropdown-hover dropdown-triangle dropdown-keep-open dropup">
            <a
              class="btn btn-custom-round dropdown-item"
              href="#"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
              data-offset="-30"
            >
              <span data-feather="plus-circle" class="rui-icon rui-icon-stroke-1_5"></span>
            </a>
            <ul class="dropdown-menu nav">
              <li>
                <a href="#" class="nav-link">
                  <span data-feather="plus-circle" class="rui-icon rui-icon-stroke-1_5"></span>
                  <span>Create new Post</span>
                  <span class="rui-nav-circle"></span>
                </a>
              </li>
              <li>
                <a href="#" class="nav-link">
                  <span data-feather="book" class="rui-icon rui-icon-stroke-1_5"></span>
                  <span>Project</span>
                  <span class="rui-nav-circle"></span>
                </a>
              </li>
              <li>
                <a href="#" class="nav-link">
                  <span data-feather="message-circle" class="rui-icon rui-icon-stroke-1_5"></span>
                  <span>Message</span>
                  <span class="rui-nav-circle"></span>
                </a>
              </li>
              <li>
                <a href="#" class="nav-link">
                  <span data-feather="mail" class="rui-icon rui-icon-stroke-1_5"></span>
                  <span>Mail</span>
                  <span class="rui-nav-circle"></span>
                </a>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-auto">
          <a class="btn btn-custom-round" href="#">
            <span data-feather="clock" class="rui-icon rui-icon-stroke-1_5"></span>
          </a>
        </div>
        <div class="col-auto">
          <a class="btn btn-custom-round" href="#">
            <span data-feather="heart" class="rui-icon rui-icon-stroke-1_5"></span>
          </a>
        </div>
      </div>
    </div>
</div>
<div class="rui-yaybar-bg" />
