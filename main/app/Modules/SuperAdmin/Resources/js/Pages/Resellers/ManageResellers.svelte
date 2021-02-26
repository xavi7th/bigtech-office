<script>
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import { page } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Modal from "@superadmin-shared/Partials/Modal";

  $: ({ auth } = $page.props);

  let details = {},
    currentReseller = {},
    files;

  let createReseller = () => {
    BlockToast.fire({
      text: "Creating reseller ..."
    });

    let formData = new FormData();

    // formData.append("_method", "PUT");
    _.forEach(details, (val, key) => {
      formData.append(key, val);
    });

    Inertia.post(route("superadmin.resellers.create_reseller"), formData, {
      preserveState: true,
      preserveScroll: true,
      only: ["flash", "errors", "resellers"],
      onSuccess: () =>{
          details = {};
      },
      headers: {
        "Content-Type": "multipart/form-data"
      }
    })
  };

  let updateReseller = () => {
    BlockToast.fire({
      text: "Updating reseller ..."
    });

    currentReseller._method = 'PUT';

    Inertia.post(
      route("superadmin.resellers.edit_reseller", currentReseller.id),
      {...currentReseller},
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "resellers"],
        onSuccess: () =>{
          currentReseller = {};
        }
      }
    )
  };

  let deleteReseller = id => {
      swalPreconfirm
        .fire({
          text:
          "This reseller will be permanently deleted and products can no longer be created under it",
          confirmButtonText: "Yes, carry on!",
          preConfirm: () => {
            return Inertia.delete(
              route("superadmin.resellers.delete_reseller", id),
              {
                preserveState: true,
                preserveScroll: true,
                only: ["flash", "errors", "resellers"]
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

  export let resellers = [];
</script>

<style>
  img {
    max-height: 100px;
  }
</style>

<Layout title="Manage Resellers">
  <div class="row vertical-gap">
    {#if auth.user.isSuperAdmin}
      <div class="col-lg-4 col-xl-4">
        <form class="#" on:submit|preventDefault={createReseller}>

          <div class="row vertical-gap sm-gap">
            <div class="col-12">
              <label for="name">Business Name</label>
              <input
                type="text"
                class="form-control"
                placeholder="Business Name"
                bind:value={details.business_name} />
            </div>

            <div class="col-12">
              <label for="name">CEO</label>
              <input
                type="text"
                class="form-control"
                placeholder="CEO Name"
                bind:value={details.ceo_name} />
            </div>

            <div class="col-12">
              <label for="email">Office Email</label>
              <input
                type="text"
                class="form-control"
                placeholder="Office Email"
                bind:value={details.email} />
            </div>

            <div class="col-12">
              <label for="name">Office Phone</label>
              <input
                type="text"
                class="form-control"
                placeholder="Office Phone"
                bind:value={details.phone} />
            </div>

            <div class="col-12">
              <label for="name">Office Address</label>
              <input
                type="text"
                class="form-control"
                placeholder="Office Address"
                bind:value={details.address} />
            </div>

            <div class="col-12">
              <label for="name">Business Logo</label>
              <input
                type="file"
                class="form-control"
                placeholder="Business Logo"
                bind:files
                on:change={() => (details.img = files[0])} />
            </div>

            <div class="col-12">
              <button
                type="submit"
                class="btn btn-success btn-long"
                disabled={!details.business_name}>
                <span class="text">Create</span>
              </button>
            </div>
          </div>
        </form>
      </div>
    {/if}
    <div class="col-lg-8 col-xl-8">
      <div class="d-flex align-items-center justify-content-between mb-25">
        <h2 class="mnb-2" id="formBase">Available Resellers</h2>
      </div>
      <div class="table-responsive">
        <!-- svelte-ignore missing-declaration -->
        <table class="table table-bordered" use:initialiseDatatable>
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Business Name</th>
              <th scope="col">CEO</th>
              <th scope="col">Address</th>
              <th scope="col">Phone</th>
              <th scope="col">Email</th>
              {#if auth.user.isSuperAdmin}
                <th scope="col">Action</th>
              {/if}
            </tr>
          </thead>
          <tbody>
            {#each resellers as reseller}
              <tr>
                <td>{reseller.id}</td>
                <td>
                  <img
                    src={reseller.img_url}
                    alt="{reseller.business_name}'s Logo'"
                    class="img-fluid" />
                  {reseller.business_name}
                </td>
                <td>{reseller.ceo_name}</td>
                <td>{reseller.address}</td>
                <td>{reseller.phone}</td>
                <td>{reseller.email}</td>
                {#if auth.user.isSuperAdmin}
                  <td
                    class="d-flex justify-content-between align-content-center">
                    <!-- <button
                    type="button"
                    class="btn btn-danger btn-xs"
                    on:click={() => {
                      deleteReseller(reseller.id);
                    }}>
                    DELETE
                  </button> -->
                    <button
                      type="button"
                      class="btn btn-warning btn-xs"
                      data-toggle="modal"
                      data-target="#updateReseller"
                      on:click={() => {
                        currentReseller = reseller;
                      }}>
                      EDIT
                    </button>
                  </td>
                {/if}
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
    <Modal modalId="updateReseller" modalTitle="Update Reseller">

      <div class="row vertical-gap sm-gap">
        <div class="col-12">
          <label for="name">Business Name</label>
          <input
            type="text"
            class="form-control"
            placeholder="Business Name"
            bind:value={currentReseller.business_name} />
        </div>

        <div class="col-12">
          <label for="name">CEO</label>
          <input
            type="text"
            class="form-control"
            placeholder="CEO Name"
            bind:value={currentReseller.ceo_name} />
        </div>

        <div class="col-12">
          <label for="name">Office Phone</label>
          <input
            type="text"
            class="form-control"
            placeholder="Office Phone"
            bind:value={currentReseller.phone} />
        </div>

        <div class="col-12">
          <label for="email">Office Email</label>
          <input
            type="text"
            class="form-control"
            placeholder="Office Email"
            bind:value={currentReseller.email} />
        </div>

        <div class="col-12">
          <label for="name">Office Address</label>
          <input
            type="text"
            class="form-control"
            placeholder="Office Address"
            bind:value={currentReseller.address} />
        </div>

        <div class="col-12">
          <label for="name">Business Logo</label>
          <input
            type="file"
            class="form-control"
            placeholder="Business Logo"
            bind:files
            on:change={currentReseller.img = files[0]} />
        </div>
      </div>
      <button
        on:click={updateReseller}
        slot="footer-buttons"
        class="btn btn-success btn-long">
        <span class="text">Update</span>
      </button>
    </Modal>
  </div>
</Layout>
