<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import DisplayUserComments from "@superadmin-shared/Partials/DisplayUserComments.svelte";
  import UpdateProductStatus from "@superadmin-shared/Partials/UpdateProductStatus.svelte";

  $: ({ auth } = $page.props);

  export let product = {},
    comments = [],
    product_statuses = [];

  let results = [],
    comment,
    testResultUpdated = false;

  let updateQATestResults = () => {
    /** ! Make sure the form was properly filled **/
    let parsedResults = [];

    BlockToast.fire({
      text: "Updating test results ..."
    });

    _.each(results, (val, key, coll) => {
      parsedResults[key] = { is_qa_certified: results[key] };
    });

    Inertia.put(
      route("qualitycontrol.products.update_qa_result", product.uuid),
      { qa_test_results: parsedResults },
      {
        preserveState: false,
        preserveScroll: true,
        only: ["flash", "errors", "product"],
        onSuccess: () =>{
          parsedResults = [];
          comment = null;
        },
      }
    )
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
    text-transform: capitalize;
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
            <p class="lead col-12">Select the results of each test type</p>
            <div class="col-lg-9">
              <div class="table-responsive">
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
                        <td><strong>{test.name}</strong></td>
                        <td>
                          <select
                            class="custom-select"
                            on:blur={() => {
                              testResultUpdated = true;
                            }}
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
                          <span
                            class="fas {testResult(test.name) === true ? 'fa-check text-success' : 'fas fa-exclamation text-warning'}" />
                        </td>
                      </tr>
                    {/each}
                  </tbody>
                </table>
              </div>
            </div>
            <div class="col-lg-3">
              {#if auth.user.isQualityControl}
                {#if testResultUpdated}
                  <button
                    on:click={updateQATestResults}
                    class="btn btn-success btn-long">
                    <span class="text">Update Results</span>
                  </button>
                {:else}
                  <UpdateProductStatus {product} {product_statuses} />
                {/if}
              {/if}
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
                    bind:value={comment}
                    placeholder="Enter Comment" />

                  <InertiaLink
                    class="btn btn-brand ml-20 {!comment ? 'disabled' : ''}"
                    aria-disabled="true"
                    tabindex="-1"
                    role="button"
                    href={route('multiaccess.products.comment_on_qa_test', product.uuid)}
                    only={['comments', 'flash', 'errors']}
                    preserveScroll
                    data={{ comment }}
                    preserveState
                    replace
                    method="post">
                    Comment
                  </InertiaLink>
                  `
                </div>
              </div>
              <hr />
              <DisplayUserComments {comments} />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</Layout>
