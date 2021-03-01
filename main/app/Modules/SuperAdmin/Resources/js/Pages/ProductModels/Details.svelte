<script>
  import { page } from "@inertiajs/inertia-svelte";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import Modal from "@superadmin-shared/Partials/Modal.svelte";
  import Images, { addImage } from "./partials/Images.svelte";
  import Comments, { createModelComment } from "./partials/Comments.svelte";
  import QaTests from "./partials/QATests.svelte";
  import DescriptionSummary, { createModelDescription, updateModelDescription } from "./partials/DescriptionSummary.svelte";
  import ModelSummary from "./partials/ModelSummary.svelte";
  import { onMount } from "svelte";

  export let description, files, comment;

  $: ({ auth } = $page.props);

  export let productModel = {
      images: [],
      qaTests: []
    },
    qaTests;

  onMount(() => {
    description = productModel.descriptionSummary;
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
      {#if auth.user.isWebAdmin || auth.user.isAuditor}
         <DescriptionSummary
        descriptionSummary={productModel.descriptionSummary}
        descriptionSummaryUpdated={productModel.descriptionSummaryUpdated} />
      {/if}
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
        {#if auth.user.isAuditor || auth.user.isSuperAdmin || auth.user.isWebAdmin}
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
        {/if}
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
        {#if auth.user.isAuditor || auth.user.isSuperAdmin || auth.user.isWebAdmin}
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
        {/if}
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
          createModelComment(productModel.id, comment, auth.user.user_type);
        }}>
        Add Comment
      </button>
    </Modal>

    <Modal modalId="addImage" modalTitle="Add Image to Product Model">
      <input type="file" bind:files accept="image/*" />
      <button
        slot="footer-buttons"
        disabled={!files}
        class="btn btn-brand"
        on:click={() => {
          addImage(productModel.id, files[0], auth.user.user_type);
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

      <span slot="footer-buttons">
        {#if !productModel.descriptionSummaryUpdated}
          <button
            class="btn btn-brand"
            on:click={() => {
              createModelDescription(productModel.id, description, auth.user.user_type);
            }}>
            Add Description
          </button>
        {:else}
          <button
            class="btn btn-warning"
            on:click={() => {
              updateModelDescription(productModel.id, description, auth.user.user_type);
            }}>
            Update Description
          </button>
        {/if}
      </span>
    </Modal>
  </div>
</Layout>
