/**
 * Created by macintosh on 14/3/20.
 */
import { mapGetters } from "vuex";
import QaQcDataList from '../template/partials/QaQcDataList';
import QcAction from '../template/partials/QcAction';
import QaAction from '../template/partials/QaAction';

export default {
    components: {
        "qaqc-data-list": QaQcDataList,
        QcAction,
        QaAction
    },
    name: "QualityManagement",
    props: [],
    mounted() {
        
    },

    computed: {

    },
    methods: {

    }
};