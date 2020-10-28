<script>
  import { Inertia } from "@inertiajs/inertia";
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import Layout from "@superadmin-shared/SuperAdminLayout.svelte";
  import Icon from "@superadmin-shared/Partials/TableSortIcon";
  import { getErrorString } from "@public-assets/js/bootstrap";
  import route from "ziggy";
  import Modal from "@superadmin-shared/Partials/Modal.svelte";

  $: ({ auth, flash, errors } = $page);

  export let dispatch_requests = [];

  let dispatchRequestToSchedule = {
    identification_type: "imei"
  };

  let scheduleProductForDelivery = () => {
    swalPreconfirm
      .fire({
        text:
          "This will mark this product as out for delivery and remove it from the stock list",
        confirmButtonText: "Mark for Delivery",
        preConfirm: () => {
          return Inertia.post(
            route(
              "dispatchadmin.dispatch_requests.schedule_delivery",
              dispatchRequestToSchedule.id
            ),
            {
              identification_type:
                dispatchRequestToSchedule.identification_type,
              imei: dispatchRequestToSchedule.imei,
              serial_no: dispatchRequestToSchedule.serial_no,
              model_no: dispatchRequestToSchedule.model_no
            },
            {
              preserveState: true,
              preserveScroll: true,
              only: ["flash", "errors", "dispatch_requests"]
            }
          )
            .then(() => {
              if (flash.success) {
                return true;
              } else if (flash.error || _.size(errors) > 0) {
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
  };

  let discardDispatchRequest = dispatchRequestId => {
    swalPreconfirm
      .fire({
        text:
          "This will delete this delivery request and this request can no longer be processed. Enter a reason for deleting this request in the box below. ",
        input: "text",
        inputAttributes: {
          autocapitalize: "off",
          placeholder: "Enter reason"
        },
        confirmButtonText: "Discard Request",
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        preConfirm: reason => {
          if (!reason) {
            swal.showValidationMessage(
              `You must provide a reason for deleting the request`
            );
            return false;
          }

          return Inertia.post(
            route("dispatchadmin.dispatch_requests.delete", dispatchRequestId),
            {
              reason
            },
            {
              preserveState: true,
              preserveScroll: true,
              only: ["flash", "errors", "dispatch_requests"]
            }
          )
            .then(() => {
              if (flash.success) {
                return true;
              } else if (flash.error || _.size(errors) > 0) {
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
            html: flash.success,
            timer: 10000
          });
        }
      });
  };
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
                Description
                <Icon />
              </th>
              <th scope="col">
                Sales Rep
                <Icon />
              </th>
              <th scope="col">Grand Total</th>
              <th scope="col">Request Date</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            {#each dispatch_requests as dispatchRequest}
              <tr>
                <th scope="row">{dispatchRequest.id}</th>
                <td>{dispatchRequest.product_description}</td>
                <td>{dispatchRequest.online_rep}</td>
                <td>{dispatchRequest.grand_total}</td>
                <td>{dispatchRequest.time_of_request}</td>
                <td>
                  {#if auth.user.isDispatchAdmin}
                    {#if !dispatchRequest.is_scheduled}
                      <button
                        type="button"
                        on:click={() => {
                          discardDispatchRequest(dispatchRequest.id);
                        }}
                        class="btn btn-danger btn-xs btn-sm text-nowrap">
                        Discard Request
                      </button>
                    {/if}
                    <button
                      type="button"
                      on:click={() => {
                        dispatchRequestToSchedule.id = dispatchRequest.id;
                        dispatchRequestToSchedule.is_scheduled = dispatchRequest.is_scheduled;
                        dispatchRequestToSchedule.primary_identifier = dispatchRequest.primary_identifier;
                        dispatchRequestToSchedule.grand_total = dispatchRequest.grand_total;
                        dispatchRequestToSchedule.product_description = dispatchRequest.product_description;
                        dispatchRequestToSchedule.customer_details = dispatchRequest.customer_details;
                      }}
                      data-toggle="modal"
                      data-target="#enterSalesDetails"
                      class="btn btn-dark btn-xs btn-sm">
                      Details
                    </button>
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
    <Modal modalId="enterSalesDetails" modalTitle="Enter Sales Details">
      <div class="row vertical-gap sm-gap">
        <div class="col-12">
          <div class="bg-grey-1 pt-15 pr-20 pb-15 pl-20 br-4">
            Device Details:
            {@html dispatchRequestToSchedule.product_description}
            <br />
            Grand Total:
            {@html dispatchRequestToSchedule.grand_total}
          </div>
        </div>
        <div class="col-12">
          <div class="bg-grey-1 pt-15 pr-20 pb-15 pl-20 br-4">
            {@html dispatchRequestToSchedule.customer_details}
          </div>
        </div>
        {#if dispatchRequestToSchedule.is_scheduled}
          <div class="col-12">
            <div class="bg-grey-1 pt-15 pr-20 pb-15 pl-20 br-4">
              Scheduled Product:
              {dispatchRequestToSchedule.primary_identifier}
            </div>
          </div>
        {:else}
          <div class="col-12">
            <label for="idType">Choose Primary Identifier</label>
          </div>
          <div class="col-12 d-flex justify-content-between">
            <div class="custom-control custom-radio">
              <input
                type="radio"
                id="imei-option"
                name="primary-identifier"
                value="imei"
                on:change={() => {
                  delete dispatchRequestToSchedule.model_no;
                  delete dispatchRequestToSchedule.serial_no;
                }}
                bind:group={dispatchRequestToSchedule.identification_type}
                class="custom-control-input" />
              <label class="custom-control-label" for="imei-option">IMEI</label>
            </div>
            <div class="custom-control custom-radio mt-5">
              <input
                type="radio"
                id="serial-no-option"
                name="primary-identifier"
                value="serial_no"
                on:change={() => {
                  delete dispatchRequestToSchedule.imei;
                  delete dispatchRequestToSchedule.model_no;
                }}
                bind:group={dispatchRequestToSchedule.identification_type}
                class="custom-control-input" />
              <label class="custom-control-label" for="serial-no-option">
                Serial No.
              </label>
            </div>
            <div class="custom-control custom-radio mt-5">
              <input
                type="radio"
                id="model-no-option"
                name="primary-identifier"
                value="model_no"
                on:change={() => {
                  delete dispatchRequestToSchedule.imei;
                  delete dispatchRequestToSchedule.serial_no;
                }}
                bind:group={dispatchRequestToSchedule.identification_type}
                class="custom-control-input" />
              <label class="custom-control-label" for="model-no-option">
                Model No.
              </label>
            </div>
          </div>

          {#if dispatchRequestToSchedule.identification_type === 'imei'}
            <div class="col-12">
              <label for="imeiNo">Imei No.</label>
              <input
                type="text"
                class="form-control"
                bind:value={dispatchRequestToSchedule.imei}
                placeholder="Enter Imei No." />
            </div>
          {:else if dispatchRequestToSchedule.identification_type === 'serial_no'}
            <div class="col-12">
              <label for="serialNo">Serial No.</label>
              <input
                type="text"
                class="form-control"
                bind:value={dispatchRequestToSchedule.serial_no}
                placeholder="Enter S/No" />
            </div>
          {:else if dispatchRequestToSchedule.identification_type === 'model_no'}
            <div class="col-12">
              <label for="modelNo">Model No.</label>
              <input
                type="text"
                class="form-control"
                bind:value={dispatchRequestToSchedule.model_no}
                placeholder="Enter Model No." />
            </div>
          {/if}
        {/if}
      </div>

      <button
        on:click={scheduleProductForDelivery}
        slot="footer-buttons"
        class="btn btn-orange btn-long"
        disabled={(!dispatchRequestToSchedule.imei && !dispatchRequestToSchedule.serial_no && !dispatchRequestToSchedule.model_no) || dispatchRequestToSchedule.is_scheduled}>
        <span class="text">Schedule Delivery</span>
      </button>
    </Modal>
  </div>
</Layout>
