export default class Newapp {
    constructor(obj) {
        this.name = obj.name;
        this.fileList = [
            {
                url: obj.appversion[0].file,
                name: obj.name
            }
        ];
        this.app_id = obj.appversion[0].app_id;
        this.content = obj.appversion[0].content;
        this.version_name = obj.appversion[0].version_name;
    }
}
