/**
 * Created by macintosh on 14/3/20.
 */
import { mapGetters, mapMutations } from "vuex";


export default {
    name: "ProjectDetail",
    props: [  
    ],
    data: function () {
        return {
            projectInformationSelected: this._facadeProjectInformationModel(),
            projectSelectedName: this.$t('projectmng.project_title_default'),
            searchCriteria: {
                inputText: ''
            },
            tempProjectInformationList: [],
            projectId: window.metaData.projectId
        }
    },
    mounted() {
        this.getProjectInformations({projectId: this.projectId});
    },
    computed: {
        ...mapGetters(["projectInformationList"]),
    },
    methods: {
        getProjectInformations(searchCriteria){
            this.$store.dispatch("GET_PROJECT_INFORMATION_LIST", searchCriteria).then((data) => {
                this.tempProjectInformationList = data.data.projectInformationList;
                if(data.data.projectInformationList.length > 0){
                    this.projectInformationSelected = this.tempProjectInformationList[0];
                    this.projectSelectedName = this.$t('projectmng.project_title') + ' ' + this.projectInformationSelected.project_id + ' ' + this.projectInformationSelected.project_name;
                }
              });
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