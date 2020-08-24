<template>
  <section>
    <input class="form-input mb-1" type="text" placeholder="Filter name ..." v-model="filterName">
    <tag-selector class="mb-1" :tags="tags" v-on:update-selected-tags="updateFilterTags($event)"></tag-selector>
  </section>
</template>

<script>
import TagSelector from '../TagSelector';
export default {
  props: {
    notes: Array,
    tags: Array
  },
  components: {
    TagSelector
  },
  data() {
    return {
      filterName: "",
      filterTagsId: []
    };
  },
  methods: {
    updateFilterTags(tags) {
      this.filterTagsId = tags.map((t) => t.id);
      this.filter();
    },
    checkTags(tags) {
      for(var filterTagId of this.filterTagsId) {
        if (!tags.some(t => t.id == filterTagId))
          return false;
      }
      return true;
    },
    filter() {
      let filtered = this.notes.filter((note) => {
        return note.name.toLowerCase().includes(this.filterName.toLowerCase()) && this.checkTags(note.tags);
      });
      this.$emit('update-filtered-notes', filtered);
    }
    
  },
  watch: {
    filterName() {
      this.filter();
    }
  }
};
</script>