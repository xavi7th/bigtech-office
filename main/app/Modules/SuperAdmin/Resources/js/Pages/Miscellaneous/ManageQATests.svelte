<script>
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import { page } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Modal from "@superadmin-shared/Partials/Modal";

  $: ({ auth } = $page.props);

  let qaTestName, qaTestId;

  let createQaTest = () => {
    BlockToast.fire({
      text: "Creating QA test ..."
    });

    Inertia.post(
      route(auth.user.user_type + ".multiaccess.miscellaneous.create_qa_test"),
      {
        name: qaTestName
      },
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "qaTests"],
        onSuccess: () =>{
          qaTestName = null;
        },
      }
    )
  };

  let updateQaTest = () => {
    BlockToast.fire({
      text: "Updating QA test ..."
    });

    Inertia.put(
      route(auth.user.user_type + ".multiaccess.miscellaneous.edit_qa_test", qaTestId),
      {
        name: qaTestName
      },
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "qaTests"],
         onSuccess: () =>{
          qaTestName = null;
        },
      }
    )
  };

  let deleteQaTest = id => {
      swalPreconfirm
        .fire({
           text:
          "This QA test will be permanently deleted and products can no longer be created under it",
          confirmButtonText: "Yes, carry on!",
          preConfirm: () => {
            return Inertia.delete(
              route(auth.user.user_type + ".multiaccess.miscellaneous.delete_qa_test", id),
              {
                preserveState: true,
                preserveScroll: true,
                only: ["flash", "errors", "qaTests"]
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

  export let qaTests = [];
</script>

<Layout title="Manage QA Tests">
  <div class="row vertical-gap">
    <div class="col-lg-4 col-xl-4">

      <form class="#" on:submit|preventDefault={createQaTest}>

        <div class="row vertical-gap sm-gap">
          <div class="col-12">
            <label for="name">Enter New QA Test</label>
            <input
              type="text"
              class="form-control"
              id="name"
              placeholder="QA Test Name"
              bind:value={qaTestName} />
          </div>

          <div class="col-12">
            <button
              type="submit"
              class="btn btn-success btn-long"
              disabled={!qaTestName}>
              <span class="text">Create</span>
            </button>
          </div>
        </div>
      </form>
    </div>
    <div class="col-lg-8 col-xl-8">
      <div class="d-flex align-items-center justify-content-between mb-25">
        <h2 class="mnb-2" id="formBase">Available QA Tests</h2>
      </div>
      <div class="table-responsive-md">
        <table
          class="rui-datatable table table-striped table-bordered table-sm
          table-hover">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            {#each qaTests as qaTest, idx}
              <tr>
                <td>{idx + 1}</td>
                <td>{qaTest.name}</td>
                <td class="d-flex justify-content-between align-content-center">
                  <!-- <button
                    type="button"
                    class="btn btn-danger btn-xs"
                    on:click={() => {
                      deleteQaTest(qaTest.id);
                    }}>
                    DELETE
                  </button> -->
                  <button
                    type="button"
                    class="btn btn-warning btn-xs"
                    data-toggle="modal"
                    data-target="#updateQaTest"
                    on:click={() => {
                      qaTestName = qaTest.name;
                      qaTestId = qaTest.id;
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
    <Modal modalId="updateQaTest" modalTitle="Update QA Test">
      <form class="#" on:submit|preventDefault={updateQaTest}>

        <div class="row vertical-gap sm-gap">
          <div class="col-12">
            <label for="name">Change QA Test</label>
            <input
              type="text"
              class="form-control"
              id="name"
              placeholder="QA Test Name"
              bind:value={qaTestName} />
          </div>

          <div class="col-12">
            <button
              type="submit"
              class="btn btn-success btn-long"
              disabled={!qaTestName}>
              <span class="text">Update</span>
            </button>
          </div>
        </div>
      </form>
    </Modal>
  </div>
</Layout>
