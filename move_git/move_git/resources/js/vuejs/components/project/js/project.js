/**
 * Created by macintosh on 14/3/20.
 */
import { mapGetters, mapMutations } from "vuex";
import CONSTS from '../../../consts.js';
import ProjectIndex from '../template/ProjectIndex.vue';
import ProjectSummary from '../template/partials/ProjectSummary.vue';
import JointStaff from '../template/partials/JointStaff.vue';
import InputOutputData from '../template/partials/InputOutputData.vue';
import QuotationTime from '../template/partials/QuotationTime.vue';
import TechnicalError from '../template/partials/TechnicalError.vue';
import WorkDone from '../template/partials/WorkDone.vue';
import SettingSearchProject from '../template/modals/SettingSearchProject.vue';

export default {
    components: {
        ProjectIndex,
        ProjectSummary,
        JointStaff,
        InputOutputData,
        QuotationTime,
        SettingSearchProject,
        TechnicalError,
        WorkDone
    },
    name: "Project",
    props: [  
    ],
    data: function () {
        return {
            projectInformationSelected: this._facadeProjectInformationModel(),
            projectSelectedName: this.$t('projectmng.project_title_default'),
            searchCriteria: {
                inputText: ''
            },
            tempProjectInformationList: []
        }
    },
    created(){
        this.getProjectInformations([]);
    },
    computed: {
        ...mapGetters(["projectInformationList"]),
    },
    methods: {
        search(){
            if(this.searchCriteria.inputText){
                this.tempProjectInformationList = [];
                this.projectInformationList.forEach(element => {
                    if(element.project_id.indexOf(this.searchCriteria.inputText) > -1){
                        this.tempProjectInformationList.push(element); 
                    }
                });
            }else{
                this.tempProjectInformationList = this.projectInformationList;
            }
            
        },
        getProjectInformations(searchCriteria){
            this.$store.dispatch("GET_PROJECT_INFORMATION_LIST", searchCriteria).then((data) => {
                this.tempProjectInformationList = data.data.projectInformationList;
                setTimeout(()=>{
                    this._focusProjectInformation();
                    this._focusTab();
                },600);
              });
        },
        selectProjectInformation(projectIndex){     
            $('#project-list-wrapper li.list-group-item.active').removeClass('active');
            $('#project-index-' + projectIndex).addClass('active');
            this.projectInformationSelected = this.tempProjectInformationList[projectIndex];
            this.projectSelectedName = this.$t('projectmng.project_title') + ' ' + this.projectInformationSelected.project_id + ' ' + this.projectInformationSelected.project_name;
        },
        _focusProjectInformation(){
            if(!this.$route) return;

            let projectId = this.$route.params.projectId;
            if(!projectId) return;

            let projectIndex = null;
            this.tempProjectInformationList.forEach((projectInformation, index) => {
                if(projectInformation.project_id == projectId) {
                    projectIndex = index;
                    return;
                }
            });
            let elementToScroll = $(`#project-index-${projectIndex}`);
            if(!elementToScroll) return;
            if(projectIndex === null) return;
            this.selectProjectInformation(projectIndex);
            $('#project-list-wrapper').animate({
                scrollTop: elementToScroll.offset().top - 400
            }, 1000);
        },
        _focusTab(){
            if(!this.$route) return;
            
            let tabName = this.$route.params.tabName;
            $(`a[href='#${tabName}']`).trigger('click');
        },
        openAddWorkDoneModal(){
            $('#bs-projectmng-tab-nav a[href="#have-worked"]').tab('show');
            $('#add-work-done-modal').modal('show');
        },
        _facadeProjectInformationModel(){
            var projectInformationModel = {
                amount: 0,
                business_manager: '',
                create_date: '',
                created_at: '',
                created_by: '',
                customer_id: '',
                customer_manager: '',
                customer_project_id: '',
                customer_project_name: '',
                end_user_id: '',
                finish_date: '',
                id: '',
                is_fixed: '',
                mail_subject: '',
                project_id: '',
                project_name: '',
                project_path: '',
                project_type_id: '',
                remark: '',
                start_date: '',
                status: 1,
                team_manager: 0,
                project_manager: '',
                unit_id: null,
                updated_at: '',
                updated_by: 1,
                working_factor_i: "3.00",
                working_factor_ii: "5.00",
                working_factor_iii: "9.00"
            };

            return projectInformationModel;
        }
    }
};