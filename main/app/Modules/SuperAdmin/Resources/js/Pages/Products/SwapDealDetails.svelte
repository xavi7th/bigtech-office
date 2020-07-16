<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import FlashMessage from "@user-shared/FlashMessage";
  import route from "ziggy";

  $: ({ app } = $page);
</script>

<Layout title="Swap Device Details">
  <div class="row vertical-gap">
    <div class="col-lg-3">
      <a
        href="/img/iphone-11.png"
        data-fancybox="images"
        class="rui-gallery-item">
        <img src="/img/iphone-11.png" class="rui-img" alt="" />
      </a>
      <hr />
      <div class="row">
        <div class="col-12">
          <label for="updateSellingPrice">Selling price</label>
          <div class="a d-flex flex-wrap">
            <input
              type="text"
              class="form-control"
              id="updateSellingPrice"
              placeholder="Selling Price" />

            <label for="updateDescription">Description</label>
            <textarea
              name="updateDescription"
              id="updateDescription"
              class="form-control" />
            <button
              type="button"
              class="btn btn-brand btn-hover-primary btn-block mt-15">
              Update
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-5">
      <table class="table table-bordered">
        <thead class="thead-dark">
          <tr>
            <th scope="col" colspan="2">IPHONE 11</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-primary">
              <strong>Description</strong>
            </td>
            <th scope="row">
              <strong>Not Available</strong>
            </th>
          </tr>
          <tr>
            <td class="text-primary">
              <strong>Device ID</strong>
            </td>
            <th scope="row">
              <strong>Not Available</strong>
            </th>
          </tr>
          <tr>
            <td class="text-primary">
              <strong>Seller Details</strong>
            </td>
            <th scope="row">
              <strong>Not Available</strong>
            </th>
          </tr>
          <tr>
            <td class="text-primary">
              <strong>Seller ID</strong>
            </td>
            <th scope="row">
              <strong>Not Available</strong>
            </th>
          </tr>
          <tr>
            <td class="text-primary">
              <strong>Receipt</strong>
            </td>
            <th scope="row">
              <strong>Not Available</strong>
            </th>
          </tr>
          <tr>
            <td class="text-primary">
              <strong>Swap Value</strong>
            </td>
            <th scope="row">
              <strong>Not Available</strong>
            </th>
          </tr>
          <tr>
            <td class="text-primary">
              <strong>Selling Price</strong>
            </td>
            <th scope="row">
              <strong>Not Available</strong>
            </th>
          </tr>
          <tr>
            <td class="text-primary">
              <strong>Sold At</strong>
            </td>
            <th scope="row">
              <strong>Not Available</strong>
            </th>
          </tr>
          <tr>
            <td class="text-primary">
              <strong>Swapped With</strong>
            </td>
            <th scope="row">
              <strong>Not Available</strong>
            </th>
          </tr>

          <tr>
            <td class="text-primary">
              <strong>Status</strong>
            </td>
            <th scope="row">
              <strong>Not Available</strong>
            </th>
          </tr>

        </tbody>
      </table>
    </div>
    <div class="col-lg-4">
      <div class="col-12">
        <label for="exampleBase1">Comment on this device</label>
        <div class="a" style="display: flex;">
          <input
            type="text"
            class="form-control"
            id="exampleBase1"
            placeholder="Enter Comment" />
          <button
            type="button"
            style="margin-left: 20px;"
            class="btn btn-brand btn-hover-primary">
            Comment
          </button>
        </div>
      </div>
      <hr />
      <div
        class="tab-pane fade show active"
        id="activity"
        role="tabpanel"
        aria-labelledby="activity-tab">
        <ul class="list-group list-group-flush rui-profile-activity-list">
          <li class="list-group-item">
            <div class="media media-success media-retiring">
              <a href="#" class="media-link">
                <span class="media-body">
                  <span class="media-title">
                    Amber Smith
                    <span class="media-time">09:10</span>
                  </span>
                  <small class="media-subtitle">
                    Amet viverra dolor per mollis morbi sagittis cursus
                    sollicitudin cubilia.
                  </small>
                </span>
              </a>
            </div>
          </li>
          <li class="list-group-item">
            <div class="media media-success media-retiring">
              <a href="#" class="media-link">
                <span class="media-body">
                  <span class="media-title">
                    Amber Smith
                    <span class="media-time">09:10</span>
                  </span>
                  <small class="media-subtitle">
                    Amet viverra dolor per mollis morbi sagittis cursus
                    sollicitudin cubilia.
                  </small>
                </span>
              </a>
            </div>
          </li>
          <li class="list-group-item">
            <div class="media media-success media-retiring">
              <a href="#" class="media-link">
                <span class="media-body">
                  <span class="media-title">
                    Amber Smith
                    <span class="media-time">09:10</span>
                  </span>
                  <small class="media-subtitle">
                    Amet viverra dolor per mollis morbi sagittis cursus
                    sollicitudin cubilia.
                  </small>
                </span>
              </a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>

</Layout>
