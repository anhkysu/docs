/**
 * Created by macintosh on 14/3/20.
 */
import { mapGetters } from "vuex";
import Notification from '../template/partials/Notification.vue';
import PersonalInfo from '../template/partials/PersonalInfo.vue';
import AccountInfo from '../template/partials/AccountInfo.vue';
import PersonalWorkDone from '../template/partials/PersonalWorkDone.vue';
import PersonalProductivity from '../template/partials/PersonalProductivity.vue';
import PersonalError from '../template/partials/PersonalError.vue';
import Quotes from '../template/partials/Quotes.vue';

export default {
    components: {
        Notification,
        PersonalInfo,
        AccountInfo,
        'personal-work-done': PersonalWorkDone,
        'personal-productivity': PersonalProductivity,
        PersonalError,
        Quotes
    },  
    name: "UserDashBoard",
    props: ['explanation'],
    data: function () {
        return {
           currentUser: window.currentUser,
        }
    },
    mounted() {
        
    },
    computed: {

    },
    methods: {
        
    }
};