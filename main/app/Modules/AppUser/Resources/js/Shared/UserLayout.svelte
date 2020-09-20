<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import { afterUpdate } from "svelte";
  import route from "ziggy";
  import Sidebar from "@superadmin-shared/Partials/Sidebar.svelte";
  import Header from "@superadmin-shared/Partials/Header";
  import MobileHeader from "@superadmin-shared/Partials/MobileHeader";
  import PageTitle from "@superadmin-shared/Partials/PageTitle";
  import Footer from "@superadmin-shared/Partials/Footer";

  $: ({ app } = $page);

  console.log($page);

  export let isAuth = true,
    title = app.name;
  let isLoaded = false;

  afterUpdate(() => {
    isLoaded = true;
  });
</script>

<svelte:head>
  <title>{title}</title>
</svelte:head>

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
  <Sidebar />
  <Header />
  <MobileHeader />

  <div class="rui-page content-wrap">
    <PageTitle />
    <div class="rui-page-content">
      <div class="container-fluid" />
    </div>
    <Footer />
  </div>
{/if}

{#if isLoaded}
  <script src="/js/user-dashboard-init.js">

  </script>
{/if}
