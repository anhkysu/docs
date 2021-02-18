/**
 * Created by macintosh on 14/3/20.
 */
import { mapGetters } from "vuex";
import CONSTS from "../../../../consts.js";
import moment from "moment";
import socket from "../../../../plugins/socket";

export default {
    components: {},
    name: "InputDataModal",
    props: {
        value: {
            required: true
        },
        loadData: {
            type: Object,
            default: function() {
                return {
                    jointStaffList: [],
                    translatorList: []
                };
            }
        },
        projectInformation: {
            type: Object
        }
    },
    watch: {
        projectInformation: function() {
            this.init();
        },
        value: function() {
            this.init();
        }
    },
    data: function() {
        return {
            dataInputTypeList: window.metaData.dataInputTypeList,
            staffDataStatusList: window.metaData.staffDataStatusList,
            inputData: this._facadeInputDataModel(),
            initialInputData: null, // save this input data on loaded for later compare
            sectionControl: {
                pathRequired: true,
                isCreate: true,
                isUpdate: false,
                allowCreateFolder: true,
                disableAttachFile: false
            },
            currentUser: window.currentUser
        };
    },
    computed: {
        ...mapGetters(["jointStaffList", "ioLoadData"])
    },
    methods: {
        addInputData() {
            var valid = this._validateInputData();
            if (!valid) return;
            this.inputData.project_path = this.projectInformation.project_path;
            this.$store
                .dispatch("CREATE_INPUT_OUTPUT_DATA", this.inputData)
                .then(data => {
                    this.sendNotifications(data);
                    this.$emit("refreshInputData", this.inputData);
                    this.inputData = this._facadeInputDataModel();
                    $("#input-data-modal").modal("hide");
                });
        },
        updateInputData() {
            var valid = this._validateInputData();
            if (!valid) return;
            this.inputData.project_path = this.projectInformation.project_path;
            this.$store
                .dispatch("UPDATE_INPUT_OUTPUT_DATA", this.inputData)
                .then(data => {
                    this.sendNotifications(data);
                    this.$emit("refreshInputData", this.inputData);
                    this.inputData = this._facadeInputDataModel();
                    $("#input-data-modal").modal("hide");
                });
        },
        createDirectoryInput() {
            if (this.inputData.attach_folder) {
                var data_input_type_name = "";
                this.dataInputTypeList.forEach(element => {
                    if (this.inputData.data_input_type == element.id) {
                        data_input_type_name = element.label;
                        return;
                    }
                });
                var $payload = {
                    type: CONSTS.DIRECTORY.DIRECTORY_INPUT,
                    project_path: this.projectInformation.project_path,
                    data_input_type_name: data_input_type_name,
                    project_id: this.projectInformation.id
                };
                this.$store
                    .dispatch("CREATE_DIRECTORY", $payload)
                    .then(data => {
                        this.inputData.path = data.data.data;
                        this.sectionControl.disableAttachFile = true;
                        setTimeout(function() {
                            var copyText = $("#output-path");
                            /* Select the text field */
                            copyText.select();
                            /* Copy the text inside the text field */
                            document.execCommand("copy");
                        }, 2000);
                    });
            } else {
                this.outputData.path = "";
            }
        },
        sendNotifications(data){
            let notifDataArray = data.data.data.notif_data;
            notifDataArray.forEach(item => {
                
                if(item && item.receiverList.length){
                    socket.sendNotificationForIOData(item);
                } 
            })
        },
        sendNotifToRelatedUsers(data) {
            // var receiverList = this.jointStaffList.filter(
            //     item => item.ua_id !== this.currentUser.user_application_id
            // ).map(item => ({
            //     user_application_id: item.ua_id,
            //     user_uuid: item.user_uuid
            // }));
            // var data = {
            //     source_table: "translate",
            //     data_id: this.inputData.translate_id,
            //     sender: window.currentUser.user_application_id,
            //     receiverList: receiverList,
            //     content: CONSTS.NOTIFICATION.CONTENT.QLDA_INPUT_DATA,
            //     action: null
            // };
            // if(this.sectionControl.isCreate){
            //     data.action = this.$t("notification.message.create");
            // } else if(this.sectionControl.isUpdate){
            //     data.action = this.$t("notification.message.update");
            // }
            
        },
        sendNotifToTranslators(data) {
            // if (
            //     this.inputData.translator_suggested ===
            //     this.currentUser.user_application_id
            // )
            //     return;
           
            // var receiverList = this.ioLoadData.data.translatorList
            //     .filter(item => item.id === this.inputData.translator_suggested)
            //     .map(item => ({
            //         user_application_id: item.ua_id,
            //         user_uuid: item.user_uuid
            //     }));

            // var data = {
            //     source_table: "translate",
            //     data_id: this.inputData.translate_id,
            //     sender: window.currentUser.user_application_id,
            //     receiverList: receiverList,
            //     content: CONSTS.NOTIFICATION.CONTENT.TRANSLATE,
            //     action: null
            // };

            // if(this.sectionControl.isCreate){
            //     data.action = this.$t("notification.message.create");
            //     return socket.sendNotificationForIOData(data);
            // }

            // if(this.sectionControl.isUpdate){
            //     if (
            //         this.inputData.staff_data_status ===
            //         CONSTS.IO_CONST.IO_STAFF_DATA_STATUS_IN_PROGRESS_ID
            //     ) {
            //         data.action = this.$t("notification.message.create_or_update");
            //         return socket.sendNotificationForIOData(data);
            //     }
            //     if (
            //         this.inputData.staff_data_status ===
            //         CONSTS.IO_CONST.IO_STAFF_DATA_STATUS_FINISHED_ID
            //     ) {
            //         if (
            //             this.inputData.original_mail ===
            //                 this.initialInputData.original_mail &&
            //             this.inputData.translated_mail ===
            //                 this.initialInputData.translated_mail
            //         )
            //             return;
            //         // At this point, in the old IIMS -> send notification to inputData.sender a message but not insert notification to database -> what the hell
            //         // Controllers-FNhapFileInput.cs
            //         // if(this.inputData.sender !== this.currentUser.user_application_id) {
            //         //     receiverList = this.ioLoadData.data.jointStaffList
            //         //     .filter(item => item.id === this.inputData.sender)
            //         //     .map(item => ({
            //         //         user_application_id: item.ua_id,
            //         //         user_uuid: item.user_uuid
            //         //     }))
            //         //     .concat(receiverList);
            //         // }
            //         data.action = this.$t(
            //             "notification.message.manager_or_staff_change_mail_content"
            //         );
            //         return socket.sendNotificationForIOData(data);
            //     }   
            // }
        },
        attachFileChange() {
            if (!this.inputData.attach_file) {
                this.inputData.attach_folder = false;
            }
        },
        selectDataInputType() {
            //this.inputData.path = '';
            this.inputData.attach_file = false;
            this.inputData.attach_folder = false;
            this.sectionControl.showCreateFolder = true;
            this.sectionControl.disableAttachFile = false;
        },
        closeInputData() {
            this.init();
        },
        init() {
            this.inputData = this._facadeInputDataModel(this.value);
            this.initialInputData = JSON.parse(JSON.stringify(this.inputData));
            this._sectionControlCheck();
        },
        _facadeInputDataModel(data) {
            var now = moment().format("YYYY-MM-DD[T]HH:mm:ss");
            var defaultSender = 0;
            var projectId = 0;
            if (this.projectInformation.project_manager != undefined) {
                defaultSender = this.projectInformation.project_manager;
            }
            if (this.projectInformation.id != undefined) {
                projectId = this.projectInformation.id;
            }
            if (data == null) {
                var inputDataModel = {
                    id: 0,
                    datetime: now,
                    data_status: 0,
                    sender: defaultSender,
                    project_id: projectId,
                    data_input_type:
                        CONSTS.IO_CONST.IO_DATA_INPUT_TYPE_DEFAULT_ID,
                    path: "",
                    attach_file: false,
                    attach_folder: false,
                    name: CONSTS.IO_CONST.IO_DATA_TYPE_NAME_INPUT,
                    subject_mail: "",
                    staff_data_status:
                        CONSTS.IO_CONST.IO_STAFF_DATA_STATUS_IN_PROGRESS_ID,
                    original_mail: "",
                    translated_mail: "",
                    translator: 0,
                    translator_suggested: 0,
                    urgent: false,
                    project_path: "",
                    translate_id: null
                };
                return inputDataModel;
            } else {
                var inputDataModel = {
                    id: data.id,
                    datetime: moment(data.datetime).format(
                        "YYYY-MM-DD[T]HH:mm:ss"
                    ),
                    data_status: data.data_status_id,
                    sender: data.sender_id,
                    project_id: projectId,
                    data_input_type: data.data_type_id,
                    path: data.path,
                    attach_file: data.attach_file,
                    attach_folder: null,
                    name: CONSTS.IO_CONST.IO_DATA_TYPE_NAME_INPUT,
                    subject_mail: data.subject_mail,
                    staff_data_status: data.staff_data_status_id,
                    original_mail: data.original_mail,
                    translated_mail: data.translated_mail,
                    translator: data.translator_id,
                    translator_suggested: data.translator_suggested_id,
                    urgent: false,
                    project_path: "",
                    data_input_type_name: data.data_type,
                    translate_id: data.translate_id
                };
                return inputDataModel;
            }
        },
        _validateInputData() {
            var errorMsg = [];
            if (!this.inputData.sender) {
                errorMsg.push(this.$t("io_data.messages.receiver_required"));
            }
            if (!this.inputData.translator_suggested) {
                errorMsg.push(this.$t("io_data.messages.pdv_required"));
            }
            if (!this.inputData.subject_mail) {
                errorMsg.push(
                    this.$t("io_data.messages.subject_mail_required")
                );
            }
            if (
                this.inputData.attach_file &&
                !this.inputData.path &&
                !this.inputData.attach_folder
            ) {
                errorMsg.push(this.$t("io_data.messages.path_required"));
            }
            if (!this.inputData.original_mail) {
                errorMsg.push(
                    this.$t("io_data.messages.original_mail_required")
                );
            }
            if (errorMsg.length) {
                notification.showWarning(errorMsg);
                return false;
            }

            return true;
        },
        _sectionControlCheck() {
            if (this.inputData.id != 0) {
                this.sectionControl.isCreate = false;
                this.sectionControl.isUpdate = true;
                this.sectionControl.showCreateFolder = false;
                if (this.inputData.path) {
                    this.sectionControl.disableAttachFile = true;
                }
            } else {
                this.sectionControl.isCreate = true;
                this.sectionControl.isUpdate = false;
                this.sectionControl.showCreateFolder = true;
                this.sectionControl.disableAttachFile = false;
            }
        }
    }
};
