<script>
  import { Inertia } from "@inertiajs/inertia";
  import Layout from "@superadmin-shared/SuperAdminLayout";

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
    office_branches;

  let details = {
    identification_type: "imei"
  };

  let createLocalProduct = () => {
    BlockToast.fire({
      text: "Creating local supplier product ..."
    });

    Inertia.post(route("accountant.products.create"), details, {
      preserveState: true,
      preserveScroll: true,
      only: ["flash", "errors"]
    })
  };
</script>

<style>
  select{
    text-transform: capitalize;
  }
</style>

<Layout title="Add New Stock">
  <div class="row vertical-gap">
    <div class="col-lg-8 col-xl-6">
      <form class="#" on:submit|preventDefault={createLocalProduct}>
        <div class="row vertical-gap sm-gap">
          <div class="col-6 col-md-4">
            <label for="productBatch">Product Batch</label>
            <div class="input-group">
              <select
                class="custom-select"
                bind:value={details.product_batch_id}>
                <option value={null}>Select</option>
                {#each batches as batch}
                  <option value={batch.id}>{batch.batch_number}({batch.order_date})</option>
                {/each}
              </select>
            </div>
          </div>
          <div class="col-6 col-md-4">
            <label for="productCategory">Product Category</label>
            <div class="input-group">
              <select
                class="custom-select"
                bind:value={details.product_category_id}>
                <option value={null}>Select</option>
                {#each categories as category}
                  <option value={category.id}>{category.name}</option>
                {/each}
              </select>
            </div>
          </div>
           <div class="col-6 col-md-4">
            <label for="productBrand">Product Brand</label>
            <div class="input-group">
              <select
                class="custom-select"
                bind:value={details.product_brand_id}>
                <option value={null}>Select</option>
                {#each brands as brand}
                  <option value={brand.id}>{brand.name}</option>
                {/each}
              </select>
            </div>
          </div>

          <div class="col-6 col-md-4">
            <label for="productModel">Product Model</label>
            <div class="input-group">
              <select
                class="custom-select"
                bind:value={details.product_model_id}>
                <option value={null}>Select</option>
                {#each models as model}
                  <option value={model.id}>{model.name}</option>
                {/each}
              </select>
            </div>
          </div>

          <div class="col-6 col-md-4">
            <label for="productColor">Product Color</label>
            <div class="input-group">
              <select
                class="custom-select"
                bind:value={details.product_color_id}>
                <option value={null}>Select</option>
                {#each colors as color}
                  <option value={color.id}>{color.name}</option>
                {/each}
              </select>
            </div>
          </div>
          <div class="col-6 col-md-4">
            <label for="productGrade">Product Grade</label>
            <div class="input-group">
              <select
                class="custom-select"
                bind:value={details.product_grade_id}>
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
                bind:value={details.product_supplier_id}>
                <option value={null}>Select</option>
                {#each suppliers as supplier}
                  <option value={supplier.id}>{supplier.name}</option>
                {/each}
              </select>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <label for="storageSize">Storage Size</label>
            <div class="input-group">
              <select
                class="custom-select"
                bind:value={details.storage_size_id}>
                <option value={null}>Select</option>
                {#each storage_sizes as storage_size}
                  <option value={storage_size.id}>
                    {storage_size.human_size}
                  </option>
                {/each}
              </select>
            </div>
          </div>

          <div class="col-6 col-md-3">
            <label for="ramSize">RAM Size</label>
            <div class="input-group">
              <select class="custom-select" bind:value={details.ram_size_id}>
                <option value={null}>Select</option>
                {#each storage_sizes as storage_size}
                  <option value={storage_size.id}>
                    {storage_size.human_size}
                  </option>
                {/each}
              </select>
            </div>
          </div>
          <div class="col-6 col-md-4">
            <label for="storageType">Storage Type</label>
            <div class="input-group">
              <select
                class="custom-select"
                bind:value={details.storage_type_id}>
                <option value={null}>Select</option>
                {#each storage_types as storage_type}
                  <option value={storage_type.id}>{storage_type.type}</option>
                {/each}
              </select>
            </div>
          </div>

          <div class="col-6 col-md-4">
            <label for="processorSpeed">Processor Speed</label>
            <div class="input-group">
              <select
                class="custom-select"
                bind:value={details.processor_speed_id}>
                <option value={null}>Select</option>
                {#each processor_speeds as processor_speed}
                  <option value={processor_speed.id}>
                    {processor_speed.speed}
                  </option>
                {/each}
              </select>
            </div>
          </div>

          <div class="col-6 col-md-4">
            <label for="officeBranch">Office Branch</label>
            <div class="input-group">
              <select
                class="custom-select"
                bind:value={details.office_branch_id}>
                <option value={null}>Select</option>
                {#each office_branches as office_branch}
                  <option value={office_branch.id}>
                    {office_branch.city}
                  </option>
                {/each}
              </select>
            </div>
          </div>

          {#if details.identification_type === 'imei'}
            <div class="col-12">
              <label for="imeiNo">Imei No.</label>
              <input
                type="text"
                class="form-control"
                bind:value={details.imei}
                placeholder="Enter Imei No." />
            </div>
          {:else if details.identification_type === 'serial_no'}
            <div class="col-12">
              <label for="serialNo">Serial No.</label>
              <input
                type="text"
                class="form-control"
                bind:value={details.serial_no}
                placeholder="Enter Serial No." />
            </div>
          {:else if details.identification_type === 'model_no'}
            <div class="col-12">
              <label for="modelNo">Model No.</label>
              <input
                type="text"
                class="form-control"
                bind:value={details.model_no}
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
                  delete details.model_no;
                  delete details.serial_no;
                }}
                bind:group={details.identification_type}
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
                  delete details.imei;
                  delete details.model_no;
                }}
                bind:group={details.identification_type}
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
                  delete details.imei;
                  delete details.serial_no;
                }}
                bind:group={details.identification_type}
                class="custom-control-input" />
              <label class="custom-control-label" for="model-no-option">
                Model No.
              </label>
            </div>
          </div>
          <div class="col-12">
            <button class="btn btn-primary btn-long">
              <span class="text">Create Product</span>
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
