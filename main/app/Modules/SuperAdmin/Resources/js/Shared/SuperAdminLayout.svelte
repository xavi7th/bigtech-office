<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import { afterUpdate } from "svelte";
  import route from "ziggy";
  import Sidebar from "@superadmin-shared/Partials/Sidebar";
  import Header from "@superadmin-shared/Partials/Header";
  import MobileHeader from "@superadmin-shared/Partials/MobileHeader";
  import PageTitle from "@superadmin-shared/Partials/PageTitle";
  import Footer from "@superadmin-shared/Partials/Footer";

  $: ({ app, routes } = $page);

  console.log($page);

  let isLoaded = false;

  afterUpdate(() => {
    isLoaded = true;
  });
</script>

<Sidebar {routes} />
<Header />
<MobileHeader />

<div class="rui-page content-wrap">
  <PageTitle />
  <div class="rui-page-content">
    <div class="container-fluid">
      <slot />
    </div>
  </div>
  <Footer />
</div>

{#if isLoaded}
  <script src="/js/user-dashboard-init.js">

  </script>
{/if}
