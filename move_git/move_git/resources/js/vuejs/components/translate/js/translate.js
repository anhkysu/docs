import { mapGetters } from "vuex";

export default {
    name: "Translate",
    computed: {
        ...mapGetters(["translateDataRow"]),
        translatingDataId() {
            return this.translateDataRow ? this.translateDataRow.id : 0;
        }
    }
};
