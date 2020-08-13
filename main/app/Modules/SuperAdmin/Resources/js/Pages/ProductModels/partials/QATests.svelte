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
              <button class="btn btn-grey-2" type="button">Cancel</button>
            </div>
            <div class="col-auto">
              <button class="btn btn-brand" type="button">Save</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
