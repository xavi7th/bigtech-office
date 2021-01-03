<script>
    import { page, InertiaLink } from "@inertiajs/inertia-svelte";
    import { Inertia } from "@inertiajs/inertia";
    import Layout from "@webadmin-shared/WebAdminLayout.svelte";
    // import FlashMessage from "@usershared/FlashMessage";
    let {default: FlashMessage} =  import('@usershared/FlashMessage');

    $: ({ flash } = $page);

</script>

<Layout title="Web Admin Dashboard">
    <div class="mt-20">UNDER CONSTRUCTION</div>
</Layout>
