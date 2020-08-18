<style lang="scss">
@import "../../sass/app.scss";
</style>

<template>
  <div class="container">
    <note-modify-modal :tags="$root.$data.tags" ref="noteModifyModal"></note-modify-modal>
    <tag-manage-modal :tags="$root.$data.tags" ref="tagManageModal"></tag-manage-modal>
    <note-content-modal ref="noteContentModal"></note-content-modal>
    <notifications position="top left" width="100%" classes="toast" />
    <header>
      <main-menu
        v-on:update-display-type="displayType = $event"
        v-on:toggle-show-filters="showFilters = $event"
      ></main-menu>
      <filter-menu
        :notes="$root.$data.notes"
        :tags="$root.$data.tags"
        v-if="showFilters"
        v-on:update-filtered-notes="filteredNotes = $event"
      ></filter-menu>
    </header>
    <ul class="breadcrumb m-0" v-if="!isRoot">
      <li class="breadcrumb-item" v-on:click="getRootNotes()">
        <a href="#">Root</a>
      </li>
      <li
        class="breadcrumb-item c-pointer"
        v-for="parent in parentTree"
        v-bind:key="parent.id"
        v-on:click="getChildrensNotes(parent.id)"
      >
        <a>{{ parent.name }}</a>
      </li>
    </ul>
    <div class="columns" v-if="$auth.check()">
      <div class="column">
        <button class="btn btn-success w-100" v-on:click="showNoteModifyModal()">New note</button>
      </div>
      <div class="column">
        <button class="btn btn-primary w-100" v-on:click="showTagManageModal()">Manage tags</button>
      </div>
      <div class="column col-auto">
        <a :href="axios.defaults.baseURL + '/notes'" download="notes.json" class="btn w-100">
          <i class="icon icon-download"></i>
        </a>
      </div>
    </div>
    <main class="mt-1">
      <div class="columns col-gapless">
        <div
          v-for="note in filteredNotes"
          v-bind:key="note.id"
          class="soft-transition column col-xs-6 col-sm-4 col-md-3 col-xl-2 col-1"
          v-bind:class="{'w-100': displayType=='list'}"
        >
          <base-note
            :note="note"
            :display="displayType"
            v-on:note-modify="showNoteModifyModal($event)"
            v-on:note-display-content="showNoteContentModal($event)"
            v-on:note-get-childrens="getChildrensNotes($event)"
          ></base-note>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import MainMenu from "../components/menus/MainMenu";
import FilterMenu from "../components/menus/FilterMenu";
import BaseNote from "../components/BaseNote";

import NoteModifyModal from "../components/modals/NoteModifyModal";
import TagManageModal from "../components/modals/TagManageModal";
import NoteContentModal from "../components/modals/NoteContentModal";

import Note from "../models/Note";
import Tag from "../models/Tag";

import NoteService from "../services/NoteService";
import TagService from "../services/TagService";

export default {
  created() {
    TagService.getTags.call(this).then((tags) => {
      this.$root.$data.tags = tags;
    });

    let params = new URLSearchParams(window.location.search);
    if (params.has("folder")) {
      NoteService.search(params.get("folder"), true).then((result) => {
        this.getChildrensNotes(result.id);
      });
    } else {
      this.getRootNotes();
    }

    if (params.has("display")) {
      this.displayType = params.get("display");
    }
  },
  data() {
    return {
      filteredNotes: [],

      displayType: "list",
      showFilters: false,

      parentTree: [],
      isRoot: true
    };
  },
  components: {
    MainMenu,
    FilterMenu,
    BaseNote,
    NoteModifyModal,
    TagManageModal,
    NoteContentModal
  },
  methods: {
    getRootNotes() {
      NoteService.getRootNotes.call(this).then((notes) => {
        this.initNotes(notes, true);
      });
    },
    getChildrensNotes(parentId) {
      NoteService.getChildrensNotes.call(this, parentId).then((notes) => {
        this.initNotes(notes, false);
      });
      NoteService.getNoteParentTree.call(this, parentId).then((parentTree) => {
        this.parentTree = parentTree;
      });
    },

    initNotes(notes, isRoot) {
      this.isRoot = isRoot;
      this.$root.$data.notes = notes;
      this.filteredNotes = this.$root.$data.notes;

      if (isRoot) this.parentTree = [];
    },
    /**
     * Region modal
     */
    showNoteModifyModal(target) {
      this.$refs.noteModifyModal.open(target);
    },
    showTagManageModal(target) {
      this.$refs.tagManageModal.toggle(target);
    },
    showNoteContentModal(target) {
      this.$refs.noteContentModal.toggle(target);
    },
    /** End region */
  },
};
</script>