<script>
  import { Inertia } from "@inertiajs/inertia";
	import { page } from '@inertiajs/inertia-svelte'


  export let qaTests,
    productQaTests = [],
    productModelId;

  let selectedTest = {},
    isQaTestsModified = false;
  $: selectedQaTests = _.map(productQaTests, function(val) {
    return val.id;
  });

  let addToTests = () => {
    isQaTestsModified = true;
    let newTest = { ...selectedTest, isUnsaved: true };
    productQaTests = [...productQaTests, newTest];
  };

  let removeFromTests = qaTest => {
    productQaTests = [..._.pullAllWith(productQaTests, [qaTest], _.isEqual)];
    isQaTestsModified = true;
  };

  let updateTests = () => {
    swal
      .fire({
        title: "Are you sure?",
        text:
          "This will update the QA tests required for products of this model",
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
          return Inertia.put(
            route(
              $page.props.auth.user.user_type + ".multiaccess.product_models.update_model_qa_tests",
              productModelId
            ),
            {
              qa_tests: selectedQaTests
            },
            {
              preserveState: true,
              preserveScroll: true,
              only: ["flash", "errors", "productModel"],
              onSuccess: () =>{
                isQaTestsModified = false;
              },
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
</script>

<style>
  img {
    max-height: 150px;
    object-fit: cover;
    object-position: center;
  }
</style>

<form action="#">
  <div class="row vertical-gap">
    <div class="col-12 col-lg-3">
      <div class="card">
        <img src="/img/qa-test-banner.jpg" class="card-img-top" alt="" />
        <div class="card-body pt-20 pr-10 pb-20 pl-10">
          <h3 class="card-title h2">Recomended Tests</h3>
          <ul class="nav flex-column mnt-3">
            {#each productQaTests as qaTest}
              <li>
                <p
                  class="m-0 pb-0 nav-link active d-flex justify-content-between
                  align-items-center">
                  <span class:text-danger={qaTest.isUnsaved}>
                    {qaTest.name}
                  </span>
                  <button
                    on:click={() => removeFromTests(qaTest)}
                    type="button"
                    class="btn btn-danger btn-uniform btn-round btn-sm
                    text-light">
                    <span class="fa fa-minus rui-icon rui-icon-stroke-1_5" />
                  </button>
                </p>
              </li>
            {:else}
              <li>
                <p class="nav-link">
                  <span
                    data-feather="user-check"
                    class="rui-icon rui-icon-stroke-1_5" />
                  <span>NO QA TESTS SPECIFIED</span>
                </p>
              </li>
            {/each}
          </ul>

          {#if isQaTestsModified}
            <div class="col-auto mt-15">
              <button
                class="btn btn-danger btn-sm"
                type="button"
                on:click={updateTests}>
                Update Model Tests
              </button>
            </div>
          {/if}

        </div>
      </div>
    </div>
    <div class="col-12 col-lg-6">
      <div class="card">
        <div class="card-body">
          <div class="row vertical-gap sm-gap justify-content-end">

            <div class="col-12">
              <label for="model-brand">Model Brand</label>
              <div class="input-group">
                <select
                  id="model-brand"
                  class="custom-select text-capitalize"
                  bind:value={selectedTest}>
                  <option selected value={null}>Select</option>
                  {#each qaTests as test}
                    <option value={test}>{test.name}</option>
                  {/each}
                </select>
              </div>
            </div>

            <div class="col-auto">
              <button class="btn btn-brand" type="button" on:click={addToTests}>
                Add to tests
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
