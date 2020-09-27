<script>
import { Inertia } from "@inertiajs/inertia";
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import Icon from "@superadmin-shared/Partials/TableSortIcon";
  import route from "ziggy";
  import MarkAsPaidModal from "@usershared/MarkAsPaidModal.svelte";
  import MarkAsSoldModal from "@usershared/MarkAsSoldModal.svelte";
  import GiveProductToReseller from "@usershared/GiveProductToReseller.svelte";
import { getErrorString } from "@public-assets/js/bootstrap";

  $: ({ flash,errors } = $page);

  export let products = [],
    resellers = [],
    onlineReps = [],
    companyAccounts = [],
    salesChannel = [];

  let productToMarkAsPaid, productToMarkAsSold, productToGiveReseller;

  let scheduleProductForDelivery = product =>{
    swalPreconfirm
      .fire({
        text:
          "This will mark this product as out for delivery and remove it from the stock list",
        confirmButtonText: "Mark for Delivery",
        preConfirm: () => {

          return Inertia.post(
            route("superadmin.products.schedule_delivery", product),
            {},
            {
              preserveState: true,
              preserveScroll: true,
              only: ["flash", "errors", "products"]
            }
          )
            .then(() => {
              if (flash.success) {
                return true;
              } else {
                throw new Error(flash.error || getErrorString(errors));
              }
            })
            .catch(error => {
              swal.showValidationMessage(`Request failed: ${error}`);
            });
        }
      })
      .then(result => {
        if (result.dismiss && result.dismiss == "cancel") {
          swal.fire(
            "Canceled!",
            "You canceled the action. Nothing was changed",
            "info"
          );
        } else if (flash.success) {
          ToastLarge.fire({
            title: "Successful!",
            html: flash.success
          });
        }
      });

  }

  let returnToStock = product =>{
    swalPreconfirm
      .fire({
        text:
          "This will return this product to the stock list",
        confirmButtonText: "Return to Stock",
        preConfirm: () => {

          return Inertia.post(
            route("superadmin.products.return_to_stock", product),
            {},
            {
              preserveState: true,
              preserveScroll: true,
              only: ["flash", "errors", "products"]
            }
          )
            .then(() => {
              if (flash.success) {
                return true;
              } else {
                throw new Error(flash.error || getErrorString(errors));
              }
            })
            .catch(error => {
              swal.showValidationMessage(`Request failed: ${error}`);
            });
        }
      })
      .then(result => {
        if (result.dismiss && result.dismiss == "cancel") {
          swal.fire(
            "Canceled!",
            "You canceled the action. Nothing was changed",
            "info"
          );
        } else if (flash.success) {
          ToastLarge.fire({
            title: "Successful!",
            html: flash.success
          });
        }
      });

  }

</script>

<Layout title="Stock List">
  <div class="row vertical-gap">
    <div class="col-lg-12 col-xl-12">
      <div class="table-responsive-md">
        <table
          class="rui-datatable table table-striped table-bordered table-sm">
          <thead class="thead-dark">
            <tr>
              <th scope="col">
                #
                <Icon />
              </th>
              <th scope="col">
                Device
                <Icon />
              </th>
              <th scope="col">
                Product ID
                <Icon />
              </th>
              <th scope="col">
                Cost Price
                <Icon />
              </th>
              <th scope="col">
                Selling Price
              </th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            {#each products as product, idx}
              <tr>
                <th scope="row">{idx + 1}</th>
                <td>
                  <span class="text-capitalize">{product.color}</span>
                  {product.model} {product.storage_size}
                </td>
                <td>{product.identifier}</td>
                <td>{product.cost_price}</td>
                <td>{product.selling_price}</td>
                <td>
                  <InertiaLink
                    type="button"
                    href={route('superadmin.products.view_product_details', product.uuid)}
                    class="btn btn-primary btn-xs btn-sm">
                    Details
                  </InertiaLink>
                  {#if product.status == 'out for delivery' || product.status == 'in stock' }

                    <button
                      type="button"
                      on:click={() => {
                        productToMarkAsSold = product.uuid;
                      }}
                      data-toggle="modal"
                      data-target="#enterSalesDetails"
                      class="btn btn-success btn-xs btn-sm">
                      Mark Sold
                    </button>
                  {/if}
                  {#if product.status == 'out for delivery' }

                     <button
                      type="button"
                      on:click={() => {
                        returnToStock(product.uuid)
                      }}

                      class="btn btn-orange btn-xs btn-sm">
                      Return to Stock
                    </button>

                  {/if}
                  {#if product.status == 'in stock'}
                    <button
                      type="button"
                      on:click={() => {
                        scheduleProductForDelivery(product.uuid)
                      }}

                      class="btn btn-orange btn-xs btn-sm">
                      Schedule Delivery
                    </button>


                    <button
                      type="button"
                      on:click={() => {
                        productToGiveReseller = product.uuid;
                      }}
                      data-toggle="modal"
                      data-target="#giveProductToReseller"
                      class="btn btn-warning btn-xs btn-sm">
                      Give Reseller
                    </button>
                  {/if}
                  {#if product.status == 'sold'}
                    <button
                      on:click={() => {
                        productToMarkAsPaid = product.uuid;
                      }}
                      data-toggle="modal"
                      data-target="#enterProductPaymentDetails"
                      class="btn btn-brand btn-xs btn-sm">
                      Mark Paid
                    </button>
                  {/if}
                  <InertiaLink
                    type="button"
                    href={route('superadmin.miscellaneous.view_product_history', product.uuid)}
                    class="btn btn-info btn-xs btn-sm">
                    History
                  </InertiaLink>
                </td>
              </tr>
            {/each}

          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div slot="modals">

    <MarkAsPaidModal {companyAccounts} {productToMarkAsPaid} />

    <MarkAsSoldModal {salesChannel} {onlineReps} {productToMarkAsSold} />

    <GiveProductToReseller {resellers} {productToGiveReseller} />
  </div>
</Layout>
