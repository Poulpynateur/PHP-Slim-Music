import Tag from './Tag';

export default class Note {
    constructor(data = {}) {
        this.id = data.id || null;
        this.name = data.name || '';
        this.thumbnailUrl =  data.thumbnail_url || '';
        this.url = data.url || '';
        this.tags = data.tags || [];
        this.parentId = data.parent_id || null;
        this.hasChildren = data.has_children || false;
        this.content = data.content || "";
    };
};