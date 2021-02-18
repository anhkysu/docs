/**
 * Created by macintosh on 14/3/20.
 */
import { mapGetters } from "vuex";
import CONSTS from "../../../../consts.js";
import moment from "moment";
import socket from "../../../../plugins/socket";

export default {
    components: {},
    name: "OutputDataModal",
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
            dataOutputTypeList: window.metaData.dataOutputTypeList,
            staffDataStatusList: window.metaData.staffDataStatusList,
            initialOutputData: null,
            outputData: this._facadeOutputDataModel(),
            sectionControl: {
                pathRequired: true,
                isCreate: true,
                isUpdate: false
            },
            currentUser: window.currentUser
        };
    },
    computed: {
        ...mapGetters(["jointStaffList", "ioLoadData"])
    },
    methods: {
        addOutputData() {
            var valid = this._validateOutputData();
            if (!valid) return;

            this.outputData.project_path = this.projectInformation.project_path;
            this.dataOutputTypeList.forEach(element => {
                if (this.outputData.data_output_type == element.id) {
                    this.outputData.data_output_type_name = element.label;
                    return;
                }
            });
            this.$store
                .dispatch("CREATE_INPUT_OUTPUT_DATA", this.outputData)
                .then(data => {
                    this.outputData.translate_id = data.data.data.translate_id;
                    this.sendNotifToManagers();
                    this.sendNotifToTranslators();
                    this.$emit("refreshOutputData", this.outputData);
                    this.outputData = this._facadeOutputDataModel();
                    $("#output-data-modal").modal("hide");
                });
        },
        updateOutputData() {
            var valid = this._validateOutputData();
            if (!valid) return;

            this.outputData.project_path = this.projectInformation.project_path;
            this.dataOutputTypeList.forEach(element => {
                if (this.outputData.data_output_type == element.id) {
                    this.outputData.data_output_type_name = element.label;
                    return;
                }
            });
            this.$store
                .dispatch("UPDATE_INPUT_OUTPUT_DATA", this.outputData)
                .then(data => {
                    this.sendNotifToManagers();
                    this.sendNotifToTranslators();
                    this.$emit("refreshOutputData", this.outputData);
                    this.outputData = this._facadeOutputDataModel();
                    $("#output-data-modal").modal("hide");
                });
        },
        createDirectoryOutput() {
            if (this.outputData.attach_folder) {
                var $payload = {
                    type: CONSTS.DIRECTORY.DIRECTORY_OUTPUT,
                    project_path: this.projectInformation.project_path,
                    data_output_type: this.outputData.data_output_type,
                    project_id: this.projectInformation.id,
                    project_code: this.projectInformation.project_id
                };
                this.$store
                    .dispatch("CREATE_DIRECTORY", $payload)
                    .then(data => {
                        this.outputData.path = data.data.data;
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
        sendNotifToManagers() {
            if (
                this.projectInformation.team_manager ===
                this.currentUser.user_application_id
            )
                return;
            var receiverList = this.ioLoadData.data.translatorList
                .filter(
                    item =>
                        item.id === this.projectInformation.team_manager
                )
                .map(item => ({
                    user_application_id: item.ua_id,
                    user_uuid: item.user_uuid
                }));
            var data = {
                source_table: "translate",
                data_id: this.outputData.translate_id,
                sender: window.currentUser.user_application_id,
                receiverList: receiverList,
                content: CONSTS.NOTIFICATION.CONTENT.QLDA_OUTPUT_DATA,
                action: null
            };
            if(this.sectionControl.isCreate){
                data.action = this.$t("notification.message.create");
            } else if(this.sectionControl.isUpdate){
                data.action = this.$t("notification.message.update");
            }
            socket.sendNotificationForIOData(data);
            if (
                this.projectInformation.project_manager ===
                this.currentUser.user_application_id
            )
                return;
            receiverList = this.ioLoadData.data.jointStaffList
                .filter(
                    item =>
                        item.id === this.projectInformation.project_manager
                )
                .map(item => ({
                    user_application_id: item.ua_id,
                    user_uuid: item.user_uuid
                }));
            data.receiverList = receiverList;
            socket.sendNotificationForIOData(data);
        },
        sendNotifToTranslators() {
            if (
                this.outputData.translator_suggested ===
                this.currentUser.user_application_id
            )
                return;
            var receiverList = this.ioLoadData.data.translatorList
                .filter(
                    item => item.id === this.outputData.translator_suggested
                )
                .map(item => ({
                    user_application_id: item.ua_id,
                    user_uuid: item.user_uuid
                }));
            var data = {
                source_table: "translate",
                data_id: this.outputData.translate_id,
                sender: window.currentUser.user_application_id,
                receiverList: receiverList,
                content: CONSTS.NOTIFICATION.CONTENT.TRANSLATE,
                action: null
            };

            if(this.sectionControl.isCreate){
                data.action = this.$t("notification.message.create");
                return socket.sendNotificationForIOData(data);
            }

            if(this.sectionControl.isUpdate){
                if (
                    this.outputData.staff_data_status ===
                    CONSTS.IO_CONST.IO_STAFF_DATA_STATUS_IN_PROGRESS_ID
                ) {
                    data.action = this.$t("notification.message.create_or_update");
                    return socket.sendNotificationForIOData(data);
                }
                if (
                    this.outputData.staff_data_status ===
                    CONSTS.IO_CONST.IO_STAFF_DATA_STATUS_FINISHED_ID
                ) {
                    if (
                        this.outputData.original_mail ===
                            this.initialOutputData.original_mail &&
                        this.outputData.translated_mail ===
                            this.initialOutputData.translated_mail
                    )
                        return;
                    // At this point, in the old IIMS -> send notification to outputData.sender a message but not insert notification to database -> what the hell
                    // Controllers-FNhapFileInput.cs
                    // if(this.outputData.sender !== this.currentUser.user_application_id) {
                    //     receiverList = this.ioLoadData.data.jointStaffList
                    //     .filter(item => item.id === this.outputData.sender)
                    //     .map(item => ({
                    //         user_application_id: item.ua_id,
                    //         user_uuid: item.user_uuid
                    //     }))
                    //     .concat(receiverList);
                    // }
                    data.action = this.$t(
                        "notification.message.manager_or_staff_change_mail_content"
                    );
                    return socket.sendNotificationForIOData(data);
                }
            }
        },
        closeOutputData() {
            this.init();
        },
        init() {
            this.outputData = this._facadeOutputDataModel(this.value);
            this.initialOutputData = JSON.parse(JSON.stringify(this.outputData));
            this._sectionControlCheck();
        },
        selectDataOutputType() {
            //this.outputData.path = '';
            if (
                this.outputData.data_output_type ==
                CONSTS.IO_CONST.IO_DATA_OUTPUT_TYPE_TRA_LOI_LIEN_LAC
            ) {
                this.sectionControl.pathRequired = false;
            } else {
                this.sectionControl.pathRequired = true;
            }
        },
        _facadeOutputDataModel(data) {
            var defaultSender = 0;
            var projectId = 0;
            var now = moment().format("YYYY-MM-DD[T]HH:mm:ss");
            if (this.projectInformation.project_manager != undefined) {
                defaultSender = this.projectInformation.project_manager;
            }
            if (this.projectInformation.id != undefined) {
                projectId = this.projectInformation.id;
            }
            if (data == null) {
                var outputDataModel = {
                    id: 0,
                    datetime: now,
                    data_status: CONSTS.IO_CONST.IO_DATA_STATUS_NO_PROGRESS_ID,
                    sender: defaultSender,
                    project_id: projectId,
                    data_output_type:
                        CONSTS.IO_CONST.IO_DATA_OUTPUT_TYPE_DEFAULT,
                    path: "",
                    attach_folder: false,
                    name: CONSTS.IO_CONST.IO_DATA_TYPE_NAME_OUPUT,
                    subject_mail: "",
                    staff_data_status:
                        CONSTS.IO_CONST.IO_STAFF_DATA_STATUS_NOT_FINISHED,
                    original_mail: "",
                    translated_mail: "",
                    translator: null,
                    translator_suggested: null,
                    urgent: false,
                    project_path: "",
                    data_output_type_name: "",
                    translate_id: null
                };

                return outputDataModel;
            } else {
                var outputDataModel = {
                    id: data.id,
                    datetime: moment(data.datetime).format(
                        "YYYY-MM-DD[T]HH:mm:ss"
                    ),
                    data_status: data.data_status_id,
                    sender: data.sender_id,
                    project_id: projectId,
                    data_output_type: data.data_type_id,
                    path: data.path,
                    attach_folder: null,
                    name: CONSTS.IO_CONST.IO_DATA_TYPE_NAME_OUPUT,
                    subject_mail: data.subject_mail,
                    staff_data_status: data.staff_data_status_id,
                    original_mail: data.original_mail,
                    translated_mail: data.translated_mail,
                    translator: data.translator_id,
                    translator_suggested: data.translator_suggested_id,
                    urgent: false,
                    project_path: "",
                    data_output_type_name: data.data_type,
                    translate_id: data.translate_id
                };
                return outputDataModel;
            }
        },
        _validateOutputData() {
            var errorMsg = [];
            if (!this.outputData.sender) {
                errorMsg.push(this.$t("io_data.messages.receiver_required"));
            }
            if (!this.outputData.translator_suggested) {
                errorMsg.push(this.$t("io_data.messages.pdv_required"));
            }
            if (!this.outputData.subject_mail) {
                errorMsg.push(
                    this.$t("io_data.messages.subject_mail_required")
                );
            }
            if (
                this.outputData.data_status !=
                CONSTS.IO_CONST.IO_DATA_STATUS_DONE_PROGRESS_ID
            ) {
                if (
                    this.outputData.data_output_type ==
                    CONSTS.IO_CONST.IO_DATA_OUTPUT_TYPE_DEFAULT_ID
                ) {
                    if (!this.outputData.path) {
                        errorMsg.push(
                            this.$t("io_data.messages.path_required")
                        );
                    }
                    if (
                        this.outputData.path &&
                        this.outputData.path.indexOf(
                            this.projectInformation.project_path
                        ) == -1
                    ) {
                        errorMsg.push(
                            this.$t("io_data.messages.path_project_error")
                        );
                    }
                    if (
                        this.outputData.path &&
                        this.outputData.path.indexOf("OUTPUT\\2.SEND") == -1
                    ) {
                        errorMsg.push(
                            this.$t(
                                "io_data.messages.data_put_wrong_place_SEND"
                            )
                        );
                    }
                    if (
                        this.outputData.path &&
                        this.outputData.path.indexOf("2.SEND\\1.SENT") != -1
                    ) {
                        errorMsg.push(
                            this.$t(
                                "io_data.messages.data_put_wrong_place_SENT"
                            )
                        );
                    }
                }
            }
            if (
                this.outputData.data_status ==
                CONSTS.IO_CONST.IO_DATA_STATUS_DONE_PROGRESS_ID
            ) {
                if (
                    this.outputData.data_output_type ==
                    CONSTS.IO_CONST.IO_DATA_OUTPUT_TYPE_DEFAULT_ID
                ) {
                    if (!this.outputData.path) {
                        errorMsg.push(
                            this.$t("io_data.messages.path_required")
                        );
                    }
                }
                if (
                    this.outputData.path &&
                    this.outputData.path.indexOf(
                        this.projectInformation.project_path
                    ) == -1
                ) {
                    errorMsg.push(
                        this.$t("io_data.messages.path_project_error")
                    );
                }
            }
            if (!this.outputData.original_mail) {
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
            if (this.outputData.id != 0) {
                this.sectionControl.isCreate = false;
                this.sectionControl.isUpdate = true;
                this.sectionControl.showCreateFolder = false;
                if (this.outputData.path) {
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
