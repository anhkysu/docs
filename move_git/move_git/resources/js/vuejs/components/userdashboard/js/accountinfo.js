import { mapGetters } from "vuex";
import CONSTS from '../../../consts.js';
import ProjectManagementNotif from '../template/partials/ProjectManagementNotif';

export default {
    components: {
        ProjectManagementNotif
    },
    name: "AccountInfo",
    props: {
      
    },
    watch: {
        
    },
    data: function () {
        return {
           currentUser: window.currentUser,
           accountInformation: this._facadeAccountInfo(),
           password: {
               new: '',
               confirm: ''
           }
        }
    },
    mounted() {
        this.init();
    },
    methods: {
        init(value){
            this.accountInformation = this._facadeAccountInfo(value);
            this.getAccountInformation();
        },
        getAccountInformation(){
            let payload = {
                staffUUID: this.currentUser.staff_uuid,
            };
            this.$store.dispatch('GET_ACCOUNT_INFORMATION', payload).then(data => {
                this.accountInformation = this._facadeAccountInfo(data.data.accountData);
            });
        },
        changePassword(){
            let pwd = this.password;
            let valid = this._validatePasswords(pwd);
            if(!valid) return;
            let payload = {
                account_id: this.accountInformation.account_id,
                staffUUID: this.currentUser.staff_uuid,
                new_password: pwd.new,
                confirm_password: pwd.confirm
            };
            this.$store.dispatch('UPDATE_ACCOUNT_INFORMATION', payload).then(data => {
                this.password.new = '';
                this.password.confirm = '';
            });
        },
        _validatePasswords(password){
            let msgList = [];
            if(password.new.length < 8 || password.confirm.length < 8){
                msgList.push(this.$t('user_dashboard.messages.password_not_strong_enough'));
            }
            if(password.new !== password.confirm){
                msgList.push(this.$t('user_dashboard.messages.passwords_did_not_match'));
            }
            if(msgList.length){
                notification.showError(msgList);
                return false;
            } 
            return true;
        },
        _facadeAccountInfo(data){
            if(!data){
                let accountInfo = {
                    account_id: null,
                    username: '',
                    display_name: '',
                    account_type: ''
                }
                return accountInfo;
            } else {
                let accountInfo = {
                    account_id: data.account_id,
                    username: data.username,
                    display_name: data.display_name || '',
                    account_type: data.account_type
                };
                return accountInfo;
            }
        }
    }
};