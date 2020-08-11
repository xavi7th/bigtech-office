<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import FlashMessage from "@usershared/FlashMessage";
  import route from "ziggy";

  $: ({ app } = $page);

  export let productModels = [];
</script>

<Layout title="Product Models">
  <div class="row vertical-gap">
    <div class="col-12">

      <div class="table-responsive-md">
        <table
          class="rui-datatable table table-striped table-bordered table-sm">
          <thead>
            <tr>
              <th class="p-0">
                <InertiaLink
                  href={route('superadmin.product_models.create_product_model')}
                  class="btn btn-brand m-10">
                  <span>Create Product Model</span>
                </InertiaLink>
              </th>
            </tr>
          </thead>
          <tbody class="list-group list-group-flush">
            {#each productModels as model (model.id)}
              <tr class="list-group-item p-0">
                <td class="media media-success media-filled p-0">
                  <div class="media-link">
                    <img
                      src={model.img_url}
                      alt="{model.name} poster"
                      class="media-img" />
                    <span class="media-body">
                      <span class="media-title">{model.name}</span>
                      <small class="media-subtitle">
                        {model.product_category}, {model.product_brand}
                      </small>
                    </span>
                    <InertiaLink
                      href={route('superadmin.product_models.details', model.id)}
                      class="btn btn-brand">
                      <span>Details</span>
                      <span class="badge badge-light">
                        {model.product_count}
                      </span>
                    </InertiaLink>
                  </div>
                </td>
              </tr>
            {:else}
              <tr class="list-group-item p-0">
                <td class="media media-warning media-filled p-0">
                  <a href="#home" class="media-link">
                    <span class="media-img">S</span>
                    <span class="media-body">
                      <span class="media-title">No Product Models</span>
                      <small class="media-subtitle">N/A</small>
                    </span>
                  </a>
                </td>
              </tr>
            {/each}
          </tbody>
        </table>

      </div>
    </div>
  </div>
</Layout>
