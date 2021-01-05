<script>
import { Inertia } from "@inertiajs/inertia";
import { page } from "@inertiajs/inertia-svelte";

  export let comments = [];

  let deleteComment = comment => {
    swal
      .fire({
        title: "Are you sure?",
        text:
          "This will delete this comment completely",
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

          return Inertia.delete(
            route("superadmin.user_comments.delete", comment.id),
            {
              preserveState: true,
              preserveScroll: true,
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

<div>
  <ul class="list-group list-group-flush rui-profile-activity-list">
    {#each comments as comment}
      <li class="list-group-item">
        <div class="media media-success media-retiring">
          <p class="media-link">
            <span class="media-body">
              <span class="media-title"> {comment.comment} </span>
              <small class="media-subtitle">{comment.user}</small>
              <span class="media-time">{comment.date}</span>
            </span>
           {#if $page.props.auth.user.isSuperAdmin}
              <button
              class="btn btn-danger btn-xs"
              on:click={() => {
                deleteComment(comment);
              }}>DELETE</button>
           {/if}
          </p>
        </div>
      </li>
    {:else}
      <li class="list-group-item">
        <div class="media media-success media-retiring">
          <p class="media-link">
            <span class="media-body">
              <span class="media-title">NO COMMENTS</span>
            </span>
          </p>
        </div>
      </li>
    {/each}
  </ul>
</div>
