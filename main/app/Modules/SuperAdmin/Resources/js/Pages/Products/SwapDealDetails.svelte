<script>
  import { page } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import route from "ziggy";
  import { getErrorString } from "@public-assets/js/bootstrap";
  import DisplayUserComments from "@superadmin-shared/Partials/DisplayUserComments.svelte";

  $: ({ flash, errors } = $page);

  export let swapDeal = {},
    userComment,
    product_statuses = [];

  let updateSwapDetails = () => {
    BlockToast.fire({
      text: "Updating Swap deal details ..."
    });

    Inertia.put(
      route("superadmin.products.edit_swap_deal", swapDeal.uuid),
      swapDeal,
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "swapDeal"]
      }
    ).then(() => {
      if (flash.success) {
        ToastLarge.fire({
          title: "Successful!",
          html: flash.success
        });
      } else if (flash.error || _.size(errors) > 0) {
        ToastLarge.fire({
          title: "Oops!",
          html: flash.error || getErrorString(errors),
          timer: 10000,
          icon: "error"
        });
      } else {
        swal.close();
      }
    });
  };

  let commentOnSwapDeal = uuid => {
    BlockToast.fire({
      text: "Creating comment ..."
    });

    Inertia.post(
      route("superadmin.products.comment_on_swap_deal", uuid),
      { comment: userComment },
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "swapDeal"]
      }
    ).then(() => {
      if (flash.success) {
        ToastLarge.fire({
          title: "Successful!",
          html: flash.success
        });

        userComment = null;
      } else {
        ToastLarge.fire({
          title: "Oops!",
          html: flash.error || getErrorString(errors),
          timer: 10000,
          icon: "error"
        });
      }
    });
  };

  let updateSwapDealStatus = () => {
    BlockToast.fire({
      text: "Updating swap deal status ..."
    });

    Inertia.put(
      route("superadmin.products.update_swap_status", swapDeal.uuid),
      { product_status_id: swapDeal.product_status_id },
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "swapDeal"]
      }
    ).then(()=>{
          if (flash.success) {
      ToastLarge.fire({
        title: "Successful!",
        html: flash.success
      });
      delete flash.success;
    } else if (flash.error || _.size(errors) > 0) {
      ToastLarge.fire({
        title: "Oops!",
        html: flash.error || getErrorString(errors),
        timer: 10000,
        icon: "error"
      });
      delete flash.error;
      errors = null;
    } else {
      swal.close();
    }
    })
  };
</script>

<Layout title="Swap Device Details">
  <div class="row vertical-gap">
    <div class="col-lg-3">
      <a
        href="/img/iphone-11.png"
        data-fancybox="images"
        class="rui-gallery-item">
        <img src="/img/iphone-11.png" class="rui-img" alt="" />
      </a>
      <hr />
      <div class="row">
        <div class="col-12">
          <label for="updateSellingPrice">Selling price</label>
          <div class="a d-flex flex-wrap">
            <input
              type="text"
              class="form-control"
              id="updateSellingPrice"
              placeholder="Selling Price"
              bind:value={swapDeal.selling_price} />

            <label for="updateDescription">Description</label>
            <textarea
              name="updateDescription"
              id="updateDescription"
              bind:value={swapDeal.description}
              class="form-control" />

            <label for="updateComment">Comment</label>
            <textarea
              name="updateComment"
              id="updateComment"
              bind:value={swapDeal.comment}
              class="form-control" />
            <button
              type="button"
              on:click={updateSwapDetails}
              class="btn btn-brand btn-hover-primary btn-block mt-15">
              Update
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-5">
      <table class="table table-bordered">

        <tbody>
          <tr>
            <td class="text-primary">
              <strong>Description</strong>
            </td>
            <th scope="row">
              <strong>{swapDeal.description}</strong>
            </th>
          </tr>
          <tr>
            <td class="text-primary">
              <strong>Device ID</strong>
            </td>
            <th scope="row">
              <strong>{swapDeal.identifier}</strong>
            </th>
          </tr>
          <tr>
            <td class="text-primary">
              <strong>Seller Details</strong>
            </td>
            <th scope="row">
              <strong>{swapDeal.seller_details}</strong>
            </th>
          </tr>
          <tr>
            <td class="text-primary">
              <strong>Seller ID</strong>
            </td>
            <th scope="row">
              <a href={swapDeal.id_url} target="_blank">
                <img src={swapDeal.id_thumb_url} alt="seller's ID card" />
              </a>
            </th>
          </tr>
          <tr>
            <td class="text-primary">
              <strong>Receipt</strong>
            </td>
            <th scope="row">
              <a href={swapDeal.receipt_url} target="_blank">
                <img src={swapDeal.receipt_thumb_url} alt="seller's receipt" />
              </a>
            </th>
          </tr>
          <tr>
            <td class="text-primary">
              <strong>Swap Value</strong>
            </td>
            <th scope="row">
              <strong>{swapDeal.swap_value}</strong>
            </th>
          </tr>
          <tr>
            <td class="text-primary">
              <strong>Total Expenses</strong>
            </td>
            <th scope="row">
              <strong>{swapDeal.total_product_expenses}</strong>
            </th>
          </tr>
          <tr>
            <td class="text-primary">
              <strong>Selling Price</strong>
            </td>
            <th scope="row">
              <strong>{swapDeal.selling_price}</strong>
            </th>
          </tr>
          <tr>
            <td class="text-primary">
              <strong>Sold At</strong>
            </td>
            <th scope="row">
              <strong>{swapDeal.sold_at}</strong>
            </th>
          </tr>
          <tr>
            <td class="text-primary">
              <strong>Swapped With</strong>
            </td>
            <th scope="row">
              <strong>{swapDeal.swapped_with}</strong>
            </th>
          </tr>

          <tr>
            <td class="text-primary">
              <strong>Status</strong>
            </td>
            <th scope="row">
              <strong>{swapDeal.status}</strong>
            </th>
          </tr>

          <tr>
            <td class="text-primary">
              <strong>Buyer</strong>
            </td>
            <th scope="row">
              <strong>{swapDeal.buyer}</strong>
            </th>
          </tr>

        </tbody>
      </table>
    </div>
    <div class="col-lg-4">
      <div class="col-12 mb-50">

        <label for="productGrade">Update Swap Deal Status</label>
        <div class="input-group">
          <select class="custom-select" bind:value={swapDeal.product_status_id}>
            <option value={null}>Select</option>
            {#each product_statuses as status}
              <option value={status.id}>{status.status}</option>
            {/each}
          </select>
          <button on:click={updateSwapDealStatus} class="btn btn-dark btn-long">
            <span class="text">Update</span>
          </button>
        </div>
      </div>
      <div class="col-12">
        <label for="makeComment">Comment on this device</label>
        <div class="a" style="display: flex;">
          <input
            type="text"
            class="form-control"
            id="makeComment"
            bind:value={userComment}
            placeholder="Enter Comment" />
          <button
            type="button"
            disabled={!userComment}
            on:click={() => {
              commentOnSwapDeal(swapDeal.uuid);
            }}
            class="btn btn-brand btn-hover-primary ml-20">
            Comment
          </button>
        </div>
      </div>
      <hr />
      <DisplayUserComments comments={swapDeal.comments} />
    </div>
  </div>

</Layout>
