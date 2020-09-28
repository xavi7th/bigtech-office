<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import { afterUpdate, onMount, tick } from "svelte";
  import { fly } from "svelte/transition";
  import route from "ziggy";
  import Sidebar from "@superadmin-shared/Partials/Sidebar";
  import Header from "@superadmin-shared/Partials/Header";
  import MobileHeader from "@superadmin-shared/Partials/MobileHeader";
  import PageTitle from "@superadmin-shared/Partials/PageTitle";
  import Footer from "@superadmin-shared/Partials/Footer";
  import { lang } from "moment";

  $: ({ app, routes } = $page);

  console.log($page);

  let isLoaded = false,
    isMounted = false;
  export let title;

  onMount(async () => {
    isMounted = true;

    await tick();
    jQuery(".rui-datatable").DataTable({
       destroy: true,
      order: [[2, "desc"]],
      dom: "<lfB<t><ip>>",
      buttons: ["excel", "pdf"]
      // responsive: true
    });
    objectFitImages();
  });

  afterUpdate(() => {
    document.querySelector("#app").removeAttribute("data-page");
    isLoaded = true;
  });
</script>

<style lang="scss">
  .rui-page {
    position: relative;
  }

  :global(.dataTables_paginate) {
    @media (max-width: 767px) {
      margin-top: 20px;
      position: relative;
    }
      :global(.paginate_button) {
        margin: 5px;
        padding: 0;
      }
  }
</style>

<div
  data-spy="scroll"
  data-target=".rui-page-sidebar"
  data-offset="140"
  class="rui-no-transition rui-navbar-autohide rui-section-lines main-page-wrap"
  class:yay-hide={$page.isMobile}
  >

  <Header />
  <MobileHeader />
  <Sidebar {routes} />
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

    <slot name="modals" />
  {/if}
</div>

{#if isMounted}
  <script src="/js/user-dashboard-init.js">

  </script>
{/if}
