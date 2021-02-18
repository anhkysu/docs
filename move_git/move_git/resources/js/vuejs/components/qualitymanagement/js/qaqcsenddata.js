/**
 * Created by macintosh on 14/3/20.
 */
import { mapGetters } from "vuex";

export default {
    components: {
        
    },
    data: function() {
        return {
            sectionControl: {
                isAction: 0,
                itemPreviousSelected: -1
            },
        }
    },
    name: "QaQcSendData",
    props: ['sendDataList'],
    mounted() {
        
    },

    computed: {

    },
    methods: {
        selectSendDataItem(index){
            $('#qaqc-send-data-' + this.sectionControl.itemPreviousSelected).removeClass('bg-primary text-light');
            $('#qaqc-send-data-' + index).addClass('bg-primary text-light');
            this.sectionControl.itemPreviousSelected = index;
            this.closeContextMenu();
        },
        viewProjectDetailAction() {
            
        },
        switchTab() {
            
        },
        openContextMenu(e, rowIndex, dataId) {
            this.selectSendDataItem(rowIndex);
            var top = e.layerY;
            var left = e.pageX;
            $("#context-menu-send-data")
                .css({
                    display: "block",
                    top: top - 5,
                    left: left - 335
                })
                .on("click", () => {
                    this.closeContextMenu();
                });
            
        },
        closeContextMenu() {
            $("#context-menu-send-data")
                .hide();
        }
    }
};