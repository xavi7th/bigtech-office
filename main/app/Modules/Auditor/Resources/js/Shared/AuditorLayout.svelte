<script>
  import { onMount} from "svelte";
  import { page } from "@inertiajs/inertia-svelte";
  import { fly } from "svelte/transition";
  import Sidebar from "@superadmin-shared/Partials/Sidebar";
  import Header from "@superadmin-shared/Partials/Header";
  import MobileHeader from "@superadmin-shared/Partials/MobileHeader";
  import Footer from "@superadmin-shared/Partials/Footer";
  import PageTitle from "@superadmin-shared/Partials/PageTitle.svelte";

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

  <Header />
  <MobileHeader />
  <Sidebar {routes} />
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
  {/if}
</div>

{#if isMounted}
  <script src="/js/user-dashboard-init.js"></script>
{/if}
