import CONSTS from '../../../../consts.js';

export default {
    components: {

    },
    name: "EditTechnicalErrorModal",
    props: {
        projectInformation: {
            type: Object
        },
        value: {
            required: true
        },
        outputDataLinkList: {
            type: Array
        }
    },
    watch: {
        value: function(){
            this.init();
        },
        outputDataLinkList: function(value){
            this.abbreviatedOutputDataLinkList = value.map(item => {
                if(item.path){
                    let newPathChunks = item.path.split("\\");
                    let newPath = newPathChunks[newPathChunks.length - 1];
                    return ({...item, path: newPath});
                } else {
                    return item
                }
            });
        },
        "technicalError.type_of_work": function() {
            this._filterErrorTemplateGroupList();
        },
        "technicalError.error_group": function() {
            this._filterErrorTemplateList();
        },
        "technicalError.error_id": function(value) {
            let selected = this.filteredErrorTemplateList.filter(
                item => item.id === value
            );
            if (selected.length === 0) {
                this.technicalError.error_id_string = "";
            } else {
                this.technicalError.error_id_string = selected[0].error_id;
            }
        }
    },
    data: function () {
        return {
            technicalError: this._facadeTechnicalErrorModel(),
            typeOfWorkList: window.metaData.typeOfWorkList,
            errorTemplateList: window.metaData.technicalErrorTemplateList,
            filteredErrorTemplateList: [],
            errorTemplateGroupList: window.metaData.errorTemplateGroupList,
            filteredErrorTemplateGroupList: [],
            abbreviatedOutputDataLinkList: []
        }
    },
    methods: {
        updateTechnicalError(){
            var valid = this._validateTechnicalError();
            if(!valid) return;

            this.$store.dispatch("UPDATE_TECHNICAL_ERROR", this.technicalError).then((data) => {
                let newInputDate = data.data.data.input_date.date;
                this.$emit('updateTechnicalErrorGrid', {...this.technicalError, input_date: newInputDate});
                this.closeTechnicalError();
              });
        },
        closeTechnicalError(){
            this.init();
            $('#edit-technical-error-modal').modal('hide');
        },
        init() {
            this.technicalError = this._facadeTechnicalErrorModel(this.value);
        },
        _filterErrorTemplateGroupList() {
            let filteredList = this.errorTemplateGroupList.filter(
                errorTemplateGroup => {
                    let errorTemplateGroupInErrorTemplateList = this.errorTemplateList.filter(
                        errorTemplate =>
                            errorTemplate.type_of_work ===
                                this.technicalError.type_of_work &&
                            errorTemplate.error_group ===
                                errorTemplateGroup.label
                    );
                    if (!errorTemplateGroupInErrorTemplateList.length) {
                        return false;
                    }
                    return true;
                }
            );
            if (filteredList.length !== 0) {
                let isSelectedErrorGroupInsideList = filteredList.filter(item => item.label === this.technicalError.error_group).length;
                if(!isSelectedErrorGroupInsideList){
                    this.technicalError.error_group = filteredList[0].label;
                } 
            } else {
                this.technicalError.error_group = "";
            }
            this.filteredErrorTemplateGroupList = filteredList;
            this._filterErrorTemplateList();
        },
        _filterErrorTemplateList() {
            let filteredList = this.errorTemplateList.filter(
                errorTemplate =>
                    errorTemplate.error_group ===
                        this.technicalError.error_group &&
                    errorTemplate.type_of_work ===
                        this.technicalError.type_of_work
            );
           
            if (filteredList.length !== 0) {
                let isSelectedTechnicalErrorInsideList = filteredList.filter(item => item.id === this.technicalError.error_id).length;
                if(!isSelectedTechnicalErrorInsideList){
                    this.technicalError.error_id = filteredList[0].id;
                } 
            } else {
                this.technicalError.error_id = null;
            }
            this.filteredErrorTemplateList = filteredList;
        },
        _facadeTechnicalErrorModel(data) {
            if(!data){
                var technicalErrorModel = {
                    project_id: this.projectInformation.id,
                    discoverer: CONSTS.LOAD_DATA_OPTION_BY_COMPANY,
                    violator: currentUser.user_application_id,
                    times: 1,
                    error_id: null,
                    error_id_string: "",
                    type_of_work: null,
                    error_group: null,
                    output_data_id: null
                }
                return technicalErrorModel;
            } else {
                var technicalErrorModel = {
                    id: data.id,
                    project_id: data.project_id,
                    discoverer: data.discoverer,
                    violator: currentUser.user_application_id,
                    times: data.times,
                    error_id: data.error_id,
                    error_id_string: data.error_id_string,
                    type_of_work: data.type_of_work,
                    error_group: data.error_group,
                    output_data_id: data.output_data_id
                }
                return technicalErrorModel;
            }
        },
        _validateTechnicalError(){
            var errorMsg = [];
            if(this.technicalError.times == 0){
                errorMsg.push(this.$t('technical_error.messages.times_other_than_zero'));
            }
            if(!this.technicalError.output_data_id){
                errorMsg.push(this.$t('technical_error.messages.output_data_link_not_acceptable'));
            }
            if(errorMsg.length){
                notification.showWarning(errorMsg);
                return false;
            }
            
            return true;
        },
    }
};