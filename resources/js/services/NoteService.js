import Note from '../models/Note';

export default {
    get(id) {
        axios.get("/notes/" + id).then((response) => {
            return response.data;
        });
    },
    getRootNotes() {
        return axios.get('/notes/root').then((response) => {
            return response.data.map(data => new Note(data));
        });
    },
    getChildrensNotes(parentId) {
        return axios.get('/notes/' + parentId + '/childrens').then((response) => {
            return response.data.map(data => new Note(data));
        });
    },
    createNote(note) {
        return axios.post("/notes", note).then((response) => {
            this.$notify({
                type: "toast-success",
                text: response.data.message,
            });
            this.$root.$data.notes.push(new Note(response.data.result));
        }).catch((error) => {
            console.log(error.response);
            this.$notify({
                type: "toast-error",
                text: error.response.data.message,
            });
        });
    },
    updateNote(note) {
        return axios.put("/notes/" + note.id, note).then((response) => {
            this.$notify({
                type: "toast-success",
                text: response.data.message,
            });
            let index = this.$root.$data.notes.findIndex((e) => e.id == note.id);
            this.$root.$data.notes[index] = note;
        }).catch((error) => {
            console.log(error.response);
            this.$notify({
                type: "toast-error",
                text: error.response.data.message,
            });
        });
    },
    removeNote(id) {
        axios.delete("/notes/" + id).then((response) => {
            this.$notify({
                type: "toast-success",
                text: response.data.message,
            });
            this.$root.$data.notes.splice(
                this.$root.$data.notes.findIndex((e) => e.id == id),
                1
            );
        }).catch((error) => {
            console.log(error.response);
            this.$notify({
                type: "toast-error",
                text: error.response.data.message,
            });
        });
    },
    getNoteParentTree(id) {
        return axios.get('/notes/'+ id +'/tree').then((response) => {
            return response.data;
        });
    },
    search(name, hasChildren) {
        if (hasChildren) {
            return axios.get("/search/notes", {params: { name: name, hasChildren: true }}).then((response) => {
                return response.data;
            });
        }
        return axios.get("/search/notes", {params: { name: name }}).then((response) => {
            return response.data;
        });
    }
};