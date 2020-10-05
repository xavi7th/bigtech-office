<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import Modal from "@superadmin-shared/Partials/Modal";
  import FlashMessage from "@usershared/FlashMessage";
  import Images, { addImage } from "./partials/Images";
  import Comments, { createModelComment } from "./partials/Comments";
  import QaTests from "./partials/QATests.svelte";
  import DescriptionSummary, {
    createModelDescription,
    updateModelDescription
  } from "./partials/DescriptionSummary";
  import ModelSummary from "./partials/ModelSummary";
  import route from "ziggy";
  import { onMount, afterUpdate } from "svelte";

  export let description, files, comment;

  $: ({ app, flash, errors } = $page);

  export let productModel = {
      images: [],
      qaTests: []
    },
    qaTests;

  onMount(() => {
    description = productModel.descriptionSummary;
  });

  afterUpdate(() => {
    console.log(flash);
    if (flash.success) {
      Toast.fire({
        title: "Successful!",
        text: flash.success
      }).then(() => {
        description = null;
        comment = null;
        flash.success = null;
      });
    } else if (flash.error) {
      ToastLarge.fire({
        title: "Oops!",
        html: flash.error,
        icon: "error"
      }).then(() => {
        flash.error = null;
      });
    } else if (_.size(errors) > 0) {
      if (_.isString(errors)) {
        var errs = errors;
      } else if (_.size(errors) == 1) {
        var errs = _.reduce(errors, function(val, n) {
          return val.join("<br>") + "<br>" + n;
        })[0];
      } else {
        var errs = _.reduce(errors, function(val, n) {
          return (_.isString(val) ? val : val.join("<br>")) + "<br>" + n;
        });
      }
      console.log(errs);
      ToastLarge.fire({
        title: "Oops",
        html: errs,
        icon: "error"
      });
    } else {
      swal.close();
    }
  });

  let activeComment;

  let updateComment = evt => {
    activeComment = evt.detail;
  };
</script>

<Layout title="Product Models">
  <div class="rui-profile row vertical-gap">
    <div class="col-lg-6 col-xl-5">
      <ModelSummary
        name={productModel.name}
        imgUrl={productModel.img_url}
        category={productModel.category}
        brand={productModel.brand} />
    </div>
    <div class="col-lg-6 col-xl-7">
      <DescriptionSummary
        descriptionSummary={productModel.descriptionSummary}
        descriptionSummaryUpdated={productModel.descriptionSummaryUpdated} />
    </div>
    <div class="col-12">
      <ul class="nav nav-tabs rui-tabs-sliding" role="tablist">
        <li class="nav-item">
          <a
            class="nav-link rui-tabs-link active"
            id="activity-tab"
            data-toggle="tab"
            href="#activity"
            role="tab"
            aria-controls="activity"
            aria-selected="true">
            Images
          </a>
        </li>
        <li class="nav-item">
          <a
            class="nav-link rui-tabs-link"
            id="timeline-tab"
            data-toggle="tab"
            href="#timeline"
            role="tab"
            aria-controls="timeline"
            aria-selected="false">
            Comments
          </a>
        </li>
        <li class="nav-item">
          <a
            class="nav-link rui-tabs-link"
            id="settings-tab"
            data-toggle="tab"
            href="#settings"
            role="tab"
            aria-controls="settings"
            aria-selected="false">
            QA Tests
          </a>
        </li>
      </ul>
      <div class="tab-content">
        <div
          class="tab-pane fade show active"
          id="activity"
          role="tabpanel"
          aria-labelledby="activity-tab">

          <Images images={productModel.images} />

        </div>
        <div
          class="tab-pane fade"
          id="timeline"
          role="tabpanel"
          aria-labelledby="timeline-tab">

          <Comments
            comments={productModel.comments}
            on:view-comment={updateComment} />

        </div>
        <div
          class="tab-pane fade"
          id="settings"
          role="tabpanel"
          aria-labelledby="settings-tab">

          <QaTests
            {qaTests}
            productModelId={productModel.id}
            productQaTests={productModel.qaTests} />

        </div>
      </div>
    </div>
  </div>
  <div slot="modals">
    <Modal modalId="viewComment" modalTitle="">
      <div class="card">
        <div class="card-body">
          <p class="card-text">{activeComment}</p>
        </div>
      </div>
    </Modal>
    <Modal
      modalId="createComment"
      modalTitle="Add a comment to this Product Model">
      <textarea
        name="createComment"
        cols="30"
        rows="10"
        class="form-control"
        bind:value={comment} />

      <button
        class="btn btn-brand"
        slot="footer-buttons"
        on:click={() => {
          createModelComment(productModel.id, comment);
        }}>
        Add Description
      </button>
    </Modal>
    <Modal modalId="addImage" modalTitle="Add Image to Product Model">
      <input type="file" bind:files accept="image/*" />
      <button
        slot="footer-buttons"
        disabled={!files}
        class="btn btn-brand"
        on:click={() => {
          addImage(productModel.id, files[0]);
        }}>
        Add Image
      </button>
    </Modal>
    <Modal
      modalId="createDescription"
      modalTitle="Add Description to Product Model">
      <textarea
        name="createDescription"
        cols="30"
        rows="10"
        class="form-control"
        bind:value={description} />

      <button
        class="btn btn-brand"
        slot="footer-buttons"
        on:click={() => {
          createModelDescription(productModel.id, description);
        }}>
        Add Description
      </button>

      <button
        class="btn btn-warning"
        slot="footer-buttons"
        on:click={() => {
          updateModelDescription(productModel.id, description);
        }}>
        Update Description
      </button>
    </Modal>
  </div>
</Layout>
