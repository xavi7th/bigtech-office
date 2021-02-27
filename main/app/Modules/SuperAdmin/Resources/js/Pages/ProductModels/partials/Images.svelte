<script context="module">

  export function addImage(id, img, userType) {
    BlockToast.fire({
      text: "Uploading image ..."
    });
    let formData = new FormData();

    formData.append("img", img);

    Inertia.post(
      route(userType + ".multiaccess.product_models.create_model_image", id),
      formData,
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "productModel"],
        headers: {
          "Content-Type": "multipart/form-data"
        }
      }
    )
  }
</script>

<script>
  import { Inertia } from "@inertiajs/inertia";
  import { page } from "@inertiajs/inertia-svelte";

  let deleteModelImage = id => {
      swalPreconfirm
        .fire({
          text: "This image will be permanently deleted",
          confirmButtonText: "Yes, carry on!",
          preConfirm: () => {
          return Inertia.delete(
            route($page.props.auth.user.user_type + ".multiaccess.product_models.delete_model_image", id),
            {
              preserveState: true,
              preserveScroll: true,
              only: ["flash", "errors", "productModel"]
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

  export let images;
</script>

<style lang="scss">
  .model-img {
    position: relative;
    .btn-delete {
      position: absolute;
      top: 8px;
      right: 0;
      z-index: 1;
    }
  }
</style>

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
<ul class="list-group list-group-flush rui-profile-activity-list">
  <li class="list-group-item">
    <div class="media media-success media-retiring">
      <div class="media-content">
        <div class="row vertical-gap sm-gap rui-gallery">
          {#each images as img}
            <div class="col-6 col-md-3 col-lg-2 model-img">
              <a
                href={img.img_url}
                data-fancybox="images"
                class="rui-gallery-item">
                <span
                  class="rui-gallery-item-overlay rui-gallery-item-overlay-md">
                  <span
                    data-feather="maximize"
                    class="rui-icon rui-icon-stroke-1_5" />
                </span>
                <img src={img.thumb_url} class="rui-img" alt="" />
              </a>
              <button
                type="button"
                on:click|stopPropagation|capture={() => {
                  deleteModelImage(img.id);
                }}
                class="btn btn-danger btn-uniform btn-round btn-delete btn-sm">
                <span data-feather="x" class="rui-icon rui-icon-stroke-1_5" />

              </button>
            </div>
          {:else}NO IMAGE{/each}
        </div>
      </div>
      <a href="#home" class="media-icon">
        <span data-feather="x" class="rui-icon rui-icon-stroke-1_5" />
      </a>
    </div>
  </li>
</ul>
<button class="btn btn-brand" data-toggle="modal" data-target="#addImage">
  Add New Image
</button>
