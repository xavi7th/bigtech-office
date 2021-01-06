<script>
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";

  $: ({ auth } = $page.props);

  export let resellersWithProducts = [];
</script>

<Layout title="View Resellers With Products">

  <div class="container-fluid">
    <div class="row vertical-gap">
      <div class="col-12 ">
        <div class="table-responsive">
          <table class="table table-bordered rui-datatable" data-order="[]">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Records</th>
              </tr>
            </thead>
            <tbody
              class="list-group list-group-flush rui-project-releases-list m-0">
              {#each resellersWithProducts as resellersWithProduct}
                <tr class="list-group-item p-0">
                  <td class="rui-changelog d-block">
                    <h3 class="rui-changelog-title">
                      {resellersWithProduct.business_name}
                    </h3>
                    <div class="rui-changelog-subtitle">
                      <a href="#home">Contact Number:</a>
                      {resellersWithProduct.phone}
                    </div>
                    <ul class="list-unstyled">
                      {#each resellersWithProduct.products_in_possession as product}
                        <li>
                          <div class="rui-changelog-item rui-changelog-success">
                            <span
                              class="rui-changelog-item-type text-capitalize">
                              {product.color || ''} {product.model} ({product.identifier})
                              collected on {product.collection_date}
                            </span>
                          </div>
                        </li>
                      {/each}
                    </ul>
                    <ul class="list-unstyled">
                      <li>
                      {#if auth.user.isStockKeeper || auth.user.isSuperAdmin || auth.user.isAccountant}
                        <InertiaLink
                          href={route(auth.user.user_type + '.multiaccess.resellers.products', resellersWithProduct.id)}
                          class="btn btn-brand btn-sm">
                          Details
                        </InertiaLink>
                      {/if}
                      </li>
                    </ul>
                  </td>
                </tr>
              {/each}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</Layout>
