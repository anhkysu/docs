import { mapGetters } from "vuex";
import CONSTS from "../../../consts.js";

export default {
    components: {},
    name: "PersonalInfo",
    props: {},
    watch: {},
    data: function() {
        return {
            currentUser: window.currentUser,
            staffInformation: this._facadeStaffInformation()
        };
    },
    mounted() {
        this.init();
    },
    computed: {},
    methods: {
        getStaffInformation() {
            let staffUUID = currentUser.staff_uuid;
            let payload = { staffUUID };
            this.$store
                .dispatch("GET_STAFF_INFORMATION", payload)
                .then(data => {
                    this.staffInformation = this._facadeStaffInformation(
                        data.data.staffInformation
                    );
                });
        },
        init(value) {
            this.staffInformation = this._facadeStaffInformation(value);
            this.getStaffInformation();
        },
        refresh(){
            window.location.reload();
        },
        changeAvatar() {
            $("#upload-avatar").trigger("click");
        },
        saveSlogan() {
            let that = this;
            let newSlogan = this.staffInformation.slogan;
            if (!newSlogan) return;
            let payload = {
                staffUUID: this.currentUser.staff_uuid,
                staffInformation: {
                    slogan: newSlogan
                }
            };
            this.$store.dispatch("UPDATE_STAFF_INFORMATION", payload).then(data => {
                window.currentUser.slogan = data.slogan;
            });
        },
        onUploadFileChange(e) {
            let that = this;
            let files = e.target.files;
            if (!files.length) return;
            if (files[0].size >= 3000000) {
                notification.showError([this.$t('base.file_too_large')]);
                return;
            };
            let avatarData = new FormData();
            avatarData.append("avatar", files[0]);
            let payload = {
                staffUUID: this.currentUser.staff_uuid,
                data: avatarData
            };
            this.$store.dispatch("UPDATE_AVATAR", payload).then(data => {
                window.currentUser.avatar = data;
            });
        },
        _facadeStaffInformation(data) {
            if (!data) {
                var staffInformation = {
                    staff_id: "",
                    first_name: "",
                    last_name: "",
                    short_name: "",
                    status_label: "",
                    team_label: "",
                    working_sign_date: null,
                    contract_sign_date: null,
                    contract_end_date: null,
                    job_title_label: "",
                    slogan: ""
                };
                return staffInformation;
            } else {
                var staffInformation = {
                    staff_id: data.staff_id,
                    first_name: data.first_name,
                    last_name: data.last_name,
                    short_name: data.short_name,
                    status_label: data.status_label,
                    team_label: data.team_label,
                    working_sign_date: data.working_sign_date,
                    contract_sign_date: data.contract_sign_date,
                    contract_end_date: data.contract_end_date,
                    job_title_label: data.job_title_label,
                    slogan: data.slogan
                };
                return staffInformation;
            }
        }
    }
};
