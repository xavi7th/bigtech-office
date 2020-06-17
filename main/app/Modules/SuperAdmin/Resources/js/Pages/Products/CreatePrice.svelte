<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import FlashMessage from "@user-shared/FlashMessage";
  import route from "ziggy";

  export let batch;
  let details = {
    product_batch_id: batch.id
  };

  $: ({ app } = $page);
</script>

<Layout title="Create Product Price For {batch.batch_number}">
  <div class="row vertical-gap">
    <div class="col-lg-8 col-xl-7">
      <form class="#">
        <div class="row vertical-gap sm-gap">
          <div class="col-6">
            <label for="exampleBase1">Product Model</label>
            <div class="input-group">
              <select class="custom-select">
                <option selected>Select</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
              </select>
            </div>
          </div>
          <div class="col-6">
            <label for="exampleBase1">Product Brand</label>
            <div class="input-group">
              <select class="custom-select">
                <option selected>Select</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
              </select>
            </div>
          </div>
          <div class="col-6">
            <label for="exampleBase1">Product Color</label>
            <div class="input-group">
              <select class="custom-select">
                <option selected>Select</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
              </select>
            </div>
          </div>
          <div class="col-6">
            <label for="exampleBase1">Product Grade</label>
            <div class="input-group">
              <select class="custom-select">
                <option selected>Select</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
              </select>
            </div>
          </div>
          <div class="col-6">
            <label for="exampleBase1">Product Supplier</label>
            <div class="input-group">
              <select class="custom-select">
                <option selected>Select</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
              </select>
            </div>
          </div>
          <div class="col-6">
            <label for="exampleBase1">Storage Size</label>
            <div class="input-group">
              <select class="custom-select">
                <option selected>Select</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
              </select>
            </div>
          </div>
          <div class="col-6">
            <label for="exampleBase1">Cost Price</label>
            <input
              type="text"
              class="form-control"
              id="exampleBase1"
              placeholder="Enter cost price" />
          </div>
          <div class="col-6">
            <label for="exampleBase1">Proposed Selling Price</label>
            <input
              type="text"
              class="form-control"
              id="exampleBase1"
              placeholder="Enter proposed selling price" />
          </div>
          <div class="col-12">
            <button type="button" class="btn btn-brand btn-long">
              <span class="text">Create Product Price</span>
              <span class="icon">
                <span
                  data-feather="check-circle"
                  class="rui-icon rui-icon-stroke-1_5" />
              </span>
            </button>
            &nbsp;
          </div>
        </div>
      </form>
    </div>
  </div>
</Layout>
