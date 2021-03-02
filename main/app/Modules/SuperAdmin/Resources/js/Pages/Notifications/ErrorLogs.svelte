<script>
  import { Inertia } from "@inertiajs/inertia";
  import Modal from "@superadmin-shared/Partials/Modal.svelte";
  import Layout from "@superadmin-shared/SuperAdminLayout";
	import { page } from '@inertiajs/inertia-svelte'

  $: ({ auth } = $page.props);

  export let errLogs = [];
  let fullErrorMessage;

  let pruneErrLogs = product => {
    swalPreconfirm
      .fire({
        text: "This will delete all old error logs",
        confirmButtonText: "Delete",
        preConfirm: () => {
          Inertia.delete(route(auth.user.user_type + ".logs.prune"), {
            preserveState: true,
            preserveScroll: true,
            only: ["flash", "errors", "errLogs"]
          })
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
</script>

<style>
  textarea {
    width: 100%;
    height: 400px;
  }
</style>

<Layout title="Error Logs">
  <div class="row vertical-gap">
    <div class="col-12">
      <div class="table-responsive">
        <!-- svelte-ignore missing-declaration -->
        <table class="table table-bordered rui-datatable" data-order="[]" use:initialiseDatatable>
          <thead class="thead-dark">
            <tr>
              <th scope="col">
                Errors <button type="button" on:click={pruneErrLogs} class="btn
                    btn-danger btn-xs ml-50"> Prune Logs </button>
              </th>
            </tr>
          </thead>
          <tbody class="list-group list-group-flush m-0 rui-project-task-list">
            {#each errLogs as log}
              <tr class="list-group-item p-0">
                <td class="rui-task rui-task-danger">
                  <div class="rui-task-icon">
                    <span class="fa fa-history mr-10" />
                    {log.time}
                  </div>
                  <div class="rui-task-content">
                    <b class="rui-task-title">
                      {log.message || 'No User friendly Description'}
                      <button
                        type="button"
                        on:click={() => {
                          fullErrorMessage = log.context;
                        }}
                        data-toggle="modal"
                        data-target="#enterSalesDetails"
                        class="btn btn-danger btn-xs btn-sm">
                        View Details
                      </button></b>
                    <small class="rui-task-subtitle">
                      <strong>Error Type:</strong> DEBUG
                    </small>
                  </div>
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
          {#if fullErrorMessage}
            <textarea readonly>{JSON.parse(fullErrorMessage)}</textarea>
          {/if}
        </div>
      </div>
    </Modal>

    Object.entries(cats) as as [cat_name, cat_number], index
  </div>
</Layout>
