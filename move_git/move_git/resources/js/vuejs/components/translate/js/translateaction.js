import { mapGetters } from "vuex";
import CONSTS from "../../../../vuejs/consts";

export default {
    components: {},
    name: "TranslateAction",
    data: function() {
        return {
            translateActionMark: window.metaData.translateActionMark,
            dataInputTypeList: window.metaData.dataInputTypeList,
            dataOutputTypeList: window.metaData.dataOutputTypeList,
            currentUser: window.currentUser,
            translateItemId: this.$route.params.dataId
        };
    },
    mounted() {
        this.getTranslateDataItem();
    },
    computed: {
        ...mapGetters(["translateDataRow"]),
        translateDataItem: function() {
            return this._facadeTranslateDataItemModel(this.translateDataRow);
        }
    },
    methods: {
        updateTranslateDataItem() {
            let newData = this.translateDataItem;
            if(!this._validateTranslateDataItem(newData)){
                return;
            }
            let newTranslateLabel = this.translateActionMark.filter(
                item => newData.data_translate_status === item.id
            )[0].label;
            let payload = {
                typeInfo: CONSTS.TYPE_INFO_TRANSLATE_ACTION,
                translateData: {
                    id: newData.id,
                    data_translate_status: newData.data_translate_status,
                    data_translate_status_label: newTranslateLabel,
                    translator: this.currentUser.user_application_id,
                    translator_short_name: this.currentUser.short_name,
                    original_mail: newData.original_mail,
                    translated_mail: newData.translated_mail,
                    original_file_mail: null,
                    translated_file_mail: null
                },
                inputData: {
                    data_input_type: newData.data_input_type
                }
            };
            this.$store.dispatch("UPDATE_TRANSLATE_DATA_ITEM", payload);
        },
        getTranslateDataItem(){
            if (!this.translateDataItem) {
                let payload = {
                    translateItemId: this.translateItemId,
                    typeInfo: CONSTS.TYPE_INFO_TRANSLATE_ACTION,
                    isFetch: true
                };
                this.$store.dispatch("LOAD_TRANSLATE_DATA_ITEM", payload);
            }
        },
        viewProjectDetailAction(){
            let projectIdString = this.translateDataItem.project_id;
            let dataType = this.translateDataItem.data_type.toLowerCase();
            let ioDataId = this.translateDataItem.io_data_id;

            this.$router.push({
                name: "projectManagement",
                params: { 
                    projectId: projectIdString,
                    tabName: 'input-output-data',
                    paramValue1: ioDataId,
                    paramValue2: dataType
                }
            });
        },
        _validateTranslateDataItem(translateDataItem){
            let errorMsg = [];
            let dataStatusId = translateDataItem.data_status_id;
            let staffDataStatusId = translateDataItem.staff_data_status_id;
            if (
                this.currentUser &&
                (this.currentUser.team === CONSTS.ORGANIZATION.TEAM_BOD ||
                    this.currentUser.team === CONSTS.ORGANIZATION.TEAM_TRANSLATOR)
            ) {
                if (dataStatusId !== CONSTS.IO_CONST.IO_DATA_STATUS_NO_PROGRESS_ID) {
                    errorMsg.push(
                        this.$t(
                            "translate.messages.data_status_is_processed_or_processing"
                        )
                    );
                }
                if (staffDataStatusId !== CONSTS.IO_CONST.IO_STAFF_DATA_STATUS_IN_PROGRESS_ID) {
                    errorMsg.push(
                        this.$t(
                            "translate.messages.staff_data_status_is_finished_or_not_finished_yet"
                        )
                    );
                }
            } else {
                errorMsg.push(this.$t("translate.messages.not_a_translator"));
            }
            if (errorMsg.length > 0) {
                notification.showError(errorMsg);
                return false
            }

            return true;
        },
        _facadeTranslateDataItemModel(data) {
            var mountedData = null;
            if (data) {
                mountedData = {
                    id: data.id,
                    data_status_id:
                        data.input_data_status_id || data.output_data_status_id,
                    staff_data_status_id:
                        data.input_staff_data_status_id ||
                        data.output_staff_data_status_id,
                    data_translate_status: data.data_translate_status,
                    data_translate_status_label: data.data_translate_status_label,
                    project_id:
                        data.input_data_project_id ||
                        data.output_data_project_id,
                    original_mail: data.original_mail,
                    translated_mail: data.translated_mail,
                    data_type: data.data_type,
                    translator_suggested: data.translator_suggested,
                    translator: data.translator,
                    translator_id: data.translator_id,
                    data_path: data.input_data_path || data.output_data_path,
                    data_input_type: data.data_input_type,
                    data_output_type: data.data_output_type,
                    io_data_id: data.input_data_id || data.output_data_id,
                    original_file_mail: null,
                    translated_file_mail: null
                };
            }
            return mountedData;
        },
    }
};
