<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import FlashMessage from "@usershared/FlashMessage";
  import route from "ziggy";
  import { getErrorString } from "@public-assets/js/bootstrap";

  $: ({ app, errors, flash } = $page);

  export let product = {},comments =[];

  let results = [], comment;

  let updateQATestResults = () => {
    /** ! Make sure the form was properly filled **/
    let parsedResults = [];

    BlockToast.fire({
      text: "Marking product as paid for ..."
    });

    _.each(results, (val, key, coll) => {
      parsedResults[key] = { is_qa_certified: results[key] };
    });

    Inertia.put(
      route("superadmin.products.update_qa_result", product.uuid),
      { qa_test_results: parsedResults },
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "product"]
      }
    ).then(() => {
      if (flash.success) {
        ToastLarge.fire({
          title: "Successful!",
          html: flash.success
        });

        parsedResults = [];
      } else if (flash.error || _.size(errors) > 0) {
        ToastLarge.fire({
          title: "Oops!",
          html: flash.error || getErrorString(errors),
          timer: 10000,
          icon: "error"
        });
      } else {
        swal.close();
      }
    });
  };

  let testResult = test => {
    try {
      return _.find(product.qa_tests, ["name", test]).is_qa_certified;
    } catch (error) {
      return null;
    }
  };
</script>

<style>
  select {
    min-width: 150px;
  }
</style>

<Layout title="Test Results">
  <div class="row vertical-gap">
    <div class="col-lg-12 col-xl-12">
      <ul class="nav nav-pills rui-tabs-sliding" role="tablist">
        <li class="nav-item">
          <a
            class="nav-link rui-tabs-link active"
            id="homePillsSliding-tab"
            data-toggle="pill"
            href="#homePillsSliding"
            role="tab"
            aria-controls="homePillsSliding"
            aria-selected="true">
            Device Test
          </a>
        </li>
        <li class="nav-item">
          <a
            class="nav-link rui-tabs-link"
            id="profilePillsSliding-tab"
            data-toggle="pill"
            href="#profilePillsSliding"
            role="tab"
            aria-controls="profilePillsSliding"
            aria-selected="false">
            Results / Comments
          </a>
        </li>
      </ul>
      <div class="tab-content">
        <div
          class="tab-pane fade show active"
          id="homePillsSliding"
          role="tabpanel"
          aria-labelledby="homePillsSliding-tab">
          <div class="row vertical-gap">
            <div class="col-12">
              <p class="lead">
                Select the results of each test type
              </p>
              <p class="lead text-danger">
              </p>
              <table class="table table-striped">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Test Type</th>
                    <th scope="col">Result</th>
                    <th scope="col">Test Score</th>
                  </tr>
                </thead>
                <tbody>
                  {#each product.valid_tests as test, idx}
                    <tr>
                      <th scope="row">{idx + 1}</th>
                      <td>
                        <strong>{test.name}</strong>
                      </td>
                      <td>

                        <select
                          class="custom-select "
                          bind:value={results[test.id]}>
                          <option
                            selected={testResult(test.name) == null}
                            value={null}>
                            Not Tested
                          </option>

                          <option
                            selected={testResult(test.name) == false}
                            value={false}>
                            Failed
                          </option>
                          <option
                            selected={testResult(test.name) == true}
                            value={true}>
                            Passed
                          </option>

                        </select>

                      </td>
                      <td>
                        <span class="fas {testResult(test.name) === true ? 'fa-check text-success' :'fas fa-exclamation text-warning' }" />
                      </td>
                    </tr>
                  {/each}
                </tbody>
              </table>
            </div>
            <div class="col-12">

              <button
                on:click={updateQATestResults}
                class="btn btn-success btn-long">
                <span class="text">Update Results</span>
              </button>
            </div>
          </div>
        </div>
        <div
          class="tab-pane fade"
          id="profilePillsSliding"
          role="tabpanel"
          aria-labelledby="profilePillsSliding-tab">
          <div class="row vertical-gap">
            <div class="col-lg-5">
              <div class="col-12">
                <div class="a" style="display: flex;">
                  <input
                    type="text"
                    class="form-control"
                    bind:value="{comment}"
                    placeholder="Enter Comment" />

                  <InertiaLink class="btn btn-brand ml-20 {!comment ? 'disabled' : ''}" aria-disabled="true" tabindex="-1" role="button" href="{route('superadmin.products.comment_on_qa_test', product.uuid)}" only="{['comments', 'flash', 'errors']}" preserve-scroll data="{ {comment} }" preserve-state replace  method="post" >Comment</InertiaLink>`
                </div>
              </div>
              <hr />
              <div
                class="tab-pane fade show active"
                id="activity"
                role="tabpanel"
                aria-labelledby="activity-tab">
                <ul
                  class="list-group list-group-flush rui-profile-activity-list">

                {#each comments as comment}
                    <li class="list-group-item">
                    <div class="media media-success media-retiring">

                      <a href class="media-link">
                        <span class="media-body">
                          <span class="media-title">
                            {comment.comment}
                          </span>
                          <small class="media-subtitle">
                            {comment.full_name} &nbsp; ({comment.department})
                            <span class="media-time">{comment.time}  &nbsp; ({comment.human_date})</span>
                          </small>
                        </span>
                      </a>
                    </div>
                  </li>
                {/each}

                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</Layout>
