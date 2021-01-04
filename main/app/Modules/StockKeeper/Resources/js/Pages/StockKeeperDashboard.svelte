<script>
    import { page, InertiaLink } from "@inertiajs/inertia-svelte";
    import { Inertia } from "@inertiajs/inertia";
    import Layout from "@stockkeeper-shared/StockKeeperLayout.svelte";
    import FlashMessage from "@usershared/FlashMessage";

import { onMount } from "svelte";

    $: ({ flash } = $page.props);

</script>

<Layout title="StockKeeper Dashboard">
    <div class="mt-20">UNDER CONSTRUCTION</div>
</Layout>
