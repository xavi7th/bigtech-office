<script>
  import { Inertia } from "@inertiajs/inertia";
  import Layout from "@superadmin-shared/SuperAdminLayout";
	import { page } from '@inertiajs/inertia-svelte'


  export let models,
    brands,
    batches,
    colors,
    categories,
    grades,
    suppliers,
    storage_sizes,
    storage_types,
    processor_speeds,
    product;

  let updateProduct = () => {
    BlockToast.fire({
      text: "updating product details ..."
    });

    Inertia.put(route($page.props.auth.user.user_type + '.multiaccess.products.update', product.product_uuid), product, {
      preserveState: true,
      preserveScroll: true,
      only: ["flash", "errors", "product"]
    })
  };

</script>

<style>
  select{
    text-transform: capitalize;
  }
</style>

<Layout title="Update Product Details">
  <div class="row vertical-gap">
    <div class="col-lg-8 col-xl-6">
      <form class="#" on:submit|preventDefault={updateProduct}>
        <div class="row vertical-gap sm-gap">
          <div class="col-4">
            <label for="productBatch">Product Batch</label>
            <div class="input-group">
              <select
                class="custom-select"
                bind:value={product.product_batch_id}>
                <option value={null}>Select</option>
                {#each batches as batch}
                  <option value={batch.id}>{batch.batch_number}({batch.order_date})</option>
                {/each}
              </select>
            </div>
          </div>
          <div class="col-4">
            <label for="productCategory">Product Category</label>
            <div class="input-group">
              <select
                class="custom-select"
                bind:value={product.product_category_id}>
                <option value={null}>Select</option>
                {#each categories as category}
                  <option value={category.id}>{category.name}</option>
                {/each}
              </select>
            </div>
          </div>
           <div class="col-4">
            <label for="productBrand">Product Brand</label>
            <div class="input-group">
              <select
                class="custom-select"
                bind:value={product.product_brand_id}>
                <option value={null}>Select</option>
                {#each brands as brand}
                  <option value={brand.id}>{brand.name}</option>
                {/each}
              </select>
            </div>
          </div>

          <div class="col-4">
            <label for="productModel">Product Model</label>
            <div class="input-group">
              <select
                class="custom-select"
                bind:value={product.product_model_id}>
                <option value={null}>Select</option>
                {#each models as model}
                  <option value={model.id}>{model.name}</option>
                {/each}
              </select>
            </div>
          </div>

          <div class="col-4">
            <label for="productColor">Product Color</label>
            <div class="input-group">
              <select
                class="custom-select"
                bind:value={product.product_color_id}>
                <option value={null}>Select</option>
                {#each colors as color}
                  <option value={color.id}>{color.name}</option>
                {/each}
              </select>
            </div>
          </div>
          <div class="col-4">
            <label for="productGrade">Product Grade</label>
            <div class="input-group">
              <select
                class="custom-select"
                bind:value={product.product_grade_id}>
                <option value={null}>Select</option>
                {#each grades as grade}
                  <option value={grade.id}>{grade.grade}</option>
                {/each}
              </select>
            </div>
          </div>
          <div class="col-6">
            <label for="productSupplier">Product Supplier</label>
            <div class="input-group">
              <select
                class="custom-select"
                bind:value={product.product_supplier_id}>
                <option value={null}>Select</option>
                {#each suppliers as supplier}
                  <option value={supplier.id}>{supplier.name}</option>
                {/each}
              </select>
            </div>
          </div>
          <div class="col-6">
            <label for="storageSize">Storage Size</label>
            <div class="input-group">
              <select
                class="custom-select"
                bind:value={product.storage_size_id}>
                <option value={null}>Select</option>
                {#each storage_sizes as storage_size}
                  <option value={storage_size.id}>
                    {storage_size.human_size}
                  </option>
                {/each}
              </select>
            </div>
          </div>

          <div class="col-6">
            <label for="ramSize">RAM Size</label>
            <div class="input-group">
              <select class="custom-select" bind:value={product.ram_size_id}>
                <option value={null}>Select</option>
                {#each storage_sizes as storage_size}
                  <option value={storage_size.id}>
                    {storage_size.human_size}
                  </option>
                {/each}
              </select>
            </div>
          </div>
          <div class="col-6">
            <label for="storageType">Storage Type</label>
            <div class="input-group">
              <select
                class="custom-select"
                bind:value={product.storage_type_id}>
                <option value={null}>Select</option>
                {#each storage_types as storage_type}
                  <option value={storage_type.id}>{storage_type.type}</option>
                {/each}
              </select>
            </div>
          </div>
          <div class="col-6">
            <label for="processorSpeed">Processor Speed</label>
            <div class="input-group">
              <select
                class="custom-select"
                bind:value={product.processor_speed_id}>
                <option value={null}>Select</option>
                {#each processor_speeds as processor_speed}
                  <option value={processor_speed.id}>
                    {processor_speed.speed}
                  </option>
                {/each}
              </select>
            </div>
          </div>

          {#if product.imei || product.identification_type === 'imei'}
            <div class="col-6">
              <label for="imeiNo">Imei No.</label>
              <input
                type="text"
                class="form-control"
                bind:value={product.imei}
                placeholder="Enter Imei No." />
            </div>
          {:else if product.serial_no ||  product.identification_type === 'serial_no'}
            <div class="col-6">
              <label for="serialNo">Serial No.</label>
              <input
                type="text"
                class="form-control"
                bind:value={product.serial_no}
                placeholder="Enter Serial No." />
            </div>
          {:else if product.model_no ||  product.identification_type === 'model_no'}
            <div class="col-6">
              <label for="modelNo">Model No.</label>
              <input
                type="text"
                class="form-control"
                bind:value={product.model_no}
                placeholder="Enter Model No." />
            </div>
          {/if}
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
                  delete product.model_no;
                  delete product.serial_no;
                }}
                bind:group={product.identification_type}
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
                  delete product.imei;
                  delete product.model_no;
                }}
                bind:group={product.identification_type}
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
                  delete product.imei;
                  delete product.serial_no;
                }}
                bind:group={product.identification_type}
                class="custom-control-input" />
              <label class="custom-control-label" for="model-no-option">
                Model No.
              </label>
            </div>
          </div>
          <div class="col-12">
            <button class="btn btn-primary btn-long">
              <span class="text">Update Product</span>
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
