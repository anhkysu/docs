/**
 * Created by macintosh on 14/3/20.
 */
import { mapGetters } from "vuex";
import CONSTS from '../../../consts.js';

export default {
    components: {
        
    },
    name: "ProjectSummary",
    props: {
        projectInformation: {
            type: Object,
        }
    },
    watch: {
        projectInformation: function(){
            this._sectionControlCheck();
        }
    },
    data: function () {
        return {
            projectStatusList: window.metaData.projectStatusList,
            projectManagerList: window.metaData.projectManagerList,
            teamManagerList: window.metaData.teamManagerList,
            endUserList: window.metaData.endUserList,
            unitList: window.metaData.unitList,
            valueFactorList: window.metaData.valueFactorList,
            sectionControl: {
                isUpdateProjectInformation: 0,
            }
        }
    },
    mounted() {
        this._sectionControlCheck();
    },
    methods: {
        updateProjectInformation(){
            if(!this.projectInformation.id) return;

            let payload = {
                projectId: this.projectInformation.id,
                projectData: {
                    projectInfo: {
                        id: this.projectInformation.id,
                        customer_id: this.projectInformation.customer_id,
                        project_id: this.projectInformation.project_id,
                        project_name: this.projectInformation.project_name,
                        status: this.projectInformation.status,
                        project_path: this.projectInformation.project_path,
                        end_user_id: this.projectInformation.end_user_id,
                        remark: this.projectInformation.remark,
                        amount: this.projectInformation.amount,
                        unit_id: this.projectInformation.unit_id,
                        start_date: this.projectInformation.start_date,
                        finish_date: this.projectInformation.finish_date,
                    },
                    admin: {
                        working_factor_i: this.projectInformation.working_factor_i,
                        working_factor_ii: this.projectInformation.working_factor_ii,
                        working_factor_iii: this.projectInformation.working_factor_iii,
                        project_manager: this.projectInformation.project_manager,
                        team_manager: this.projectInformation.team_manager,
                    }
                },
                typeInfo: CONSTS.TYPE_INFO_PROJECT_INFO
            };
            this.$store.dispatch("UPDATE_PROJECT_DATA", payload);

        },

        _sectionControlCheck(){
            if(this.projectInformation.id){
                this.sectionControl.isUpdateProjectInformation = 1;
            }
        }
    }
};