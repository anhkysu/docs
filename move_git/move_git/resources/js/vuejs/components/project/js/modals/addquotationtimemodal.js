/**
 * Created by macintosh on 14/3/20.
 */
import { mapGetters } from "vuex";
import CONSTS from '../../../../consts.js';
import Utility from '../../../../plugins/utility.js';

export default {
    components: {

    },
    name: "AddQuotationTimeModal",
    props: {
        projectInformation: {
            type: Object,
        }
    },
    watch: {
        projectInformation: function () {
            this.init();
        },
        value: function(){
            this.init();
        }
    },
    data: function () {
        return {
            workingFactorList: window.metaData.workingFactorList,
            quotationTime: this._facadeQuotationTimeModel(),
            quotationTimeRegisterList: [],
            notification: this.$t('quotation_time.messages.notification_area'),
        }
    },
    methods: {
        addQuotationTimeList(){
            var valid = this._validateQuotationTimeList();
            if(!valid) return;

            var payload ={
                quotationTimeList: this.quotationTimeRegisterList
            }
            this.$store.dispatch("CREATE_QUOTATION_TIME_LIST", payload).then((data) => {
                this.$emit('refreshQuotationTimeList', payload);
                this.closeQuotationTime();
              });
        },
        timeOfQuotationConvert(type){
            switch(type){
                case 'minute':
                    this.quotationTime.estimate_time = Utility.convertTimeToUnit(this.quotationTime.estimate_time_hour, 'hour', 'minute');
                    break;
                case 'hour':
                    this.quotationTime.estimate_time_hour = Utility.convertTimeToUnit(this.quotationTime.estimate_time, 'minute', 'hour');
                    break;    
            }
        },
        registerQuotationTime(){
            var valid = this._validateQuotationTime();
            if(!valid) return;

            this.quotationTimeRegisterList.push(this.quotationTime);
            this.quotationTime = this._facadeQuotationTimeModel();
            var numQuotationTimeRegiested = this.quotationTimeRegisterList.length;
            this.notification = this.$t('quotation_time.messages.number_quotation_time_registered').replace('@number', numQuotationTimeRegiested);
        },
        deleteQuotationTimeRegister(index){
            this.quotationTimeRegisterList.splice(index, 1);
        },
        closeQuotationTime(){
            this.init();
            $('#add-quotation-time-modal').modal('hide');
        },
        init() {
            this.quotationTime = this._facadeQuotationTimeModel();
            this.quotationTimeRegisterList = [];
            this.notification = this.$t('quotation_time.messages.notification_area');
        },
        _facadeQuotationTimeModel(data) {
            if(!data){
                var quotationTimeModal = {
                    id: 0,
                    project_id: this.projectInformation.id,
                    working_factor: CONSTS.QUOTATION_TIME.WORKING_FACTOR_I_ID,
                    unit: '',
                    dwg_name: '',
                    estimate_time: 0.00,
                    estimate_time_hour: 0.00,
                    note: ''
                }

                return quotationTimeModal;
            }
        },
        _validateQuotationTime(){
            var errorMsg = [];
            if(!this.quotationTime.working_factor){
                errorMsg.push(this.$t('quotation_time.messages.working_factor_required'));
            }
            if(!this.quotationTime.unit){
                errorMsg.push(this.$t('quotation_time.messages.unit_required'));
            }
            if(!this.quotationTime.dwg_name){
                errorMsg.push(this.$t('quotation_time.messages.dwg_name_required'));
            }
            
            if(errorMsg.length){
                notification.showWarning(errorMsg);
                return false;
            }
            
            return true;
        },
        _validateQuotationTimeList(){
            var errorMsg = [];
            this.quotationTimeRegisterList.forEach(quotationTime => {
                if(!quotationTime.working_factor){
                    errorMsg.push(this.$t('quotation_time.messages.working_factor_required'));
                }
                if(!quotationTime.unit){
                    errorMsg.push(this.$t('quotation_time.messages.unit_required'));
                }
                if(!quotationTime.dwg_name){
                    errorMsg.push(this.$t('quotation_time.messages.dwg_name_required'));
                }
                if(errorMsg.length > 0){
                    return;
                }
            });
            
            if(this.quotationTimeRegisterList.length == 0){
                errorMsg.push(this.$t('quotation_time.messages.quotation_time_list_required'));
            }
            if(errorMsg.length){
                notification.showWarning(errorMsg);
                return false;
            }
            
            return true;
        },
    }
};