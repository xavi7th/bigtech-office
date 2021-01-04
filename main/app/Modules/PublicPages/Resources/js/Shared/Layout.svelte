<script>
  import Header from "@public-shared/Partials/Header";
  import Footer from "@public-shared/Partials/Footer";
  import PageLoader from "@public-shared/PageLoader";
  import QuickView from "@public-shared/Partials/QuickView";
  import MobileNav from "@public-shared/Partials/MobileNav";
  import MobileHeader from "@public-shared/Partials/MobileHeader";
  import SectionLoader from "@public-shared/PageLoader";
  import { fade } from "svelte/transition";
  import { onMount } from "svelte";
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";

  $: ({ errors, auth, isInertiaRequest, isMobile, isDesktop } = $page.props);
  let isLoaded = false,
    pageLoaded = false;

  onMount(() => {
    isLoaded = true;
  });


</script>

<svelte:window
  on:load={() => {
    pageLoaded = true;
  }} />

{#if !pageLoaded && !isInertiaRequest}
  <PageLoader />
{:else if !pageLoaded && isInertiaRequest}
  <SectionLoader transparent={true} />
{/if}

<div class="site" transition:fade>
  {#if isMobile}
    <MobileHeader />
  {:else if isDesktop}
    <Header />
  {/if}

  <div class="site__body" transition:fade>
    <slot />
  </div>

  <Footer />
</div>

{#if isMobile}
  <MobileNav />
{/if}
<QuickView />

{#if isLoaded}
  <script src="/js/public-init.js">

  </script>
  <script>
    // $("#loader").fadeOut(500, () =>{
    //   $('body').addClass('loaded');
    //   $('#preloader').delay(300).fadeOut(400);
    // });
  </script>
{/if}
