<template>
  <div class="modal modal-sm" :class="{active: isActive}">
    <a v-on:click="toggle()" class="modal-overlay" aria-label="Close"></a>
    <div class="modal-container">
      <div class="modal-header">
        <a v-on:click="toggle()" class="btn btn-clear float-right"></a>
        <div class="modal-title h5">Login</div>
      </div>
      <div class="modal-body">
        <div class="content" v-bind:class="{'has-error': hasError}">
          <div class="form-group">
            <label class="form-label">Username</label>
            <input class="form-input" type="text" v-model="username" />
          </div>
          <div class="form-group">
            <label class="form-label">Password</label>
            <input class="form-input" type="password" v-model="password" />
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" v-on:click="login()">login</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isActive: false,
      hasError: false,

      username: "",
      password: ""
    };
  },
  methods: {
    toggle() {
      this.isActive = !this.isActive;
    },
    login() {
      let app = this;
      this.$auth.login({
        data: {
          username: app.username,
          password: app.password
        },
      }).then( res => {
        app.toggle();
      }).catch(error => {
        app.hasError = true;
      });
    },
  },
};
</script>