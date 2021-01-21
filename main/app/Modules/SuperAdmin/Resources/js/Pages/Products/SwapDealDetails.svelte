<script>
  import { inertia, page } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import DisplayUserComments from "@superadmin-shared/Partials/DisplayUserComments.svelte";
  import { toCurrency } from '@public-shared/helpers';

  $: ({ auth } = $page.props);

  export let swapDeal = {},
    userComment,
    product_statuses = [];

  let updateSwapDetails = () => {
    BlockToast.fire({
      text: "Updating Swap deal details ..."
    });

    Inertia.put(
      route("accountant.products.edit_swap_deal", swapDeal.uuid),
      swapDeal,
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "swapDeal"]
      }
    )
  };

  let commentOnSwapDeal = uuid => {
    BlockToast.fire({
      text: "Creating comment ..."
    });

    Inertia.post(
      route(auth.user.user_type + ".multiaccess.products.comment_on_swap_deal", uuid),
      { comment: userComment },
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "swapDeal"],
        onSuccess: () =>{
          userComment = null;
        },
      }
    )
  };

  let updateSwapDealStatus = () => {
    BlockToast.fire({
      text: "Updating swap deal status ..."
    });

    Inertia.put(
      route("qualitycontrol.products.update_swap_status", swapDeal.uuid),
      { product_status_id: swapDeal.product_status_id },
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "swapDeal"]
      }
    )
  };
</script>

<style>
  textarea{
    height:100px;
  }
</style>

<Layout title="Swap Device Details">
  <div class="row vertical-gap">
    <!-- <div class="col-lg-3">
      <a
        href="/img/iphone-11.png"
        data-fancybox="images"
        class="rui-gallery-item">
        <img src="/img/iphone-11.png" class="rui-img" alt="" />
      </a>
      <hr />
    </div> -->
    <div class="col-lg-5">
      <table class="table table-bordered">
        <tbody>
          <tr>
            <td class="text-primary"><strong>Description</strong></td>
            <th scope="row">
              <strong>{swapDeal.description}</strong>
            </th>
          </tr>
          <tr>
            <td class="text-primary"><strong>Device ID</strong></td>
            <th scope="row"><strong>{swapDeal.identifier}</strong></th>
          </tr>
          <tr>
            <td class="text-primary"><strong>Status</strong></td>
            <th scope="row">
              <strong>{swapDeal.status}</strong>
                {#if swapDeal.product_receipt_ref_no && (auth.user.isAccountant || auth.user.isSuperAdmin)}
                <span><a target="_blank" class="small" href="{route(auth.user.user_type + '.multiaccess.products.receipt', swapDeal.product_receipt_ref_no)}">Receipt</a></span>
                <span><button class="btn btn-xs btn-info" use:inertia="{{ href: route(auth.user.user_type + '.multiaccess.products.resend_receipt', swapDeal.product_receipt_ref_no), method: 'post' }}">Resend Receipt</button></span>
              {/if}
            </th>
          </tr>
          {#if auth.user.isSuperAdmin || auth.user.isAdmin || auth.user.isAccountant}
            <tr>
              <td class="text-primary"><strong>Seller Details</strong></td>
              <th scope="row"><strong>{swapDeal.seller_details}</strong></th>
            </tr>
            <tr>
              <td class="text-primary"><strong>Seller ID</strong></td>
              <th scope="row">
                <a href={swapDeal.id_url} target="_blank">
                  <img src={swapDeal.id_thumb_url} alt="seller's ID card" />
                </a>
              </th>
            </tr>
            <tr>
              <td class="text-primary"><strong>Receipt</strong></td>
              <th scope="row">
                <a href={swapDeal.receipt_url} target="_blank">
                  <img
                    src={swapDeal.receipt_thumb_url}
                    alt="seller's receipt" />
                </a>
              </th>
            </tr>
            <tr>
              <td class="text-primary"><strong>Swap Value</strong></td>
              <th scope="row"><strong>{toCurrency(swapDeal.swap_value)}</strong></th>
            </tr>
            {#if auth.user.isSuperAdmin || auth.user.isAccountant}
              <tr>
                <td class="text-primary"><strong>Sold At</strong></td>
                <th scope="row"><strong>{toCurrency(swapDeal.sold_at)}</strong></th>
              </tr>
            {/if}
            <tr>
              <td class="text-primary"><strong>Swapped With</strong></td>
              <th scope="row"><strong>{swapDeal.swapped_with}</strong></th>
            </tr>
            <tr>
              <td class="text-primary"><strong>Buyer</strong></td>
              <th scope="row"><strong>{swapDeal.buyer}</strong></th>
            </tr>
          {/if}
          {#if auth.user.isSuperAdmin || auth.user.isQualityControl || auth.user.isAdmin || auth.user.isAccountant}
            <tr>
              <td class="text-primary"><strong>Total Expenses</strong></td>
              <th scope="row">
                <strong>{swapDeal.total_product_expenses}</strong>
              </th>
            </tr>
          {/if}
          <tr>
            <td class="text-primary"><strong>Selling Price</strong></td>
            <th scope="row"><strong>{toCurrency(swapDeal.selling_price)}</strong></th>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="col-lg-4">
      {#if auth.user.isAccountant && swapDeal.status == 'in stock'}
        <div class="row mb-50">
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
              <input
                type="text"
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
      {/if}
      {#if auth.user.isQualityControl && swapDeal.status != 'sold' && swapDeal.status != 'sale confirmed' && swapDeal.status != 'sold by reseller'}
        <div class="col-12 mb-50">
          <label for="productGrade">Update Swap Deal Status</label>
          <div class="input-group">
            <select
              class="custom-select"
              bind:value={swapDeal.product_status_id}>
              <option value={null}>Select</option>
              {#each product_statuses as status}
                <option value={status.id}>{status.status}</option>
              {/each}
            </select>
            <button
              on:click={updateSwapDealStatus}
              class="btn btn-dark btn-long">
              <span class="text">Update</span>
            </button>
          </div>
        </div>
      {/if}

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
