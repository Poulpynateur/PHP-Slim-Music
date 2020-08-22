<template>
  <div>
    <div class="columns col-gapless">
      <div class="column">
        <div class="form-input">
          <span v-if="!parent.name" class="placeholder">Parent ...</span>
          <span v-else>{{ parent.name }}</span>
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
import NoteService from "../services/NoteService";
import Note from '../models/Note';
export default {
  name: "ParentSelector",
  props: {
    note: null,
  },
  data: function () {
    return {
      search: "",
      result: [],
      showSearchModal: false,
      parent: new Note(),
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
    search: function (val, oldVal) {
      NoteService.search(val).then((result) => {
        this.result = result;
      });
    },
    note: function (val, oldVal) {
      if (val) {
        if (val.parentId) {
          NoteService.get(val.parentId).then((parent) => {
            this.parent = parent;
          });
        } else {
          this.parent = new Note();
        }
      }
    },
  },
};
</script>