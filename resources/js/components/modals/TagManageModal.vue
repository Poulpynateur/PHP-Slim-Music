<style lang="scss">
@import "../../../sass/spectre/_variables.scss";
.tags-container {
  border-radius: 0.5rem;
  border: 1px solid $gray-color-light;
}
.remove-chip {
    padding-right: 0;
    .btn-error {
        margin: 0 0 0 0.4rem;
    }
}
</style>

<template>
  <div class="modal modal-lg" :class="{active: isActive}">
    <a v-on:click="toggle()" class="modal-overlay" aria-label="Close"></a>
    <div class="modal-container">
      <div class="modal-header">
        <a v-on:click="toggle()" class="btn btn-clear float-right"></a>
        <div class="modal-title h5">Tag management</div>
      </div>
      <div class="modal-body">
        <div class="input-group">
          <input v-model.trim="newTag.name" type="text" class="form-input" placeholder="New tag name ..." />
          <button class="btn btn-success input-group-btn" v-on:click="createTag()"><i class="icon icon-plus"></i></button>
        </div>
        <div class="tags-container">
          <span v-for="tag in tags" class="chip remove-chip" v-bind:key="tag.id">
            {{ tag.name }}
            <a
              v-on:click="removeTag(tag.id)"
              class="btn btn-error"
              aria-label="Close"
              role="button"
            >
              <i class="icon icon-delete"></i>
            </a>
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Tag from '../../models/Tag';
import TagService from '../../services/TagService';
export default {
  props: {
    tags: Array
  },
  data() {
    return {
      isActive: false,
      newTag : new Tag()
    };
  },
  methods: {
    toggle() {
      this.isActive = !this.isActive;
    },
    createTag() {
      TagService.createTag.call(this, this.newTag);
    },
    removeTag(id) {
      TagService.removeTag.call(this, id);
    },
  },
};
</script>