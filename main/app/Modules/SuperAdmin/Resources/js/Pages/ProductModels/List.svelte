<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import FlashMessage from "@user-shared/FlashMessage";
  import route from "ziggy";

  $: ({ app } = $page);
</script>

<Layout title="Product Models">
  <div class="row vertical-gap">
    <div class="col-12">
      <div class="card">
        <ul class="list-group list-group-flush rui-snippet-preview demo">
          <li class="list-group-item p-0">
            <div class="media media-success media-filled">
              <a href="#home" class="media-link">
                <span class="media-img">A</span>
                <span class="media-body">
                  <span class="media-title">Galaxy Note 10</span>
                  <small class="media-subtitle">Phones, Apple</small>
                </span>
                <InertiaLink
                  href={route('superadmin.product_models.details', 1)}
                  class="btn btn-brand">
                  <span>Details</span>
                  <span class="badge badge-light">4</span>
                </InertiaLink>
              </a>
            </div>
          </li>
          <li class="list-group-item p-0">
            <div class="media media-warning media-filled">
              <a href="#home" class="media-link">
                <span class="media-img">S</span>
                <span class="media-body">
                  <span class="media-title">iPhone XsMax</span>
                  <small class="media-subtitle">Laptops, Lenovo</small>
                </span>
                <InertiaLink
                  href={route('superadmin.product_models.details', 2)}
                  class="btn btn-brand">
                  <span>Details</span>
                  <span class="badge badge-light">4</span>
                </InertiaLink>
              </a>
            </div>
          </li>
        </ul>
      </div>

    </div>
  </div>
</Layout>
