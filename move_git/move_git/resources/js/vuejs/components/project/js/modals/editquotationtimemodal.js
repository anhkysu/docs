import CONSTS from '../../../../consts.js';
import Utility from '../../../../plugins/utility.js';

export default {
    components: {

    },
    name: "EditQuotationTimeModal",
    props: {
        value: {
            required: true
        },
    },
    watch: {
        value: function(){
            this.init();
        }
    },
    data: function () {
        return {
            workingFactorList: window.metaData.workingFactorList,
            quotationTime: this._facadeQuotationTimeModel()
        }
    },
    methods: {
        updateQuotationTime(){
            var valid = this._validateQuotationTime();
            if(!valid) return;

            this.$store.dispatch("UPDATE_QUOTATION_TIME", this.quotationTime).then((data) => {
                this.$emit('updateQuotationTimeGrid', this.quotationTime);
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
        closeQuotationTime(){
            this.init();
            $('#edit-quotation-time-modal').modal('hide');
        },
        init() {
            this.quotationTime = this._facadeQuotationTimeModel(this.value);
        },
        _facadeQuotationTimeModel(data) {
            if(!data){
                var quotationTimeModal = {
                    id: 0,
                    project_id: 0,
                    working_factor: CONSTS.QUOTATION_TIME.WORKING_FACTOR_I_ID,
                    unit: '',
                    dwg_name: '',
                    estimate_time: 0.00,
                    estimate_time_hour: 0.00,
                    note: ''
                }

                return quotationTimeModal;
            }else{
                var quotationTimeModal = {
                    id: data.id,
                    project_id: data.project_id,
                    working_factor: data.working_factor_id,
                    unit: data.unit,
                    dwg_name: data.dwg_name,
                    estimate_time: data.estimate_time,
                    estimate_time_hour: Utility.convertTimeToUnit(data.estimate_time, 'minute', 'hour'),
                    note: data.note
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
    }
};