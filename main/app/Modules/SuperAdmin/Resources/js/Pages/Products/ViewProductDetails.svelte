<script>
  import { page, inertia } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import DisplayUserComments from "@superadmin-shared/Partials/DisplayUserComments.svelte";
  import { toCurrency } from '@public-shared/helpers';

  $: ({ auth } = $page.props);

  export let productDetails = {},
    productComments = [];

  let userComment;

  let commentOnProduct = uuid => {
    BlockToast.fire({
      text: "Creating comment ..."
    });

    Inertia.post(
      route(auth.user.user_type + ".multiaccess.products.comment_on_product", uuid),
      { comment: userComment },
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "productComments"],
         onSuccess: () =>{
          userComment = null;
        },
      }
    )
  };
</script>

<Layout title="Stock List">
  <div class="row vertical-gap">
    <div class="col-lg-2">
      <a
        href={productDetails.img}
        data-fancybox="images"
        class="rui-gallery-item">
        <img
          src={productDetails.img}
          class="rui-img"
          alt="{productDetails.model} stock image" />
      </a>
    </div>
    <div class="col-lg-5">
      <table class="table table-bordered">
        <thead class="thead-dark">
          <tr>
            <th scope="col" colspan="2">
              {productDetails.model} (Location: {productDetails.location}
              branch)
            </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-primary">
              <strong>STATUS</strong>
            </td>
            <th scope="row">
              <strong>{productDetails.status}</strong>
              {#if productDetails.product_receipt_ref_no && (auth.user.isAccountant || auth.user.isSuperAdmin)}
                <span><a target="_blank" class="small" href="{route(auth.user.user_type + '.multiaccess.products.receipt', productDetails.product_receipt_ref_no)}">Receipt</a></span>
                <span><button class="btn btn-xs btn-info" use:inertia="{{ href: route(auth.user.user_type + '.multiaccess.products.resend_receipt', productDetails.uuid), method: 'post' }}">Resend Receipt</button></span>
              {/if}
            </th>
          </tr>
         {#if auth.user.isAccountant || auth.user.isSuperAdmin}
            {#if productDetails.status == 'sold'}
            <tr>
              <td class="text-primary">
                <strong>Buyer</strong>
              </td>
              <th scope="row">
                <strong>
                  {productDetails.buyer.first_name} ({productDetails.buyer.email} from
                  {productDetails.buyer.city})
                </strong>
              </th>
            </tr>
          {/if}
          <tr>
            <td class="text-primary">
              <strong>Cost Price</strong>
            </td>
            <th scope="row">
              <strong>{toCurrency(productDetails.cost_price)}</strong>
            </th>
          </tr>
         {/if}
          <tr>
            <td class="text-primary">
              <strong>Selling Price</strong>
            </td>
            <th scope="row">
              <strong>{toCurrency(productDetails.selling_price)}</strong>
            </th>
          </tr>
          <tr>
            <td class="text-primary">
              <strong>Product Category</strong>
            </td>
            <th scope="row">
              <strong>{productDetails.category}</strong>
            </th>
          </tr>
          <tr>
            <td class="text-primary">
              <strong>Product Model</strong>
            </td>
            <th scope="row">
              <strong>{productDetails.model}</strong>
            </th>
          </tr>
          <tr>
            <td class="text-primary">
              <strong>Product Brand</strong>
            </td>
            <th scope="row">
              <strong>{productDetails.brand}</strong>
            </th>
          </tr>
          <tr>
            <td class="text-primary">
              <strong>Product Batch</strong>
            </td>
            <th scope="row">
              <strong>{productDetails.batch}</strong>
            </th>
          </tr>
          <tr>
            <td class="text-primary">
              <strong>Product Color</strong>
            </td>
            <th scope="row">
              <strong>{productDetails.color}</strong>
            </th>
          </tr>
          <tr>
            <td class="text-primary">
              <strong>Product Grade</strong>
            </td>
            <th scope="row">
              <strong>{productDetails.grade}</strong>
            </th>
          </tr>
          <tr>
            <td class="text-primary">
              <strong>Product Supplier</strong>
            </td>
            <th scope="row">
              <strong>{productDetails.supplier}</strong>
            </th>
          </tr>
          <tr>
            <td class="text-primary">
              <strong>Storage Size</strong>
            </td>
            <th scope="row">
              <strong>{productDetails.storage_size}</strong>
            </th>
          </tr>
          <tr>
            <td class="text-primary">
              <strong>RAM Size</strong>
            </td>
            <th scope="row">
              <strong>{productDetails.ram_size}</strong>
            </th>
          </tr>
          <tr>
            <td class="text-primary">
              <strong>Storage Type</strong>
            </td>
            <th scope="row">
              <strong>{productDetails.storage_type}</strong>
            </th>
          </tr>
          <tr>
            <td class="text-primary">
              <strong>Processor Speed</strong>
            </td>
            <th scope="row">
              <strong>{productDetails.processor_speed}</strong>
            </th>
          </tr>
          <tr>
            <td class="text-primary">
              <strong>Product ID</strong>
            </td>
            <th scope="row">
              <strong>{productDetails.identifier}</strong>
            </th>
          </tr>
          <tr>
            <td class="text-primary">
              <strong>Product UUID</strong>
            </td>
            <th scope="row">
              <strong>{productDetails.uuid}</strong>
            </th>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="col-lg-5">
      <div class="col-12">
        <label for="user-comment">Comment on this device</label>
        <div class="a" style="display: flex;">
          <input
            type="text"
            class="form-control"
            id="user-comment"
            bind:value={userComment}
            placeholder="Enter Comment" />
          <button
            type="button"
            disabled={!userComment}
            on:click={() => {
              commentOnProduct(productDetails.uuid);
            }}
            class="btn btn-brand btn-hover-primary ml-20">
            Comment
          </button>
        </div>
      </div>
      <hr />
     <DisplayUserComments comments={productComments}/>
    </div>
  </div>
</Layout>
