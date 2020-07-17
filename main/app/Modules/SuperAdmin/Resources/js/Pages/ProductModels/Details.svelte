<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import Modal from "@superadmin-shared/Partials/Modal";
  import FlashMessage from "@user-shared/FlashMessage";
  import route from "ziggy";

  export let description;

  $: ({ app } = $page);
</script>

<style lang="scss">
  .rui-profile-img {
    max-width: 100%;
    max-height: 350px;
    height: 350px;

    img {
      object-fit: contain;
      object-position: 50% 50%;
    }
  }

  .model-img {
    position: relative;
    .btn-delete {
      position: absolute;
      top: 8px;
      right: 0;
    }
  }
</style>

<Layout title="Product Models">
  <div class="rui-profile row vertical-gap">
    <div class="col-lg-6 col-xl-5">
      <div class="card">
        <div class="card-body">
          <div class="row vertical-gap">
            <div class="col-auto">
              <h3 class="rui-profile-info-title h4">Iphone 11</h3>
              <div class="rui-profile-img">
                <img src="/img/iphone-11.png" alt="" />
              </div>
            </div>
          </div>
          <div class="rui-profile-numbers">
            <div class="row justify-content-center">
              <div class="col" />
              <div class="col-auto">
                <div class="rui-profile-number text-center">
                  <h4 class="rui-profile-number-title h2">Phones</h4>
                  <small class="text-grey-6">Category</small>
                </div>
              </div>
              <div class="col p-0" />
              <div class="col-auto">
                <div class="rui-profile-number text-center">
                  <h4 class="rui-profile-number-title h2">Apple</h4>
                  <small class="text-grey-6">Brand</small>
                </div>
              </div>
              <div class="col" />
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-6 col-xl-7">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <h2 class="card-title mnb-6 mr-auto">Description Summary</h2>
            {#if description}
              <button
                class="btn btn-custom-round mr-20"
                data-toggle="modal"
                data-target="#createDescription">
                <span
                  data-feather="link-2"
                  class="rui-icon rui-icon-stroke-1_5" />
              </button>
            {:else}
              <button
                class="btn btn-brand btn-uniform btn-round btn-sm mnt-8 mnb-8"
                data-toggle="modal"
                data-target="#createDescription">
                <span
                  data-feather="plus"
                  class="rui-icon rui-icon-stroke-1_5" />
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
                  <a class="rui-task-title" href="#home">
                    A new dual‑camera system captures more of what you see and
                    love. The fastest chip ever in a smartphone and all‑day
                    battery life let you do more and charge less. And the
                    highest‑quality video in a smartphone, so your memories look
                    better than ever.
                    <br />
                    iPhone 11 is water resistant up to 2 meters for up to 30
                    minutes — double the depth of iPhone XR.1
                    <br />
                    Shoot and edit the highest-quality video in a smartphone.
                    iPhone 11 shoots beautifully sharp 4K video at 60 fps across
                    all its cameras. The Ultra Wide camera captures four times
                    more scene, so it’s perfect for action shots like your dog
                    catching a frisbee. If you’re recording a performance — say,
                    your kid’s piano recital — when you zoom in, the audio zooms
                    too. And now you can edit videos as easily as you do photos.
                    <br />
                    All-day battery life. Hardware and software work together to
                    get the most out of your battery. And thanks to fast‑charge
                    capability, you can recharge in less time.
                    <br />
                    New Ultra Wide camera. Go big — the new Ultra Wide camera
                    captures four times more scene. Think breathtaking
                    landscapes that go on forever. Capturing the entire stage
                    and crowd at a music festival. And vacation shots that show
                    the whole family — including the views you traveled 11,000
                    miles for.
                    <br />
                    Introducing Night mode. Shooting in low light doesn’t have
                    to be a shot in the dark. Night mode is a new feature that
                    turns on automatically for low‑light photos like you’ve
                    never seen. There’s no need for flash, colors are more
                    natural, and photos are brighter.
                  </a>
                  <small class="rui-task-subtitle">
                    Updated 4 days ago by
                    <a href="#">Henry</a>
                  </small>
                </div>
              </div>
            </li>

          </ul>
        </div>
      </div>
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
          <ul class="list-group list-group-flush rui-profile-activity-list">
            <li class="list-group-item">
              <div class="media media-success media-retiring">
                <div class="media-content">
                  <div class="row vertical-gap sm-gap rui-gallery">
                    <div class="col-6 col-md-3 col-lg-2 model-img">
                      <a
                        href="/img/iphone-11.png"
                        data-fancybox="images"
                        class="rui-gallery-item">
                        <span
                          class="rui-gallery-item-overlay
                          rui-gallery-item-overlay-md">
                          <span
                            data-feather="maximize"
                            class="rui-icon rui-icon-stroke-1_5" />
                        </span>
                        <img src="/img/iphone-11.png" class="rui-img" alt="" />
                        <button
                          type="button"
                          class="btn btn-danger btn-uniform btn-round btn-delete
                          btn-sm">
                          <span
                            data-feather="x"
                            class="rui-icon rui-icon-stroke-1_5" />

                        </button>
                      </a>
                    </div>
                    <div class="col-6 col-md-3 col-lg-2 model-img">
                      <a
                        href="/img/letter-2-min.png"
                        data-fancybox="images"
                        class="rui-gallery-item">
                        <span
                          class="rui-gallery-item-overlay
                          rui-gallery-item-overlay-md">
                          <span
                            data-feather="maximize"
                            class="rui-icon rui-icon-stroke-1_5" />
                        </span>
                        <img
                          src="/img/letter-2-min.png"
                          class="rui-img"
                          alt="" />
                        <button
                          type="button"
                          class="btn btn-danger btn-uniform btn-round btn-delete
                          btn-sm">
                          <span
                            data-feather="x"
                            class="rui-icon rui-icon-stroke-1_5" />

                        </button>
                      </a>
                    </div>
                    <div class="col-6 col-md-3 col-lg-2 model-img">
                      <a
                        href="/img/iphone-11.png"
                        data-fancybox="images"
                        class="rui-gallery-item">
                        <span
                          class="rui-gallery-item-overlay
                          rui-gallery-item-overlay-md">
                          <span
                            data-feather="maximize"
                            class="rui-icon rui-icon-stroke-1_5" />
                        </span>
                        <img src="/img/iphone-11.png" class="rui-img" alt="" />
                        <button
                          type="button"
                          class="btn btn-danger btn-uniform btn-round btn-delete
                          btn-sm">
                          <span
                            data-feather="x"
                            class="rui-icon rui-icon-stroke-1_5" />

                        </button>
                      </a>
                    </div>
                    <div class="col-6 col-md-3 col-lg-2 model-img">
                      <a
                        href="/img/letter-4-min.png"
                        data-fancybox="images"
                        class="rui-gallery-item">
                        <span
                          class="rui-gallery-item-overlay
                          rui-gallery-item-overlay-md">
                          <span
                            data-feather="maximize"
                            class="rui-icon rui-icon-stroke-1_5" />
                        </span>
                        <img
                          src="/img/letter-4-min.png"
                          class="rui-img"
                          alt="" />
                      </a>
                      <button
                        type="button"
                        class="btn btn-danger btn-uniform btn-round btn-delete
                        btn-sm">
                        <span
                          data-feather="x"
                          class="rui-icon rui-icon-stroke-1_5" />

                      </button>
                    </div>
                  </div>
                </div>
                <a href="#home" class="media-icon">
                  <span data-feather="x" class="rui-icon rui-icon-stroke-1_5" />
                </a>
              </div>
            </li>
          </ul>
          Add new image
        </div>
        <div
          class="tab-pane fade"
          id="timeline"
          role="tabpanel"
          aria-labelledby="timeline-tab">
          <div class="rui-timeline rui-timeline-left-lg">
            <div class="rui-timeline-line" />
            <div class="rui-timeline-item">
              <div class="rui-timeline-icon">
                <span
                  data-feather="check-circle"
                  class="rui-icon rui-icon-stroke-1_5" />
              </div>
              <div class="rui-timeline-content">
                <h3>Fifth moveth, void second.</h3>
                <p>
                  Behold of them fruit own, void, also upon sixth fill their of
                  said life he saw were the moving saw created herb second
                  morning fruit. Doesn't second place gathering forth.
                </p>
                <button type="button" class="btn btn-brand">Read More</button>
              </div>
              <div class="rui-timeline-date">Jan 14</div>
            </div>
            <div class="rui-timeline-item rui-timeline-item-swap">
              <div class="rui-timeline-icon">
                <span
                  data-feather="award"
                  class="rui-icon rui-icon-stroke-1_5" />
              </div>
              <div class="rui-timeline-content">
                <h3>Can't dry fly.</h3>
                <p>
                  Likeness they're every give moved above moveth, herb days a
                  rule behold seed is second night behold sea. Under given
                  waters made wherein behold void form land.
                </p>
                <button type="button" class="btn btn-brand">Read More</button>
              </div>
              <div class="rui-timeline-date">Jan 15</div>
            </div>
            ADD NEW COMMENT
          </div>
        </div>
        <div
          class="tab-pane fade"
          id="settings"
          role="tabpanel"
          aria-labelledby="settings-tab">
          <form action="#">
            <div class="row vertical-gap">
              <div class="col-12 col-lg-auto">
                <div class="card">
                  <div class="card-body pt-20 pr-10 pb-20 pl-10">
                    <ul class="nav flex-column mnt-3">
                      <li>
                        <a class="nav-link active" href="#">
                          <span
                            data-feather="user"
                            class="rui-icon rui-icon-stroke-1_5" />
                          <span>Personal information</span>
                        </a>
                      </li>
                      <li>
                        <a class="nav-link" href="#">
                          <span
                            data-feather="user-check"
                            class="rui-icon rui-icon-stroke-1_5" />
                          <span>Account information</span>
                        </a>
                      </li>
                      <li>
                        <a class="nav-link" href="#">
                          <span
                            data-feather="mail"
                            class="rui-icon rui-icon-stroke-1_5" />
                          <span>Email settings</span>
                        </a>
                      </li>
                      <li>
                        <a class="nav-link" href="#">
                          <span
                            data-feather="lock"
                            class="rui-icon rui-icon-stroke-1_5" />
                          <span>Security</span>
                        </a>
                      </li>
                      <li>
                        <a class="nav-link" href="#">
                          <span
                            data-feather="bar-chart-2"
                            class="rui-icon rui-icon-stroke-1_5" />
                          <span>Statistics</span>
                        </a>
                      </li>
                      <li>
                        <a class="nav-link" href="#">
                          <span
                            data-feather="shopping-cart"
                            class="rui-icon rui-icon-stroke-1_5" />
                          <span>Purchases</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-12 col-lg-8">
                <div class="card">
                  <div class="card-body">
                    <div class="row vertical-gap sm-gap justify-content-end">
                      <div class="col-12">
                        <label>Avatar</label>
                        <a class="rui-profile-img" href="#">
                          <img src="/img/avatar-1-profile.png" alt="" />
                        </a>
                      </div>
                      <div class="col-12">
                        <label for="firstName">First Name</label>
                        <input
                          class="form-control"
                          id="firstName"
                          value="Jack"
                          placeholder="Your First Name" />
                      </div>
                      <div class="col-12">
                        <label for="lastName">Last Name</label>
                        <input
                          type="email"
                          class="form-control"
                          id="lastName"
                          value="Boyd"
                          placeholder="Your Last Name" />
                      </div>
                      <div class="col-12">
                        <label for="profileEmail">Email</label>
                        <input
                          type="email"
                          class="form-control"
                          id="profileEmail"
                          value="info@example.com"
                          placeholder="Your Email" />
                      </div>
                      <div class="col-12">
                        <label for="phone">Contact Phone</label>
                        <input
                          class="form-control"
                          id="phone"
                          value="+44 987 065 909"
                          placeholder="Your Phone" />
                      </div>
                      <div class="col-auto">
                        <button class="btn btn-grey-2" type="button">
                          Cancel
                        </button>
                      </div>
                      <div class="col-auto">
                        <button class="btn btn-brand" type="button">
                          Save
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div slot="modals">
    <Modal
      modalId="createDescription"
      modalTitle="Add Description to Product Model">
      <textarea
        name="createDescription"
        cols="30"
        rows="10"
        class="form-control"
        bind:value={description} />

      <button slot="footer-buttons" class="btn btn-brand">
        Add Description
      </button>
    </Modal>
  </div>
</Layout>
