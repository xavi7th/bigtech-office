<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import route from "ziggy";

  export let routes;
  console.log(routes);
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
</div>
<div class="rui-yaybar-bg" />
