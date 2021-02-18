/**
 * Created by macintosh on 14/3/20.
 */
import { mapGetters } from "vuex";
import CONSTS from '../../../consts.js';
import InputDataModal from '../template/modals/InputDataModal.vue';
import OutputDataModal from '../template/modals/OutputDataModal.vue';


export default {
    components: {
        InputDataModal,
        OutputDataModal
    },
    name: "InputOutputData",
    props: {
        projectId: [String, Number],
        projectInformation: {
            type: Object,
        }
    },
    watch: {
        projectId: function(){
            this.getInputOutputDataList();
            this.getLoadData();
            this._sectionControlCheck();
        }
    },
    data: function () {
        return {
            sectionControl: {
                isAction: 0,
                ioPreviousSelected: -1
            },
            inputDataSelected: null,
            outputDataSelected: null,
            searchBoxInput:'',
        }
    },
    mounted() {
        this.getInputOutputDataList();
        this._sectionControlCheck();
    },
    computed: {
        ...mapGetters(["ioDataList", "ioLoadData", "outputDataLinkList"]),
    },
    methods: {
        refreshIOList(){
            this.getInputOutputDataList();
        },
        getInputOutputDataList(){
            var payload = {
                projectId: this.projectId,
                typeInfo: CONSTS.TYPE_INFO_IO_DATA,                
            };
            this.$store.dispatch("GET_PROJECT_DATA", payload).then(data => {
                setTimeout(()=>{
                    this._focusIODataRow();
                },600);
            });
        },
        getLoadData(){
            var payload = {
                projectId: this.projectId,
            };
            this.$store.dispatch("GET_LOAD_DATA_INPUT_OUTPUT", payload);
        },
        selectIOData(dataType, id, index){
            $('#io-data-' + this.sectionControl.ioPreviousSelected).removeClass('bg-primary text-light');
            $('#io-data-' + index).addClass('bg-primary text-light');
            this.sectionControl.ioPreviousSelected = index;
        },
        openAddInputDataModal(){
            this.inputDataSelected = null;
            $('#input-data-modal').modal('show');
        },
        openAddOutputDataModal(){
            this.outputDataSelected = null;
            $('#output-data-modal').modal('show');
        },
        openUpdateDataModal(){
            if(this.sectionControl.ioPreviousSelected != -1){
                var ioData = this.ioDataList[this.sectionControl.ioPreviousSelected];
                if(ioData.data_status == CONSTS.IO_CONST.IO_DATA_STATUS_VALUE){
                    var warningMsg = [];
                    warningMsg.push(this.$t('io_data.messages.update_data_warning'));
                    notification.showWarning(warningMsg);
                    return;
                }
                switch(ioData.name){
                    case CONSTS.IO_CONST.IO_DATA_TYPE_NAME_INPUT:
                        this.inputDataSelected = ioData;
                        $('#input-data-modal').modal('show');
                        break;
                    case CONSTS.IO_CONST.IO_DATA_TYPE_NAME_OUPUT:  
                        this.outputDataSelected = ioData;
                        $('#output-data-modal').modal('show');
                        break;  
                }
            }
        },
        openDeleteIODataModal(){
            $('#delete-data-modal').modal('show');
            
        },
        yesDelete(){
            if(this.sectionControl.ioPreviousSelected != -1){
                var ioData = this.ioDataList[this.sectionControl.ioPreviousSelected];
                var payload = {
                    project_id: this.projectId,
                    id: ioData.id,
                    name: ioData.name
                };
                this.$store.dispatch("DELETE_INPUT_OUTPUT_DATA", payload).then((data) => {
                    this.refreshIOList();
                    $('#delete-data-modal').modal('hide');
                  });
            }
        },
        noDelete(){
            $('#delete-data-modal').modal('hide');
        },
        onSearchBoxKeyDown(e){
            if(e.key === 'Enter'){
                this.searchMailContent();
            }
        },
        searchMailContent(){
            let target = this.searchBoxInput;
            var payload = {
                projectId: this.projectId,
                typeInfo: CONSTS.TYPE_INFO_IO_DATA,
                search: target
            };
            this.$store.dispatch("GET_PROJECT_DATA", payload);
        },
        _focusIODataRow(){
            if(!this.$route) return;
            let queryIoDataId = this.$route.params.paramValue1;
            let queryDataType = this.$route.params.paramValue2;
            if(!queryIoDataId || !queryDataType) return;
            let elementToScroll = $(`[data-iodata-id=${queryDataType+queryIoDataId}]`);
            if(!elementToScroll) return;
            let ioDataIndex = null;
            this.ioDataList.forEach((ioData, index) => {
                if(ioData.id == queryIoDataId && ioData.name.toLowerCase() === queryDataType) {ioDataIndex = index}
            });
            if(ioDataIndex === null) return;
            this.selectIOData('','', ioDataIndex);
            $('#iodata-table-wrapper').animate({
                scrollTop: elementToScroll.offset().top - 500
            }, 1000);
        },
        _sectionControlCheck(){
            if(this.projectId){
                this.sectionControl.isAction = 1;
            }
            $('#io-data-' + this.sectionControl.ioPreviousSelected).removeClass('bg-primary text-light');
            this.sectionControl.ioPreviousSelected = -1;
        }
    }
};