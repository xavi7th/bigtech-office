<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import { afterUpdate, onMount } from "svelte";
  import { fly } from "svelte/transition";
  import route from "ziggy";
  import Sidebar from "@superadmin-shared/Partials/Sidebar";
  import Header from "@superadmin-shared/Partials/Header";
  import MobileHeader from "@superadmin-shared/Partials/MobileHeader";
  import PageTitle from "@superadmin-shared/Partials/PageTitle";
  import Footer from "@superadmin-shared/Partials/Footer";

  $: ({ app, routes } = $page);

  console.log($page);

  let isLoaded = false,
    isMounted = false;
  export let title;

  onMount(() => {
    isMounted = true;
  });

  afterUpdate(() => {
    // console.log(window.isLoaded);
    // setInterval(() => {
    //   console.log(window.isLoaded);
    // }, 1000);
    isLoaded = true;
  });
</script>

<style>
  .rui-page {
    position: relative;
  }
</style>

<Sidebar {routes} />
<Header />
<MobileHeader />

{#if isMounted}
  <div
    class="rui-page content-wrap"
    in:fly={{ x: -300, duration: 700, delay: 400 }}
    out:fly={{ y: 30, duration: 400, delay: 0 }}>
    <PageTitle {title} appName={app.name} />
    <div class="rui-page-content">
      <div class="container-fluid">
        <slot />
      </div>
    </div>
    <Footer />
  </div>
{/if}

{#if isLoaded}
  <script src="/js/user-dashboard-init.js">

  </script>
{/if}
