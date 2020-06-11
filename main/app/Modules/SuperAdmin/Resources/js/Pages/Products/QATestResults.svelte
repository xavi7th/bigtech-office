<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import FlashMessage from "@user-shared/FlashMessage";
  import route from "ziggy";

  $: ({ app } = $page);
</script>

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
            <div class="col-lg-5">
              <p class="lead">
                Check the boxes on the table to confirm device test
              </p>
              <p class="lead text-danger">
                If a device test is completed, this table should be replaced
                with the table on the right showing successful completed test
                data....if e make brain let me know Mr. Dan
              </p>
              <table class="table table-striped">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Test Type</th>
                    <th scope="col">Pass</th>
                    <th scope="col">Fail</th>
                    <th scope="col">Not Sure</th>
                    <th scope="col">Test Score</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">1</th>
                    <td>
                      <strong>Battery</strong>
                    </td>
                    <td>
                      <div class="custom-control custom-radio">
                        <input
                          type="radio"
                          id="battery1"
                          name="battery"
                          class="custom-control-input" />
                        <label class="custom-control-label" for="battery1" />
                      </div>
                    </td>
                    <td>
                      <div class="custom-control custom-radio">
                        <input
                          type="radio"
                          id="battery2"
                          name="battery"
                          class="custom-control-input" />
                        <label class="custom-control-label" for="battery2" />
                      </div>
                    </td>
                    <td>
                      <div class="custom-control custom-radio">
                        <input
                          type="radio"
                          id="battery3"
                          name="battery"
                          class="custom-control-input" />
                        <label class="custom-control-label" for="battery3" />
                      </div>
                    </td>
                    <td>
                      <span class="fas fa-check text-success" />
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">3</th>
                    <td>
                      <strong>Ports</strong>
                    </td>
                    <td>
                      <div class="custom-control custom-radio">
                        <input
                          type="radio"
                          id="ports1"
                          name="ports"
                          class="custom-control-input" />
                        <label class="custom-control-label" for="ports1" />
                      </div>
                    </td>
                    <td>
                      <div class="custom-control custom-radio">
                        <input
                          type="radio"
                          id="ports2"
                          name="ports"
                          class="custom-control-input" />
                        <label class="custom-control-label" for="ports2" />
                      </div>
                    </td>
                    <td>
                      <div class="custom-control custom-radio">
                        <input
                          type="radio"
                          id="ports3"
                          name="ports"
                          class="custom-control-input" />
                        <label class="custom-control-label" for="ports3" />
                      </div>
                    </td>
                    <td>
                      <span class="fas fa-exclamation text-warning" />
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">4</th>
                    <td>
                      <strong>Screen</strong>
                    </td>
                    <td>
                      <div class="custom-control custom-radio">
                        <input
                          type="radio"
                          id="screen1"
                          name="screen"
                          class="custom-control-input" />
                        <label class="custom-control-label" for="screen1" />
                      </div>
                    </td>
                    <td>
                      <div class="custom-control custom-radio">
                        <input
                          type="radio"
                          id="screen2"
                          name="screen"
                          class="custom-control-input" />
                        <label class="custom-control-label" for="screen2" />
                      </div>
                    </td>
                    <td>
                      <div class="custom-control custom-radio">
                        <input
                          type="radio"
                          id="screen3"
                          name="screen"
                          class="custom-control-input" />
                        <label class="custom-control-label" for="screen3" />
                      </div>
                    </td>
                    <td>
                      <span class="fas fa-check text-success" />
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">5</th>
                    <td>
                      <strong>RAM</strong>
                    </td>
                    <td>
                      <div class="custom-control custom-radio">
                        <input
                          type="radio"
                          id="ram1"
                          name="ram"
                          class="custom-control-input" />
                        <label class="custom-control-label" for="ram1" />
                      </div>
                    </td>
                    <td>
                      <div class="custom-control custom-radio">
                        <input
                          type="radio"
                          id="ram2"
                          name="ram"
                          class="custom-control-input" />
                        <label class="custom-control-label" for="ram2" />
                      </div>
                    </td>
                    <td>
                      <div class="custom-control custom-radio">
                        <input
                          type="radio"
                          id="ram3"
                          name="ram"
                          class="custom-control-input" />
                        <label class="custom-control-label" for="ram3" />
                      </div>
                    </td>
                    <td>
                      <span class="fas fa-times text-danger" />
                    </td>
                  </tr>
                  <tr>
                    <th scope="row">6</th>
                    <td>
                      <strong>Volume</strong>
                    </td>
                    <td>
                      <div class="custom-control custom-radio">
                        <input
                          type="radio"
                          id="volume1"
                          name="volume"
                          class="custom-control-input" />
                        <label class="custom-control-label" for="volume1" />
                      </div>
                    </td>
                    <td>
                      <div class="custom-control custom-radio">
                        <input
                          type="radio"
                          id="volume2"
                          name="volume"
                          class="custom-control-input" />
                        <label class="custom-control-label" for="volume2" />
                      </div>
                    </td>
                    <td>
                      <div class="custom-control custom-radio">
                        <input
                          type="radio"
                          id="volume3"
                          name="volume"
                          class="custom-control-input" />
                        <label class="custom-control-label" for="volume3" />
                      </div>
                    </td>
                    <td>
                      <span class="fas fa-check text-success" />
                    </td>
                  </tr>
                </tbody>
              </table>
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
                <ul
                  class="list-group list-group-flush rui-profile-activity-list">
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
        </div>
      </div>
    </div>
  </div>
</Layout>
