<script>
    import { page, InertiaLink } from "@inertiajs/inertia-svelte";
    import { Inertia } from "@inertiajs/inertia";
    import Layout from "@superadmin-shared/SuperAdminLayout";
    import FlashMessage from "@usershared/FlashMessage";
    import route from "ziggy";

    $: ({ app } = $page);
</script>

<Layout title="Super Admin Dashboard">
    <div class="mt-20">Don't you have an account?</div>
</Layout>
