<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import { afterUpdate } from "svelte";
  import route from "ziggy";

  // import Layout from '@user-shared-components/Layout.svelte';

  $: ({ app } = $page);

  console.log($page);

  let isLoaded = false,
    isAuth = true;

  afterUpdate(() => {
    console.log("the component has mounted");
    isLoaded = true;
  });
</script>

{#if isAuth}
  <div class="rui-main">
    <div class="rui-sign align-items-center justify-content-center">
      <div class="bg-image">
        <div class="bg-grey-2" />
      </div>
      <div class="logo d-flex justify-content-center mb-30">
        <InertiaLink href={route('app.home')}>
          <img
            src="/img/the-elects-logo.png"
            alt={$page.app.name}
            class="logo-img"
            width="200" />
        </InertiaLink>
      </div>
      <slot />
    </div>
  </div>
{:else}
  <div />
{/if}

{#if isLoaded}
  <script src="/js/user-dashboard-init.js">

  </script>
{/if}
