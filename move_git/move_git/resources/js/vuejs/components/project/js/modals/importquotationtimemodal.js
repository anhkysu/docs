/**
 * Created by macintosh on 14/3/20.
 */
import {
    mapGetters
} from "vuex";
import CONSTS from '../../../../consts.js';
import Utility from '../../../../plugins/utility.js';
import XLSX, { read } from "xlsx";


export default {
    components: {

    },
    name: "ImportQuotationTimeModal",
    props: {
        projectInformation: {
            type: Object,
        },
        confirmedQuotationTimeList:{
            type: Array
        },
        notConfirmedQuotationTimeList: {
            type: Array
        }
    },
    watch: {
        projectInformation: function () {

        },
        value: function () {
            this.init();
        }
    },
    data() {
        return {
            quotationTimeImportList: [],
            fileName: ''
        };
    },
    methods: {
        init(){
            this.quotationTimeImportList = [];
        },
        workbook_to_json(workbook) {
            var result = {};
            workbook.SheetNames.forEach(function (sheetName) {
                var roa = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
                if (roa.length > 0) {
                    result[sheetName] = roa;
                }
            });
            return result;
        },
        closeImportQuotationTime(){
            this.init();
            $('#import-quotation-time-modal').modal('hide');
        },
        importQuotationTimeList(){
            if(this.quotationTimeImportList.length){
                this.$store.dispatch("IMPORT_QUOTATION_TIME", this.quotationTimeImportList).then((data) => {
                    $('#import-quotation-time-file').val('')
                    this.closeImportQuotationTime();
                    
                  });
            }
        },
        loadQuotationTimeImport(e) {
            var baogioImportFile = e.target.files[0];
            var reader = new FileReader();
            this.quotationTimeImportList = [];
            reader.onload = function(e){
                var data = e.target.result,
                fixedData = Utility.fixdata(data),
                workbook = XLSX.read(btoa(fixedData), {
                    type: 'base64'
                }),
                firstSheetName = workbook.SheetNames[0],
                worksheet = workbook.Sheets[firstSheetName];
                var dataRows = XLSX.utils.sheet_to_json(worksheet);
                this._formatQuotationTime(dataRows);
            }.bind(this);
            reader.readAsArrayBuffer(baogioImportFile);
        },
        _validateQuotationTime(dataRow){
            if (dataRow["Hệ Số"]
            || dataRow["Unit"]
            || dataRow["Tên Bản vẽ"]
            || dataRow["Thời Gian Báo Giá (phút)"]
            || dataRow["Ngày Hoàn Thành Vẽ"]
            || dataRow["Ngày Hoàn Thành Check"]
            || dataRow["Người Vẽ"]
            || dataRow["Người Check"]
            || dataRow["Thời Gian Vẽ Thực Tế (phút)"]
            || dataRow["Thời Gian Check Thực Tế (phút)"]
            || dataRow["Ghi Chú"]
            )
            {
                return true;
            }
        return false;
        },
        _formatQuotationTime(dataRows){
            /**
             * Hệ Số: "II"
            ID: 96722
            Ngày Hoàn Thành Check: "2019-12-13"
            Ngày Hoàn Thành Vẽ: "2019-12-13"
            Người Check: "00089"
            Người Vẽ: "00089"
            STT: 1
            Thời Gian Báo Giá (phút): 840
            Thời Gian Check: 252
            Thời Gian Check Thực Tế (phút): 720
            Thời Gian Vẽ: 588
            Thời Gian Vẽ Thực Tế (phút): 720
            Tên Bản Vẽ: "Barashi Unit JL60027 và JL60028"
            Tên Người Check: "T.Đạt"
            Tên Người Vẽ: "T.Đạt"
            Tỉ Lệ: 0.3
            Unit: "Loader"
             */
            if(Array.isArray(dataRows)){
                for(var i = 0; i < dataRows.length; i++){
                    var row = dataRows[i];
                    if(this._validateQuotationTime(row)){
                        let action = '';
                        if(!row["ID"]){   
                            action = 'insert';
                        }else{
                            if(this.confirmedQuotationTimeList.indexOf(row["ID"]) != -1){
                                action = 'confirm';
                            }else{
                                if(this.notConfirmedQuotationTimeList.indexOf(row["ID"]) != -1){
                                    action = 'update';
                                }else{
                                    action = 'insert';
                                }
                            }
                        }
                        var data = {
                            working_factor: Utility.setDefaultValue(row["Hệ Số"]),
                            unit: Utility.setDefaultValue(row["Unit"]),
                            dwg_name: Utility.setDefaultValue(row["Tên Bản Vẽ"]),
                            estimate_time: Utility.setDefaultValue(row["Thời Gian Báo Giá (phút)"]),
                            factor: Utility.setDefaultValue(row["Tỉ Lệ"]),
                            really_draw_time: Utility.setDefaultValue(row["Thời Gian Vẽ Thực Tế (phút)"]),
                            really_check_time: Utility.setDefaultValue(row["Thời Gian Check Thực Tế (phút)"]),
                            finish_draw_date: Utility.setDefaultValue(row["Ngày Hoàn Thành Vẽ"]),
                            drawing_staff_name: Utility.setDefaultValue(row["Tên Người Vẽ"]),
                            drawing_staff_id: Utility.setDefaultValue(row["Người Vẽ"]),
                            drawing_time: Utility.setDefaultValue(row["Thời Gian Check"]),
                            finish_check_date: Utility.setDefaultValue(row["Ngày Hoàn Thành Check"]),
                            checking_staff_name: Utility.setDefaultValue(row["Tên Người Check"]),
                            checking_staff_id: Utility.setDefaultValue(row["Người Check"]),
                            checking_time: Utility.setDefaultValue(row["Thời Gian Vẽ"]),
                            note: Utility.setDefaultValue(row["Ghi Chú"]),
                            id: Utility.setDefaultValue(row["ID"]),
                            project_id: Utility.setDefaultValue(this.projectInformation.id),
                            action: action
                        };
                        this.quotationTimeImportList.push(data);
                    }
                    
                }
            }
        }
    }
};
