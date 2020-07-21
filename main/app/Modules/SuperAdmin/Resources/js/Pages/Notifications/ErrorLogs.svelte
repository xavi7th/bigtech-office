<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import FlashMessage from "@user-shared/FlashMessage";
  import route from "ziggy";

  let details = {};

  $: ({ app } = $page);
</script>

<Layout title="Error Logs">

  <div class="row vertical-gap">
    <div class="col-12">
      <div class="table-responsive">
        <table class="table table-bordered rui-datatable" data-order="[]">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Errors</th>
            </tr>
          </thead>
          <tbody class="list-group list-group-flush m-0 rui-project-task-list">
            <tr class="list-group-item p-0">
              <td class="rui-task rui-task-danger">
                <div class="rui-task-icon">
                  <span class="fa fa-history mr-10" />
                  2020-07-21 16:53:44
                </div>
                <div class="rui-task-content">
                  <b class="rui-task-title">
                    404: https://smartcoophq.org/robots.txt "url":
                    "https:\/\/smartcoophq.org\/robots.txt", "method": "GET",
                    "data": []
                  </b>
                  <small class="rui-task-subtitle">
                    <strong>Error Type:</strong>
                    DEBUG
                  </small>
                </div>
              </td>
            </tr>
            <tr class="list-group-item p-0">
              <td class="rui-task rui-task-danger">
                <div class="rui-task-icon">
                  <span class="fa fa-history mr-10" />
                  2020-07-21 12:55:42
                </div>
                <div class="rui-task-content">
                  <b class="rui-task-title">
                    Prof. Jasen Funk V has no default card to auto deduct
                  </b>
                  <small class="rui-task-subtitle">
                    <strong>Error Type:</strong>
                    Notice
                  </small>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</Layout>
