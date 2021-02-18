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
    name: "QaQcCheckBackData",
    props: ['checkbackDataList'],
    mounted() {
        
    },

    computed: {

    },
    methods: {
        selectCheckbackDataItem(index){
            $('#qaqc-checkback-data-' + this.sectionControl.itemPreviousSelected).removeClass('bg-primary text-light');
            $('#qaqc-checkback-data-' + index).addClass('bg-primary text-light');
            this.sectionControl.itemPreviousSelected = index;
            this.closeContextMenu();
        },
        viewProjectDetailAction() {
            
        },
        openContextMenu(e, rowIndex, dataId) {
            this.selectCheckbackDataItem(rowIndex);
            var top = e.layerY;
            var left = e.pageX;
            $("#context-menu-checkback-data")
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
            $("#context-menu-checkback-data")
                .hide();
        }
    }
};