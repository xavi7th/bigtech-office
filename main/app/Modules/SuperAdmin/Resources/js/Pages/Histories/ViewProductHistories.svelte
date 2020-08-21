<script>
  import Layout from "@superadmin-shared/SuperAdminLayout";

  export let productHistories = [];
</script>

<Layout title="Products Histories">
  <div class="row vertical-gap">

    <div class="col-lg-8 col-xl-8">

      <div class="list-group">
        {#each productHistories as history}
          <p
            href="#home"
            class="list-group-item list-group-item-action
            list-group-item-success">
            <b class="text-capitalize mr-15">{history.product}</b>
            {history.product_status}
          </p>
        {:else}
          <p
            href="#home"
            class="list-group-item list-group-item-action list-group-item-danger">
            <b class="text-capitalize mr-15">NO RECORDED HISTORIES</b>
          </p>
        {/each}

        <div class="rui-gap-3 d-none d-lg-block" />
      </div>
    </div>

  </div>
</Layout>
