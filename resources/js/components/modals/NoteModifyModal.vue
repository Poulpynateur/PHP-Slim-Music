<template>
  <div class="modal modal-lg" v-bind:class="{active: isActive}">
    <a v-on:click="close()" class="modal-overlay" aria-label="Close"></a>
    <div class="modal-container">
      <div class="modal-header">
        <a v-on:click="close()" class="btn btn-clear float-right"></a>
        <div class="modal-title h5">{{ (isUpdate)? 'Update note' : 'New note' }}</div>
      </div>
      <div class="modal-body">
        <div class="content">
          <section class="form-horizontal">
            <div class="form-group">
              <div class="col-2 col-sm-12">
                <label class="form-label">Name</label>
              </div>
              <div class="col-10 col-sm-12">
                <input v-model.trim="note.name" class="form-input" type="text" placeholder="Name" />
              </div>
            </div>
            <div class="form-group">
              <div class="col-2 col-sm-12">
                <label class="form-label">Thumbnail url</label>
              </div>
              <div class="col-10 col-sm-12">
                <input
                  v-model.trim="note.thumbnailUrl"
                  class="form-input"
                  type="text"
                  placeholder="Thumbnail url"
                />
              </div>
            </div>
            <div class="form-group">
              <div class="col-2 col-sm-12">
                <label class="form-label">Url</label>
              </div>
              <div class="col-10 col-sm-12">
                <input v-model.trim="note.url" class="form-input" type="text" placeholder="Url ..." />
              </div>
            </div>
            <div class="form-group">
              <div class="col-2 col-sm-12">
                <label class="form-label">Content</label>
              </div>
              <div class="col-10 col-sm-12">
                <textarea
                  v-model.trim="note.content"
                  class="form-input"
                  placeholder="Content ..."
                  rows="3"
                ></textarea>
              </div>
            </div>
            <div class="form-group">
              <div class="col-2 col-sm-12">
                <label class="form-label">Tags</label>
              </div>
              <div class="col-10 col-sm-12">
                <tag-selector
                  :tags="tags"
                  :selected="note.tags"
                  v-on:selected-tags-update="note.tags = $event"
                ></tag-selector>
              </div>
            </div>
            <div class="form-group">
              <div class="col-2 col-sm-12">
                <label class="form-label">Parent</label>
              </div>
              <div class="col-10 col-sm-12">
                <parent-selector
                  :parentId="parendId"
                  v-on:selected-parent-update="note.parentId = $event"
                ></parent-selector>
              </div>
            </div>
          </section>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn" v-if="!isUpdate" v-on:click="createNote()">create</button>
        <button class="btn" v-if="isUpdate" v-on:click="updateNote()">update</button>
      </div>
    </div>
  </div>
</template>

<script>
import TagSelector from "../TagSelector";
import ParentSelector from "../ParentSelector";

import Note from "../../models/Note";
import NoteService from "../../services/NoteService";

export default {
  props: {
    tags: Array
  },
  data() {
    return {
      isActive: false,
      isUpdate: false,

      note: new Note(),
      // Need to put it out since watch doesn't work on deep props
      parendId: null,
    };
  },
  components: {
    TagSelector,
    ParentSelector,
  },
  methods: {
    resetNote() {
      this.note = new Note();
      this.parendId = this.note.parentId;
    },
    close() {
      this.isActive = false;
    },
    open(note) {
      this.isUpdate = !!note;
      if (this.isUpdate) {
        this.note = note;
        this.parendId = this.note.parentId;
      } else {
        this.resetNote();
      }

      this.isActive = true;
    },
    createNote() {
      NoteService.createNote.call(this, this.note).then(this.resetNote);
    },
    updateNote() {
      NoteService.updateNote.call(this, this.note).then(this.resetNote);
    },
  },
};
</script>