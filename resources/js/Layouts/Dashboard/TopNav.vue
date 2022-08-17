<script setup>
import { Link } from "@inertiajs/inertia-vue3";

defineProps({
  homeUrl: String,
  hasSearch: {
    type: Boolean,
    default: false,
  },
  searchUrl: String,
  hasNotifications: {
    type: Boolean,
    default: false,
  },
  notifications: Object,
  profileUrls: Object,
});
</script>
<template>
  <header id="sc-header">
    <nav
      class="uk-navbar uk-navbar-container"
      data-uk-navbar="mode: click; duration: 360"
    >
      <div
        class="uk-navbar-right nav-overlay-small uk-margin-left uk-navbar-aside"
      >
        <a href="#" id="sc-sidebar-main-toggle"
          ><i class="mdi mdi-backburger sc-menu-close"></i
          ><i class="mdi mdi-menu sc-menu-open"></i
        ></a>
        <div class="sc-brand uk-visible@s">
          <a :href="homeUrl"
            ><img src="/dashboard/assets/img/logo.png" alt=""
          /></a>
        </div>
      </div>

      <div
        v-if="hasSearch"
        class="nav-overlay nav-overlay-small uk-navbar-left uk-flex-1"
        hidden
      >
        <a
          class="uk-navbar-toggle uk-visible@m"
          data-uk-toggle="target: .nav-overlay; animation: uk-animation-slide-top"
          href="#"
        >
          <i class="mdi mdi-close sc-icon-24"></i>
        </a>
        <a
          class="uk-navbar-toggle uk-hidden@m uk-padding-remove-right"
          data-uk-toggle="target: .nav-overlay-small; animation: uk-animation-slide-top"
          href="#"
        >
          <i class="mdi mdi-close sc-icon-24"></i>
        </a>
        <div class="uk-navbar-item uk-width-expand uk-padding-remove-left">
          <form class="uk-search uk-search-navbar uk-width-1-1 uk-flex">
            <div class="uk-flex-1 uk-position-relative">
              <a
                class="uk-form-icon uk-form-icon-flip"
                href="javascript:void(0)"
                data-uk-icon="icon: close"
                data-sc-clear-input
              ></a>
              <input
                class="uk-search-input"
                type="search"
                placeholder="Search..."
                autofocus
              />
            </div>
            <button
              class="
                sc-button
                sc-button-default
                sc-button-small
                sc-button-icon
                sc-button-flat
                uk-margin-small-right
              "
              type="button"
            >
              <i class="mdi mdi-magnify sc-icon-24 md-color-white"></i>
            </button>
          </form>
        </div>
      </div>

      <div class="nav-overlay nav-overlay-small uk-navbar-left">
        <ul class="uk-navbar-nav">
          <li v-if="hasSearch">
            <a
              class="uk-navbar-toggle uk-visible@m"
              href="#"
              data-uk-toggle="target: .nav-overlay; animation: uk-animation-slide-top"
              ><i class="mdi mdi-magnify"></i
            ></a>
            <a
              class="uk-navbar-toggle uk-hidden@m"
              href="#"
              id="sc-search-main-toggle-mobile"
              data-uk-toggle="target: .nav-overlay-small; animation: uk-animation-slide-top"
              ><i class="mdi mdi-magnify"></i
            ></a>
          </li>

          <li class="uk-visible@l">
            <a href="#" id="sc-js-fullscreen-toggle"
              ><i class="mdi mdi-fullscreen sc-js-el-hide"></i
              ><i class="mdi mdi-fullscreen-exit sc-js-el-show"></i
            ></a>
          </li>

          <li v-if="hasNotifications" class="uk-visible@s">
            <a href="#">
              <span class="mdi mdi-bell uk-display-inline-block">
                <span class="sc-indicator md-bg-color-red-600"></span>
              </span>
            </a>
            <div class="uk-navbar-dropdown md-bg-grey-100">
              <div class="sc-padding-medium sc-padding-small-ends">
                <div class="uk-text-right uk-margin-medium-bottom">
                  <button
                    class="
                      sc-button
                      sc-button-default
                      sc-button-outline
                      sc-button-mini
                      sc-js-clear-alerts
                    "
                  >
                    Clear all
                  </button>
                </div>
                <ul class="uk-list uk-margin-remove" id="sc-header-alerts">
                  <li class="sc-border sc-round md-bg-white">
                    <div class="uk-margin-left uk-margin-small-right">
                      <i class="mdi mdi-alert-outline md-color-red-600"></i>
                    </div>
                    <div class="uk-flex-1 uk-text-small">
                      Information Page Not Found!
                    </div>
                  </li>
                  <li
                    class="uk-margin-small-top sc-border sc-round md-bg-white"
                  >
                    <div class="uk-margin-left uk-margin-small-right">
                      <i
                        class="mdi mdi-email-check-outline md-color-blue-600"
                      ></i>
                    </div>
                    <div class="uk-flex-1 uk-text-small">
                      A new password has been sent to your e-mail address.
                    </div>
                  </li>
                  <li
                    class="uk-margin-small-top sc-border sc-round md-bg-white"
                  >
                    <div class="uk-margin-left uk-margin-small-right">
                      <i class="mdi mdi-alert-outline md-color-red-600"></i>
                    </div>
                    <div class="uk-flex-1 uk-text-small">
                      You do not have permission to access the API!
                    </div>
                  </li>
                  <li
                    class="uk-margin-small-top sc-border sc-round md-bg-white"
                  >
                    <div class="uk-margin-left uk-margin-small-right">
                      <i class="mdi mdi-check-all md-color-light-green-600"></i>
                    </div>
                    <div class="uk-flex-1 uk-text-small">
                      Your enquiry has been successfully sent.
                    </div>
                  </li>
                </ul>
                <div
                  class="
                    uk-text-medium uk-text-center
                    sc-js-empty-message sc-text-semibold sc-padding-ends
                  "
                  style="display: none"
                >
                  No alerts!
                </div>
              </div>
            </div>
          </li>

          <li>
            <a href="#"
              ><img
                src="/dashboard/assets/img/avatars/avatar_default_sm.png"
                alt=""
            /></a>
            <div class="uk-navbar-dropdown uk-dropdown-small">
              <ul class="uk-nav uk-nav-navbar">
                <li>
                  <Link :href="profileUrls.myProfile"> حسابى </Link>
                </li>
                <li>
                  <Link :href="profileUrls.settings"> الأعدادات </Link>
                </li>
                <li>
                  <Link :href="profileUrls.logout"> تسجيل خروج </Link>
                </li>
              </ul>
            </div>
          </li>
        </ul>
        <a
          href="#"
          class="
            sc-js-offcanvas-toggle
            md-color-white
            uk-margin-right uk-hidden@l
          "
        >
          <i class="mdi mdi-menu sc-offcanvas-open"></i>
          <i class="mdi mdi-arrow-right sc-offcanvas-close"></i>
        </a>
      </div>
    </nav>
  </header>
</template>
