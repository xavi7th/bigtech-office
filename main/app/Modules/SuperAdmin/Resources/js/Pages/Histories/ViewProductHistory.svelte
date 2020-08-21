<script>
  import Layout from "@superadmin-shared/SuperAdminLayout";

  export let productWithHistory = [];
</script>

<Layout title="{productWithHistory.model} History">
  <div class="row vertical-gap">

    <div class="col-lg-8 col-xl-8">
      <div class="d-flex align-items-center justify-content-between mb-25">
        <h2 class="mnb-2 text-upprecase" id="formBase">
          {productWithHistory.identifier}
        </h2>
      </div>
      <div class="list-group">
        {#each productWithHistory.product_histories as history}
          <p
            class="list-group-item list-group-item-action text-capitalize
            list-group-item-success">
            {history.product_status}
          </p>
        {:else}
          <p
            class="list-group-item list-group-item-action list-group-item-danger">
            NO RECORDED HISTORY
          </p>
        {/each}
        <div class="rui-gap-3 d-none d-lg-block" />
      </div>
    </div>

  </div>
</Layout>
