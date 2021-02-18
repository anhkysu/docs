import CONSTS from "../../../../consts.js";

export default {
    components: {},
    name: "AddTechnicalErrorModal",
    props: {
        projectInformation: {
            type: Object
        },
        outputDataLinkList: {
            type: Array
        }
    },
    watch: {
        projectInformation: function() {
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
        }
    },
    data: function() {
        return {
            typeOfWorkList: window.metaData.typeOfWorkList,
            errorTemplateList: window.metaData.technicalErrorTemplateList,
            filteredErrorTemplateList: [],
            errorTemplateGroupList: window.metaData.errorTemplateGroupList,
            filteredErrorTemplateGroupList: [],
            technicalError: this._facadeTechnicalErrorModel(),
            technicalErrorRegisterList: [],
            notification: this.$t("quotation_time.messages.notification_area"),
            currentUser: window.currentUser,
            abbreviatedOutputDataLinkList: []
        };
    },
    computed: {
        errorIdString: function(){
             let selected = this.filteredErrorTemplateList.filter(
                item => item.id === this.technicalError.error_id
            );
            if (selected.length === 0) {
                this.technicalError.error_id_string = "";
                return this.technicalError.error_id_string;
            } else {
                this.technicalError.error_id_string = selected[0].error_id;
                return this.technicalError.error_id_string;
            }
        }
    },
    methods: {
        addTechnicalErrorList() {
            var valid = this._validateTechnicalErrorList();
            if (!valid) return;
            var payload = {
                technicalErrorList: this.technicalErrorRegisterList
            };
            this.$store
                .dispatch("CREATE_TECHNICAL_ERROR_LIST", payload)
                .then(data => {
                    this.$emit("refreshTechnicalErrorList", payload);
                    this.closeTechnicalErrorModal();
                });
        },
        registerTechnicalError() {
            var valid = this._validateTechnicalError();
            if (!valid) return;
            this.technicalErrorRegisterList.push(this.technicalError);
            this.technicalError = this._facadeTechnicalErrorModel();
            this._filterErrorTemplateGroupList();
            var numTechnicalErrorRegistered = this.technicalErrorRegisterList
                .length;
            this.notification = this.$t(
                "technical_error.messages.number_technical_error_registered"
            ).replace("@number", numTechnicalErrorRegistered);
        },
        deleteTechnicalErrorRegister(index) {
            this.technicalErrorRegisterList.splice(index, 1);
        },
        closeTechnicalErrorModal() {
            this.init();
            $("#add-technical-error-modal").modal("hide");
        },
        init() {
            this.technicalErrorRegisterList = [];
            this.technicalError = this._facadeTechnicalErrorModel();
            this._filterErrorTemplateGroupList();
            this.notification = this.$t(
                "quotation_time.messages.notification_area"
            );
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
                this.technicalError.error_group = filteredList[0].label;
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
                this.technicalError.error_id = filteredList[0].id;
            } else {
                this.technicalError.error_id = null;
            }
            this.filteredErrorTemplateList = filteredList;
        },
        _facadeTechnicalErrorModel(data) {
            let defaultTypeOfWork = !window.metaData.typeOfWorkList.length ? null : window.metaData.typeOfWorkList[0].label;
            if (!data) {
                var technicalErrorModel = {
                    project_id: this.projectInformation.id,
                    discoverer: CONSTS.LOAD_DATA_OPTION_BY_COMPANY,
                    violator: currentUser.user_application_id,
                    times: 1,
                    error_id: null,
                    error_id_string: "",
                    type_of_work: defaultTypeOfWork,
                    error_group: null,
                    output_data_id: null
                };
                return technicalErrorModel;
            }
        },
        _validateTechnicalError() {
            var errorMsg = [];
            if (this.technicalError.times == 0) {
                errorMsg.push(
                    this.$t("technical_error.messages.times_other_than_zero")
                );
            }
            if (!this.technicalError.output_data_id) {
                errorMsg.push(
                    this.$t(
                        "technical_error.messages.output_data_link_not_acceptable"
                    )
                );
            }
            if (errorMsg.length) {
                notification.showWarning(errorMsg);
                return false;
            }

            return true;
        },
        _validateTechnicalErrorList() {
            var errorMsg = [];
            this.technicalErrorRegisterList.forEach(technicalError => {
                if (technicalError.times == 0) {
                    errorMsg.push(
                        this.$t(
                            "technical_error.messages.times_other_than_zero"
                        )
                    );
                }
                if (!technicalError.output_data_id) {
                    errorMsg.push(
                        this.$t(
                            "technical_error.messages.output_data_link_not_acceptable"
                        )
                    );
                }
                if (errorMsg.length > 0) {
                    return;
                }
            });

            if (this.technicalErrorRegisterList.length == 0) {
                errorMsg.push(
                    this.$t(
                        "technical_error.messages.technical_error_list_required"
                    )
                );
            }
            if (errorMsg.length) {
                notification.showWarning(errorMsg);
                return false;
            }

            return true;
        }
    }
};
