export default class Tag {
    constructor(data = {}) {
        this.id = data.id || null;
        this.name = data.name || '';
    };
};