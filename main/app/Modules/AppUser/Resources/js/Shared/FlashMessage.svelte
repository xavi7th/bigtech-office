<script>
  import { page } from "@inertiajs/inertia-svelte";
  $: ({ flash } = $page);

  export let formError;
</script>

<style>
  .alert-danger {
    color: #7c2a34;
    background-color: #fcdce0;
    padding: 0.75rem 1.25rem;
  }
</style>

{#if formError}
  <div class="invalid-feedback d-block">{formError}</div>
{:else if flash.error}
  <div class="alert alert-danger">{flash.error}</div>
{:else if flash.success}
  <div class="alert alert-success">{flash.success}</div>
{/if}
