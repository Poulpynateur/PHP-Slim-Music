<template>
  <div class="navbar">
    <section class="navbar-section">
      <div class="dropdown">
        <a class="btn btn-link dropdown-toggle" tabindex="0">
          Display
          <i class="icon icon-caret"></i>
        </a>
        <ul class="menu">
          <li class="menu-item">
            <a v-on:click="setDisplayType('list')" v-bind:class="{active: displayType == 'list'}">
              <i class="icon icon-menu"></i> list
            </a>
          </li>
          <li class="menu-item">
            <a
              v-on:click="setDisplayType('mosaic')"
              v-bind:class="{active: displayType == 'mosaic'}"
            >
              <i class="icon icon-apps"></i> images
            </a>
          </li>
        </ul>
      </div>
      <a class="btn btn-link" v-on:click="toggleShowFilter()">
        Filters
        <i v-if="!showFilters" class="ml-1 icon icon-plus"></i>
        <i v-if="showFilters" class="ml-1 icon icon-minus"></i>
      </a>
    </section>
    <section class="navbar-section">
      <login-modal ref="loginModal"></login-modal>
      <button class="btn btn-link" v-if="$auth.check()" v-on:click="$auth.logout()">logout</button>
      <button class="btn btn-link" v-if="!$auth.check()" v-on:click="showLoginModal()">login</button>
    </section>
  </div>
</template>

<script>
import LoginModal from "../modals/LoginModal";
export default {
  data() {
    return {
      showFilters: false,
      displayType: 'list',
    };
  },
  components: {
    LoginModal,
  },
  methods: {
    toggleShowFilter() {
      this.showFilters = !this.showFilters;
      this.$emit('toggle-show-filters', this.showFilters);
    },
    setDisplayType(type) {
      this.displayType = type;
      this.$emit('update-display-type', this.displayType);
    },
    showLoginModal() {
      this.$refs.loginModal.toggle();
    },
  },
};
</script>