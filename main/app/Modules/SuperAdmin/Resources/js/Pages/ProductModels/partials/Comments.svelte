<script context="module">
  export function createModelComment(id, comment) {
    BlockToast.fire({
      text: "Creating comment ..."
    });

    Inertia.post(
      route(auth.user.user_type + ".multiaccess.product_models.comment_on_model", id),
      { comment },
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "productModel"]
      }
    );
  }
</script>

<script>
  import { Inertia } from "@inertiajs/inertia";
  import { createEventDispatcher } from "svelte";

  const dispatch = createEventDispatcher();

  let viewComment = comment => {
    dispatch("view-comment", comment);
  };

  export let comments = [];

  let trunc = str => {
    return _.truncate(str, { length: 100, separator: /,? +/ });
  };
</script>

<div class="rui-timeline rui-timeline-left-lg">
  <div class="rui-timeline-line" />

  {#each comments as comment, idx}
    <div class="rui-timeline-item" class:rui-timeline-item-swap={idx % 2 !== 0}>
      <div class="rui-timeline-icon">
        <span
          data-feather="check-circle"
          class="rui-icon rui-icon-stroke-1_5" />
      </div>
      <div class="rui-timeline-content">
        <h3>{comment.user}</h3>
        <p>{trunc(comment.comment)}</p>
        <button
          type="button"
          class="btn btn-brand"
          data-toggle="modal"
          data-target="#viewComment"
          on:click={() => {
            viewComment(comment.comment);
          }}>
          Read More
        </button>
      </div>
      <div class="rui-timeline-date">{comment.date}</div>
    </div>
  {:else}
    <div class="rui-timeline-item" class:rui-timeline-item-swap={idx % 2 == 0}>
      <div class="rui-timeline-icon">
        <span
          data-feather="check-circle"
          class="rui-icon rui-icon-stroke-1_5" />
      </div>
      <div class="rui-timeline-content">
        <h3>NO COMMENTS AVAILABLE.</h3>

      </div>
      <div class="rui-timeline-date"></div>
    </div>
  {/each}
  <button
    type="button"
    class="btn btn-success btn-long mt-10"
    data-toggle="modal"
    data-target="#createComment">
    Add Comment
  </button>
</div>
