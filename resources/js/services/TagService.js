import Tag from '../models/Tag';
/**
 * Passing the whole component and store the elements in $root is probably not the cleanest
 * But it sure as heck reduce the whole complexity (anyway the whole app is based on these so probably better than bubble events everywhere)
 */
export default {
    getTags() {
        return axios.get("/tags").then((response) => {
            return response.data.map(data => new Tag(data));
        });
    },
    createTag(tag) {
        return axios.post("/tags", tag).then((response) => {
            this.$notify({
                type: "toast-success",
                text: response.data.message,
            });
            this.$root.$data.tags.push(new Tag(response.data.result));
            tag = new Tag();
        }).catch((error) => {
            console.log(error.response);
            this.$notify({
                type: "toast-error",
                text: error.response.data.message,
            });
        });
    },
    removeTag(id) {
        return axios.delete("/tags/" + id).then((response) => {
            this.$notify({
                type: "toast-success",
                text: response.data.message,
            });
            this.$root.$data.tags.splice(
                this.$root.$data.tags.findIndex((e) => e.id == id),
                1
            );
        }).catch((response) => {
            this.$notify({
                type: "toast-error",
                text: response.data.message,
            });
        });
    }
};