/**
 * Created by macintosh on 14/3/20.
 */
import { mapGetters } from "vuex";

import CollectionItem from '../template/CollectionItem.vue';

export default {
    components: {
        CollectionItem
    },
    name: "CollectionList",
    props: [],
    mounted() {
        this.getCollectionList();
    },

    computed: {
        ...mapGetters(["collectionList"]),
    },
    methods: {
        getCollectionList() {
            this.$store.dispatch("GET_COLLECTION_LIST");
        }
    }
};