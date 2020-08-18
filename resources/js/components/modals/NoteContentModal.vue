<template>
  <div class="modal modal-lg" :class="{active: isActive}">
    <a class="modal-overlay"></a>
    <div class="modal-container">
      <div class="modal-header">
        <a v-on:click="toggle()" class="btn btn-clear float-right"></a>
        <div class="modal-title h5">{{ note.name }}</div>
      </div>
      <div class="modal-body" v-html="converter.makeHtml(note.content)">
      </div>
    </div>
  </div>
</template>

<script>
import Note from "../../models/Note";
import showdown from 'showdown';
export default {
  data() {
    return {
      isActive: false,
      converter: new showdown.Converter(),
      note: Note
    };
  },
  methods: {
    toggle(target) {
      this.isActive = !this.isActive;
      if (target)
        this.note = target;
    }
  }
};
</script>