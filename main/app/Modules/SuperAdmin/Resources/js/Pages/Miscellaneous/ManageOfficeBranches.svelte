<script>
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import { InertiaLink,page } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Modal from "@superadmin-shared/Partials/Modal";

  $: ({ auth } = $page.props);

  let details = {};

  let createOfficeBranch = () => {
    BlockToast.fire({
      text: "Creating office branch ..."
    });

    Inertia.post(
      route("superadmin.office_branches.create"),
      details,
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "officeBranches"],
        onSuccess: () =>{
          details = {};
        },
      }
    )
  };

  let updateOfficeBranch = () => {
    BlockToast.fire({
      text: "Updating office branch ..."
    });

    Inertia.put(
      route("superadmin.office_branches.edit", details.id),
      details,
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "officeBranches"],
        onSuccess: () =>{
          details = {};
        },
      }
    )
  };

  let deleteOfficeBranch = id => {
      swalPreconfirm
        .fire({
          text:
          "This office branch will be permanently deleted and products can no longer be created under it",
          confirmButtonText: "Yes, carry on!",
          preConfirm: () => {
          return Inertia.delete(
            route("superadmin.office_branches.delete", id),
            {
              preserveState: true,
              preserveScroll: true,
              only: ["flash", "errors", "officeBranches"]
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

  export let officeBranches = [];
</script>

<Layout title="Manage Office Branches">
  <div class="row vertical-gap">

    {#if auth.user.isSuperAdmin}
      <div class="col-lg-3 col-xl-3 order-2 order-md-1">
        <form class="#" on:submit|preventDefault={createOfficeBranch}>

          <div class="row vertical-gap sm-gap">
            <div class="col-12">
              <label for="city">Branch City</label>
              <input
                type="text"
                class="form-control"
                id="city"
                placeholder="Branch Designated City"
                bind:value={details.city} />
            </div>
            <div class="col-12">
              <label for="country">Country</label>
              <input
                type="text"
                class="form-control"
                id="country"
                placeholder="Country"
                bind:value={details.country} />
            </div>

            <div class="col-12">
              <button
                type="submit"
                class="btn btn-success btn-long"
                disabled={!details.country || !details.city}>
                <span class="text">Create</span>
              </button>
            </div>
          </div>
        </form>
      </div>
    {/if}

    <div class="col-lg-9 col-xl-9 order-1 order-md-2">
      <div class="d-flex align-items-center justify-content-between mb-25">
        <h2 class="mnb-2" id="formBase">Available Office Branches</h2>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">City</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            {#each officeBranches as officeBranch, idx}
              <tr>
                <td>{idx + 1}</td>
                <td>{officeBranch.city}</td>
                <td class="d-flex justify-content-between align-content-center">
                  {#if auth.user.isSuperAdmin}
                      <!-- <button
                      type="button"
                      class="btn btn-danger btn-xs"
                      on:click={() => {
                        deleteOfficeBranch(officeBranch.id);
                      }}>
                      DELETE
                    </button> -->
                    <button
                      type="button"
                      class="btn btn-warning btn-xs"
                      data-toggle="modal"
                      data-target="#updateOfficeBranch"
                      on:click={() => {
                        details = officeBranch;
                      }}>
                      EDIT
                    </button>
                  {/if}
                  <InertiaLink
                    href={route(auth.user.user_type + '.office_branches.view_products', officeBranch.id)}
                    class="btn btn-primary btn-xs text-nowrap">
                    PRODUCTS ({officeBranch.products_count})
                  </InertiaLink>
                  {#if auth.user.isSuperAdmin || auth.user.isAuditor}
                    <InertiaLink
                      href={route(auth.user.user_type + '.office_branches.sales_records', officeBranch.id)}
                      class="btn btn-secondary btn-xs text-nowrap">
                      SALES RECORDS ({officeBranch.product_sales_records_count}/{officeBranch.product_sales_records_count})
                    </InertiaLink>
                    <InertiaLink
                      href={route(auth.user.user_type + '.office_branches.res_prod', officeBranch.id)}
                      class="btn btn-outline-primary btn-xs text-nowrap">
                      Products with Resellers
                    </InertiaLink>
                    <InertiaLink
                      href={route(auth.user.user_type + '.office_branches.prod_expenses', officeBranch.id)}
                      class="btn btn-outline-dark btn-xs text-nowrap">
                      Product Expenses
                    </InertiaLink>
                  {/if}
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
    <Modal modalId="updateOfficeBranch" modalTitle="Update Office Branch">
      <form
        id="updateOfficeBranchForm"
        on:submit|preventDefault={updateOfficeBranch}>

        <div class="row vertical-gap sm-gap">
          <div class="col-12">
            <label for="city">Branch City</label>
            <input
              type="text"
              class="form-control"
              id="city"
              placeholder="Branch Designated City"
              bind:value={details.city} />
          </div>
          <div class="col-12">
            <label for="country">Country</label>
            <input
              type="text"
              class="form-control"
              id="country"
              placeholder="Country"
              bind:value={details.country} />
          </div>
        </div>
      </form>
      <button
        type="submit"
        form="updateOfficeBranchForm"
        class="btn btn-success btn-long"
        disabled={!details.city || !details.country}>
        <span class="text">Update</span>
      </button>
    </Modal>
  </div>
</Layout>
