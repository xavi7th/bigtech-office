<script>
  import { page } from "@inertiajs/inertia-svelte";
  $: ({ flash } = $page);

  export let msg,
    isFormError = false;
</script>

{#if isFormError}
  {#if msg}
    <div class="invalid-feedback">{msg}</div>
  {/if}
{:else}
  {#if flash.error}
    <div class="alert alert-danger">{flash.error}</div>
  {:else if flash.success}
    <div class="alert alert-success">{flash.success}</div>
  {/if}
{/if}
