<script>
  import Nav from "@public-shared/Partials/Nav";
  import { InertiaLink } from "@inertiajs/inertia-svelte";

</script>

<!-- desktop site__header -->
<header class="site__header d-lg-block d-none">
  <div class="site-header">
    <!-- .topbar -->
    <div class="site-header__topbar topbar">
      <div class="topbar__container container">
        <div class="topbar__row">
          <div class="topbar__item topbar__item--link">
            <a class="topbar-link" href="about-us.html">About Us</a>
          </div>
          <div class="topbar__item topbar__item--link">
            <a class="topbar-link" href="contact-us.html">Contacts</a>
          </div>
          <div class="topbar__item topbar__item--link">
            <a class="topbar-link" href>Store Location</a>
          </div>
          <div class="topbar__item topbar__item--link">
            <a class="topbar-link" href="track-order.html">Track Order</a>
          </div>
          <div class="topbar__item topbar__item--link">
            <a class="topbar-link" href="blog-classic.html">Blog</a>
          </div>
          <div class="topbar__spring" />
          <div class="topbar__item">
            <div class="topbar-dropdown">
              <button class="topbar-dropdown__btn" type="button">
                My Account
                <svg width="7px" height="5px">
                  <use xlink:href="/img/sprite.svg#arrow-rounded-down-7x5" />
                </svg>
              </button>
              <div class="topbar-dropdown__body">
                <!-- .menu -->
                <div class="menu menu--layout--topbar">
                  <div class="menu__submenus-container" />
                  <ul class="menu__list">
                    <li class="menu__item">
                      <!-- This is a synthetic element that allows to adjust the vertical offset of the submenu using CSS. -->
                      <div class="menu__item-submenu-offset" />
                      <a class="menu__item-link" href="account-dashboard.html">
                        Dashboard
                      </a>
                    </li>
                    <li class="menu__item">
                      <!-- This is a synthetic element that allows to adjust the vertical offset of the submenu using CSS. -->
                      <div class="menu__item-submenu-offset" />
                      <a class="menu__item-link" href="account-profile.html">
                        Edit Profile
                      </a>
                    </li>
                    <li class="menu__item">
                      <!-- This is a synthetic element that allows to adjust the vertical offset of the submenu using CSS. -->
                      <div class="menu__item-submenu-offset" />
                      <a class="menu__item-link" href="account-orders.html">
                        Order History
                      </a>
                    </li>
                    <li class="menu__item">
                      <!-- This is a synthetic element that allows to adjust the vertical offset of the submenu using CSS. -->
                      <div class="menu__item-submenu-offset" />
                      <a class="menu__item-link" href="account-addresses.html">
                        Addresses
                      </a>
                    </li>
                    <li class="menu__item">
                      <!-- This is a synthetic element that allows to adjust the vertical offset of the submenu using CSS. -->
                      <div class="menu__item-submenu-offset" />
                      <a class="menu__item-link" href="account-password.html">
                        Password
                      </a>
                    </li>
                    <li class="menu__item">
                      <!-- This is a synthetic element that allows to adjust the vertical offset of the submenu using CSS. -->
                      <div class="menu__item-submenu-offset" />
                      <a class="menu__item-link" href="account-login.html">
                        Logout
                      </a>
                    </li>
                  </ul>
                </div>
                <!-- .menu / end -->
              </div>
            </div>
          </div>
          <div class="topbar__item">
            <div class="topbar-dropdown">
              <button class="topbar-dropdown__btn" type="button">
                Currency:
                <span class="topbar__item-value">USD</span>
                <svg width="7px" height="5px">
                  <use xlink:href="/img/sprite.svg#arrow-rounded-down-7x5" />
                </svg>
              </button>
              <div class="topbar-dropdown__body">
                <!-- .menu -->
                <div class="menu menu--layout--topbar">
                  <div class="menu__submenus-container" />
                  <ul class="menu__list">
                    <li class="menu__item">
                      <!-- This is a synthetic element that allows to adjust the vertical offset of the submenu using CSS. -->
                      <div class="menu__item-submenu-offset" />
                      <a class="menu__item-link" href>€ Euro</a>
                    </li>
                    <li class="menu__item">
                      <!-- This is a synthetic element that allows to adjust the vertical offset of the submenu using CSS. -->
                      <div class="menu__item-submenu-offset" />
                      <a class="menu__item-link" href>£ Pound Sterling</a>
                    </li>
                    <li class="menu__item">
                      <!-- This is a synthetic element that allows to adjust the vertical offset of the submenu using CSS. -->
                      <div class="menu__item-submenu-offset" />
                      <a class="menu__item-link" href>$ US Dollar</a>
                    </li>
                    <li class="menu__item">
                      <!-- This is a synthetic element that allows to adjust the vertical offset of the submenu using CSS. -->
                      <div class="menu__item-submenu-offset" />
                      <a class="menu__item-link" href>₽ Russian Ruble</a>
                    </li>
                  </ul>
                </div>
                <!-- .menu / end -->
              </div>
            </div>
          </div>
          <div class="topbar__item">
            <div class="topbar-dropdown">
              <button class="topbar-dropdown__btn" type="button">
                Language:
                <span class="topbar__item-value">EN</span>
                <svg width="7px" height="5px">
                  <use xlink:href="/img/sprite.svg#arrow-rounded-down-7x5" />
                </svg>
              </button>
              <div class="topbar-dropdown__body">
                <!-- .menu -->
                <div class="menu menu--layout--topbar menu--with-icons">
                  <div class="menu__submenus-container" />
                  <ul class="menu__list">
                    <li class="menu__item">
                      <!-- This is a synthetic element that allows to adjust the vertical offset of the submenu using CSS. -->
                      <div class="menu__item-submenu-offset" />
                      <a class="menu__item-link" href>
                        <div class="menu__item-icon">
                          <img
                            srcset="/img/languages/language-1.png,
                            /img/languages/language-1@2x.png 2x"
                            src="/img/languages/language-1.png"
                            alt />
                        </div>
                        English
                      </a>
                    </li>
                    <li class="menu__item">
                      <!-- This is a synthetic element that allows to adjust the vertical offset of the submenu using CSS. -->
                      <div class="menu__item-submenu-offset" />
                      <a class="menu__item-link" href>
                        <div class="menu__item-icon">
                          <img
                            srcset="/img/languages/language-2.png,
                            /img/languages/language-2@2x.png 2x"
                            src="/img/languages/language-2.png"
                            alt />
                        </div>
                        French
                      </a>
                    </li>
                    <li class="menu__item">
                      <!-- This is a synthetic element that allows to adjust the vertical offset of the submenu using CSS. -->
                      <div class="menu__item-submenu-offset" />
                      <a class="menu__item-link" href>
                        <div class="menu__item-icon">
                          <img
                            srcset="/img/languages/language-3.png,
                            /img/languages/language-3@2x.png 2x"
                            src="/img/languages/language-3.png"
                            alt />
                        </div>
                        German
                      </a>
                    </li>
                    <li class="menu__item">
                      <!-- This is a synthetic element that allows to adjust the vertical offset of the submenu using CSS. -->
                      <div class="menu__item-submenu-offset" />
                      <a class="menu__item-link" href>
                        <div class="menu__item-icon">
                          <img
                            srcset="/img/languages/language-4.png,
                            /img/languages/language-4@2x.png 2x"
                            src="/img/languages/language-4.png"
                            alt />
                        </div>
                        Russian
                      </a>
                    </li>
                    <li class="menu__item">
                      <!-- This is a synthetic element that allows to adjust the vertical offset of the submenu using CSS. -->
                      <div class="menu__item-submenu-offset" />
                      <a class="menu__item-link" href>
                        <div class="menu__item-icon">
                          <img
                            srcset="/img/languages/language-5.png,
                            /img/languages/language-5@2x.png 2x"
                            src="/img/languages/language-5.png"
                            alt />
                        </div>
                        Italian
                      </a>
                    </li>
                  </ul>
                </div>
                <!-- .menu / end -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- .topbar / end -->
    <div class="site-header__middle container">
      <div class="site-header__logo">
        <a href="/">
          <img
            src="/img/the-bigtech-logo.png"
            class="img-fluid"
            alt="the bigtech logo" />
        </a>
      </div>
      <div class="site-header__search">
        <div class="search search--location--header">
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
              <div class="search__border" />
            </form>
            <div
              class="search__suggestions suggestions
              suggestions--location--header" />
          </div>
        </div>
      </div>
      <div class="site-header__phone">
        <div class="site-header__phone-title">Customer Service</div>
        <div class="site-header__phone-number">(800) 060-0730</div>
      </div>
    </div>

    <Nav />
  </div>
</header>
<!-- desktop site__header / end -->
