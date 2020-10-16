<script context="module">
  export function createModelDescription(id, desc) {
    BlockToast.fire({
      text: "Adding description to product model ..."
    });

    Inertia.post(
      route("multiaccess.product_descriptions.create_product_desc"),
      {
        description_summary: desc,
        product_model_id: id
      },
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "productModel"],
        headers: {
          "Content-Type": "multipart/form-data"
        }
      }
    );
  }

  export function updateModelDescription(id, desc) {
    BlockToast.fire({
      text: "Updating description ..."
    });

    Inertia.put(
      route("multiaccess.product_descriptions.edit_product_desc", id),
      {
        description_summary: desc
        // product_model_id: id
      },
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "productModel"],
        headers: {
          "Content-Type": "multipart/form-data"
        }
      }
    );
  }
</script>

<script>
  import { Inertia } from "@inertiajs/inertia";

  export let descriptionSummary, descriptionSummaryUpdated;
</script>

<!--
@component
Here's some documentation for this component.
It will show up on hover.

- You can use markdown here.
- You can also use code blocks here.
- Usage:
  ```tsx
  <main name="Arethra">
  ```
-->
<div class="card">
  <div class="card-body">
    <div class="d-flex align-items-center">
      <h2 class="card-title mnb-6 mr-auto">Description Summary</h2>
      {#if descriptionSummary}
        <button
          class="btn btn-custom-round mr-20"
          data-toggle="modal"
          data-target="#createDescription">
          <span data-feather="link-2" class="rui-icon rui-icon-stroke-1_5" />
        </button>
      {:else}
        <button
          class="btn btn-brand btn-uniform btn-round btn-sm mnt-8 mnb-8"
          data-toggle="modal"
          data-target="#createDescription">
          <span data-feather="plus" class="rui-icon rui-icon-stroke-1_5" />
        </button>
      {/if}
    </div>
    <ul class="list-group list-group-flush rui-profile-task-list">
      <li class="list-group-item">
        <div class="rui-task rui-task-success">
          <div class="rui-task-icon">
            <span
              data-feather="alert-circle"
              class="rui-icon rui-icon-stroke-1_5" />
          </div>
          <div class="rui-task-content">
            <p class="rui-task-title">
              {@html descriptionSummary}
            </p>
            <small class="rui-task-subtitle">
              Last updated {descriptionSummaryUpdated}
            </small>
          </div>
        </div>
      </li>

    </ul>
  </div>
</div>
