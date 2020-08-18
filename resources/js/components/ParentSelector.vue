<template>
  <div>
    <div class="columns col-gapless">
      <div class="column">
        <div class="form-input">
          <span v-if="!parent" class="placeholder">Parent ...</span>
          <span v-if="parent">{{ parent.name }}</span>
        </div>
      </div>
      <div class="col-auto">
        <button type="button" class="btn btn-action h-100" v-on:click="showSearchModal = true">
          <i class="icon icon-search"></i>
        </button>
      </div>
    </div>
    <div class="modal modal-sm" v-bind:class="{active: showSearchModal}">
      <a class="modal-overlay" aria-label="Close" v-on:click="showSearchModal = false"></a>
      <div class="modal-container">
        <div class="modal-header">
          <a
            class="btn btn-clear float-right"
            aria-label="Close"
            v-on:click="showSearchModal = false"
          ></a>
          <div class="modal-title h5">Search parent</div>
        </div>
        <div class="modal-body">
          <div class="content">
            <input v-model.trim="search" class="form-input" type="text" placeholder="Name ..." />
            <div>
              <button
                v-for="element in result"
                class="btn btn-link d-block"
                v-bind:key="element.id"
                v-on:click="selectedUpdate(element);"
              >{{ element.name }}</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import NoteService from '../services/NoteService';
export default {
  name: "ParentSelector",
  props: {
    parentId: null
  },
  data: function () {
    return {
      search: "",
      result: [],
      showSearchModal: false,
      parent: null,
    };
  },
  methods: {
    selectedUpdate: function (parent) {
      this.parent = parent;
      this.showSearchModal = false;
      this.$emit("selected-parent-update", this.parent.id);
    },
  },
  watch: {
    search: function(val, oldVal) {
      NoteService.search(val).then((result) => {
        this.result = result;
      });
    },
    parentId: function(val, oldVal) {
      if(val) {
        NoteService.get(val).then((note) => {
          this.parent = result;
        });
      }
    }
  }
};
</script>