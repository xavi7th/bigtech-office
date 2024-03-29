<script>
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Modal from "@superadmin-shared/Partials/Modal.svelte";

  $: ({ auth } = $page.props);

  export let resellerWithProducts = {};
  let sellingPrice, productToMarkAsSold;

  let markProductAsSold = () => {
      swalPreconfirm
        .fire({
          text:
          "This will mark this product as sold no longer available in the stock list",
          confirmButtonText: "Yes, carry on!",
           preConfirm: () => {
            return Inertia.post(
              route("accountant.resellers.mark_as_sold", [
                resellerWithProducts.id,
                productToMarkAsSold
              ]),
              {
                selling_price: sellingPrice
              },
              {
                preserveState: true,
                preserveScroll: true,
                only: ["flash", "errors", "resellerWithProducts"],
                onSuccess: () =>{
                  sellingPrice = null;
                  jQuery('#enterProductSellingPrice').modal('hide')
                },
              }
            )
          }
        })
      .then(result => {
        if (result.dismiss && result.dismiss == "cancel") {
          swal.fire(
            "Canceled!",
            "You canceled the action. Nothing was changed",
            "info"
          );
        }
      });
  };

</script>

<Layout title="Manage Resellers">
  <div class="row vertical-gap">
    <div class="col-lg-4 col-xl-4">
      <div class="card">
        <div class="card-body">
          <div class="row vertical-gap">
            <div class="col-auto">
              <div class="rui-profile-img">
                <img
                  src={resellerWithProducts.img_url}
                  alt="{resellerWithProducts.business_name}'s logo'"
                  width="100" />
              </div>
            </div>
            <div class="col">
              <div class="rui-profile-info">
                <h3 class="rui-profile-info-title h4">
                  {resellerWithProducts.ceo_name}
                </h3>
                <small class="text-grey-6 mt-2 mb-15">
                  Registered: {resellerWithProducts.registered_on}
                </small>
                <br />
                <a class="rui-profile-info-mail" href="#home">
                  {resellerWithProducts.phone}
                </a>
                <br />
                <a class="rui-profile-info-phone" href="#home">
                  {resellerWithProducts.address}
                </a>
              </div>
              <br />
            </div>
          </div>
          <div class="rui-profile-numbers">
            <div class="row justify-content-center">
              <div class="col-12">
                <div class="rui-profile-number text-center">
                  <h4 class="rui-profile-number-title h2">
                    {resellerWithProducts.business_name}
                  </h4>
                  <small class="text-grey-6">BUSINESS NAME</small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-8 col-xl-8">
      <div class="d-flex align-items-center justify-content-between mb-25">
        <h2 class="mnb-2" id="formBase">Tenured Products</h2>
      </div>
      <div class="table-responsive-md">
        <table
          class="rui-datatable table table-bordered table-bordered table-sm"
          data-order="[]">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Device</th>
              <th scope="col">Product Code</th>
              <th scope="col">Collection Date</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            {#each resellerWithProducts.products_in_possession as product, idx}
              <tr>
                <td>{idx + 1}</td>
                <td>{product.color || ''} {product.model} {product.storage_size || ''}</td>
                <td>{product.identifier}</td>
                <td>{product.collection_date}</td>
                <td>
                  {#if auth.user.isAccountant}
                    <InertiaLink
                      href={route('accountant.resellers.return_product', [
                        resellerWithProducts.id,
                        product.uuid
                      ])}
                      method="post"
                      preserve-scroll
                      preserve-state
                      only={['flash', 'errors', 'resellerWithProducts']}
                      class="btn btn-info btn-xs">
                      Return
                    </InertiaLink>
                    <button
                      on:click={() => {
                        productToMarkAsSold = product.uuid;
                      }}
                      data-toggle="modal"
                      data-target="#enterProductSellingPrice"
                      class="btn btn-success btn-xs btn-sm text-nowrap">
                      Mark Sold
                    </button>
                  {/if}

                  {#if auth.user.isSuperAdmin || auth.user.isAccountant}
                    {#if product.is_swap_transaction}
                      <InertiaLink
                        type="button"
                        href={route(auth.user.user_type + '.multiaccess.products.swap_deal_details', product.uuid)}
                        class="btn btn-primary btn-xs btn-sm text-nowrap">
                        View Product
                      </InertiaLink>
                    {:else}
                      <InertiaLink
                        type="button"
                        href={route(auth.user.user_type + '.multiaccess.products.view_product_details', product.uuid)}
                        class="btn btn-primary btn-xs btn-sm text-nowrap">
                        View Product
                      </InertiaLink>
                    {/if}
                  {/if}
                </td>
              </tr>
            {/each}
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div slot="modals">
    {#if auth.user.isAccountant}
      <Modal modalId="enterProductSellingPrice" modalTitle="Enter Selling Price">

      <div class="row vertical-gap sm-gap">
        <div class="col-12">
          <input
            type="number"
            min="0"
            class="form-control"
            placeholder="Selling Price"
            bind:value={sellingPrice} />
        </div>
      </div>
      <button
        on:click={markProductAsSold}
        slot="footer-buttons"
        class="btn btn-success btn-long"
        disabled={!sellingPrice}>
        <span class="text">Mark As Sold</span>
      </button>
    </Modal>
    {/if}
  </div>
</Layout>
