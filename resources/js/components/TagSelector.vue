<style lang="scss">
@import "../../sass/spectre/_variables.scss";

.placeholder {
    color: $gray-color;
    user-select: none; 
}
</style>

<template>
  <div>
    <div class="columns col-gapless">
      <div class="column">
        <div class="form-input h-auto">
          <span v-if="!selectedTags.length" class="placeholder">Select tags ...</span>
          <span v-for="tag in selectedTags" class="chip" v-bind:key="tag.id">
            {{ tag.name }}
            <a
              v-on:click="removeTag(tag.id)"
              class="btn btn-clear"
              aria-label="Close"
              role="button"
            ></a>
          </span>
        </div>
      </div>
      <div class="col-auto">
        <button type="button" class="btn btn-action h-100" v-on:click="showTagModal = true">
          <i class="icon icon-search"></i>
        </button>
      </div>
    </div>
    <div class="modal modal-sm" v-bind:class="{active: showTagModal}">
      <a class="modal-overlay" aria-label="Close" v-on:click="showTagModal = false"></a>
      <div class="modal-container">
        <div class="modal-header">
          <a
            class="btn btn-clear float-right"
            aria-label="Close"
            v-on:click="showTagModal = false"
          ></a>
          <div class="modal-title h5">Choose tags</div>
        </div>
        <div class="modal-body">
          <div class="content">
            <input v-model="search" type="text" placeholder="Search tag ..." class="form-input" />
            <div>
              <div v-for="tag in filteredList" class="form-group" v-bind:key="tag.id">
                <label class="form-checkbox">
                  <input
                    v-model="tag.checked"
                    v-on:click="checkTag(tag.id, $event)"
                    type="checkbox"
                  />
                  <i class="form-icon"></i>
                  {{ tag.name }}
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" v-on:click="showTagModal = false">ok</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "TagSelector",
  props: {
    tags: Array,
    selected: Array
  },
  data: function () {
    return {
      selectedTags: [],
      showTagModal: false,
      search: ""
    };
  },
  methods: {
    removeTag: function (id) {
      let index = this.selectedTags.findIndex((e) => e.id == id);
      this.selectedTags[index].checked = false;
      this.selectedTags.splice(index, 1);

      this.$emit('update-selected-tags', this.selectedTags);
    },
    checkTag: function (id, event) {
      let tag = this.tags.find((e) => e.id == id);

      if (tag.checked) {
        this.removeTag(tag.id);
        tag.checked = false;
      } else {
        this.selectedTags.push(tag);
        tag.checked = true;
      }

      this.$emit('update-selected-tags', this.selectedTags);
    },
  },
  computed: {
    filteredList: function() {
      return this.tags.filter((tag) => {
        return tag.name.toLowerCase().includes(this.search.toLowerCase());
      });
    }
  },
  watch: {
    selected: function(val, oldVal) {
      if(val) {
        this.selectedTags = val;
      }
    }
  }
};
</script>