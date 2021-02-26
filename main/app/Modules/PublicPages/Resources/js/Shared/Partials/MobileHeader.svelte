<style lang="scss">
  .mobile-header__logo {
    text-align: center;
    width: 100%;

    .logo {
      max-height: 45px;
    }
  }
</style>

<!-- mobile site__header -->
<header class="site__header d-lg-none">
  <!-- data-sticky-mode - one of [pullToShow, alwaysOnTop] -->
  <div
    class="mobile-header mobile-header--sticky"
    data-sticky-mode="alwaysOnTop">
    <div class="mobile-header__panel">
      <div class="container">
        <div class="mobile-header__body">
          <button class="mobile-header__menu-button">
            <svg width="18px" height="14px">
              <use xlink:href="/img/sprite.svg#menu-18x14" />
            </svg>
          </button>
          <a class="mobile-header__logo" href="/">
            <img src="/img/the-bigtech-logo.png" class="img-fluid logo" alt="" />
          </a>
          <div
            class="search search--location--mobile-header mobile-header__search">
            <div class="search__body">
              <form class="search__form" action>
                <input
                  class="search__input"
                  name="search"
                  placeholder="Search over 10,000 products"
                  aria-label="Site search"
                  type="text"
                  autocomplete="off" />
                <button
                  class="search__button search__button--type--submit"
                  type="submit">
                  <svg width="20px" height="20px">
                    <use xlink:href="/img/sprite.svg#search-20" />
                  </svg>
                </button>
                <button
                  class="search__button search__button--type--close"
                  type="button">
                  <svg width="20px" height="20px">
                    <use xlink:href="/img/sprite.svg#cross-20" />
                  </svg>
                </button>
                <div class="search__border" />
              </form>
              <div
                class="search__suggestions suggestions
                suggestions--location--mobile-header" />
            </div>
          </div>
          <div class="mobile-header__indicators">
            <div
              class="indicator indicator--mobile-search indicator--mobile
              d-md-none">
              <button class="indicator__button">
                <span class="indicator__area">
                  <svg width="20px" height="20px">
                    <use xlink:href="/img/sprite.svg#search-20" />
                  </svg>
                </span>
              </button>
            </div>
            <div class="indicator indicator--mobile d-sm-flex d-none">
              <a href="wishlist.html" class="indicator__button">
                <span class="indicator__area">
                  <svg width="20px" height="20px">
                    <use xlink:href="/img/sprite.svg#heart-20" />
                  </svg>
                  <span class="indicator__value">0</span>
                </span>
              </a>
            </div>
            <div class="indicator indicator--mobile">
              <a href="cart.html" class="indicator__button">
                <span class="indicator__area">
                  <svg width="20px" height="20px">
                    <use xlink:href="/img/sprite.svg#cart-20" />
                  </svg>
                  <span class="indicator__value">3</span>
                </span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>
<!-- mobile site__header / end -->
