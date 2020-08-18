<style lang="scss">
@import "../../sass/spectre/_variables.scss";
.square {
  position: relative;
  padding-top: 100%;

  .img-container {
    overflow: hidden;
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
  }
}

.list {
  display: flex;
  align-items: center;
  
  border-top-width: 0;
  border-right-width: 0;
  border-left-width: 0;

  .square {
    padding-top: 100px;
    width: 100px;
    margin-right: 0.5rem;
  }
}
.note-container {
  margin:1px;
  border: 1px solid $gray-color-light;
  &.has-children {
    background-color: $gray-color-light;
  }
}

.img-container {
  display: flex;
  width: 100%;
  align-items: center;
  justify-content: center;
  text-align: center;
  border-radius: 0.1rem;
  img {
    object-fit: cover;
    width: 100%;
  }
}
.admin-btn {
  position: absolute;
  right: 0.5rem;
}
</style>

<template>
  <article
    v-bind:class="{'list': display == 'list', 'has-children': note.hasChildren}"
    class="p-relative note-container"
  >
    <div class="square">
      <a class="img-container c-pointer" v-on:click="clickNote()">
        <span v-if="!note.thumbnailUrl || note.hasChildren" class="text-bold">{{note.name}}</span>
        <img v-else class="img-responsive" :src="note.thumbnailUrl" />
      </a>
    </div>
    <div v-if="display == 'list' && !note.hasChildren">
      <span class="card-title h5">{{ note.name }}</span>
      <div>
        <span v-for="tag in note.tags" v-bind:key="tag.id" class="chip">{{ tag.name }}</span>
      </div>
    </div>
    <div v-if="$auth.check() && display == 'list'" class="admin-btn">
      <button class="btn" v-on:click="$emit('note-modify', note)">
        <i class="icon icon-edit"></i>
      </button>
      <button class="btn btn-error" v-on:click="removeNote(note.id)">
        <i class="icon icon-delete"></i>
      </button>
    </div>
  </article>
</template>

<script>
import Note from "../models/Note";
import NoteService from '../services/NoteService';
export default {
  props: {
    note: Note,
    display: String
  },
  methods: {
    removeNote(noteId) {
      NoteService.removeNote.call(this, noteId);
    },
    clickNote() {
      if (!this.note.hasChildren && this.note.content) {
        this.$emit('note-display-content', this.note);
      }
      else if (this.note.hasChildren) {
        this.$emit('note-get-childrens', this.note.id);
      } else if (this.note.url) {
        window.location = this.note.url;
      }
      return false;
    }
  }
};
</script>