<script>
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import { Inertia } from "@inertiajs/inertia";
  import Modal from "@superadmin-shared/Partials/Modal";

  let productSupplierObj = {
    is_local:false
  };

  let createProductSupplier = () => {
    BlockToast.fire({
      text: "Creating product supplier ..."
    });

    Inertia.post(
      route("superadmin.product_suppliers.create"),
      {
        name: productSupplierObj.name,
        is_local: productSupplierObj.is_local
      },
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "productSuppliers"],
        onSuccess: () =>{
          productSupplierObj.name = null;
        },
      }
    )
  };

  let updateProductSupplier = () => {
    BlockToast.fire({
      text: "Updating product supplier ..."
    });

    Inertia.put(
      route("superadmin.product_suppliers.edit", productSupplierObj.id),
      {
        name: productSupplierObj.name,
        is_local: productSupplierObj.is_local
      },
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "productSuppliers"],
        onSuccess: () =>{
          productSupplierObj = {};
        },
      }
    )
  };

  let deleteProductSupplier = id => {
    swal
      .fire({
        title: "Are you sure?",
        text:
          "This product supplier will be permanently deleted and products can no longer be created under it",
        icon: "question",
        showCloseButton: false,
        allowOutsideClick: () => !swal.isLoading(),
        allowEscapeKey: false,
        showCancelButton: true,
        focusCancel: true,
        cancelButtonColor: "#d33",
        confirmButtonColor: "#725ec3",
        confirmButtonText: "Yes, carry on!",
        showLoaderOnConfirm: true,
        preConfirm: () => {
          return Inertia.delete(
            route("superadmin.miscellaneous.delete_product_supplier", id),
            {
              preserveState: true,
              preserveScroll: true,
              only: ["flash", "errors", "productSuppliers"]
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

  export let productSuppliers = [];
</script>

<Layout title="Manage Product Suppliers">
  <div class="row vertical-gap">
    <div class="col-lg-4 col-xl-4">
      <form class="#" on:submit|preventDefault={createProductSupplier}>

        <div class="row vertical-gap sm-gap">
          <div class="col-12">
            <label for="name">Enter New Product Supplier</label>
            <input
              type="text"
              class="form-control"
              id="name"
              placeholder="Product Supplier Name"
              bind:value={productSupplierObj.name} />
          </div>

          <div class="col-12">
            <div class="custom-control custom-switch">
              <input
                type="checkbox"
                class="custom-control-input"
                id="is-local-supplier"
                bind:checked={productSupplierObj.is_local} />
              <label class="custom-control-label" for="is-local-supplier">
                Local Supplier
              </label>
            </div>
          </div>

          <div class="col-12">
            <button
              type="submit"
              class="btn btn-success btn-long">
              <span class="text">Create</span>
            </button>
          </div>
        </div>
      </form>
    </div>
    <div class="col-lg-8 col-xl-8">
      <div class="d-flex align-items-center justify-content-between mb-25">
        <h2 class="mnb-2" id="formBase">Available Product Suppliers</h2>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            {#each productSuppliers as productSupplier, idx}
              <tr>
                <td>{idx + 1}</td>
                <td>{productSupplier.name}</td>
                <td class="d-flex justify-content-between align-content-center">
                  <!-- <button
                    type="button"
                    class="btn btn-warning btn-xs"
                    on:click={() => {
                      deleteProductSupplier(productSupplier.id);
                    }}>
                    DELETE
                  </button> -->
                  <button
                    type="button"
                    class="btn btn-warning btn-xs"
                    data-toggle="modal"
                    data-target="#updateProductSupplier"
                    on:click={() => {
                      productSupplierObj = productSupplier
                    }}>
                    EDIT
                  </button>
                </td>
              </tr>
            {:else}
              <tr>
                <td colspan="5" class="text-center">NONE AVAILABLE</td>
              </tr>
            {/each}
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div slot="modals">
    <Modal modalId="updateProductSupplier" modalTitle="Update Product Supplier">

      <div class="row vertical-gap sm-gap">
        <div class="col-12">
          <label for="name">Change Product Supplier</label>
          <input
            type="text"
            class="form-control"
            placeholder="Product Supplier Name"
            bind:value={productSupplierObj.name} />
        </div>

        <div class="col-12">
          <div class="custom-control custom-switch">
            <input
              type="checkbox"
              class="custom-control-input"
              id="is-swap-deal"
              bind:checked={productSupplierObj.is_local} />
            <label class="custom-control-label" for="is-swap-deal">
              Local Supplier
            </label>
          </div>
        </div>

      </div>
      <button
        on:click={updateProductSupplier}
        slot="footer-buttons"
        class="btn btn-success btn-long"
        disabled={!productSupplierObj.name}>
        <span class="text">Update</span>
      </button>
    </Modal>
  </div>
</Layout>
