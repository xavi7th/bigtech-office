<script>
  import { onMount } from "svelte";
  import { page } from "@inertiajs/inertia-svelte";
  import { fly } from "svelte/transition";
  import Sidebar from "@superadmin-shared/Partials/Sidebar";
  import Search from "@superadmin-shared/Partials/Search";
  import Header from "@superadmin-shared/Partials/Header";
  import MobileHeader from "@superadmin-shared/Partials/MobileHeader";
  import PageTitle from "@superadmin-shared/Partials/PageTitle";
  import Footer from "@superadmin-shared/Partials/Footer";

  $: ({ app, routes, auth } = $page.props);

  let isMounted = false;
  export let title;

  onMount(() => {
    setTimeout(() => {
      jQuery('#page-loader').fadeOut()
    }, 1000);
    isMounted = true;
  });

</script>

<div
  data-spy="scroll"
  data-target=".rui-page-sidebar"
  data-offset="140"
  class="rui-no-transition rui-navbar-autohide rui-section-lines main-page-wrap"
  >

  <Sidebar {routes} />
  <Header />
  <MobileHeader />
  {#if isMounted}
    <div
      class="rui-page content-wrap"
      in:fly={{ x: -300, duration: 700, delay: 400 }}
      out:fly={{ y: 30, duration: 400, delay: 0 }}>
      <PageTitle {title} appName={app.name} staffLocation={auth.user.office_branch}  />
      <div class="rui-page-content">
        <div class="container-fluid">
          <slot />
        </div>
      </div>
      <Footer />
    </div>

    <slot name="modals" />
    {#if auth.user.isSuperAdmin || auth.user.isAccountant}
      <Search />
    {/if}
  {/if}
</div>


{#if isMounted}
  <script src="/js/user-dashboard-init.js"></script>
{/if}
