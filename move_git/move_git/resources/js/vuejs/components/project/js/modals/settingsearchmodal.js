/**
 * Created by macintosh on 14/3/20.
 */
import { mapGetters } from "vuex";
import CONSTS from '../../../../consts.js';
import Utility from '../../../../plugins/utility.js';

export default {
    components: {

    },
    name: "SettingSearchProject",
    props: {

    },
    watch: {
        
    },
    data: function () {
        return {
            teamManagerAssignedList: window.metaData.teamManagerAssignedList,
            projectManagerAssignedList: window.metaData.projectManagerAssignedList,
        }
    },
    methods: {
        search(){
            var searchCriteria =  {
                conditionOrganization: [],
                conditionProjectStatus: [],
                conditionManagement: {
                    teamManager: null,
                    projectManager: null
                }
            };
            var cOrganizations = $('#setting-search-modal input[name=condition_organization]');
            for(var cOrgIndex = 0; cOrgIndex < cOrganizations.length; cOrgIndex++){
                var cOrg = cOrganizations[cOrgIndex];
                if(cOrg.checked){
                    searchCriteria.conditionOrganization.push(cOrg.value);
                }
            }
            
            var cProjectStatuses = $('#setting-search-modal input[name=condition_project_status]');
            for(var cProjectStatusIndex = 0; cProjectStatusIndex < cProjectStatuses.length; cProjectStatusIndex++){
                var cProjectStatus = cProjectStatuses[cProjectStatusIndex];
                if(cProjectStatus.checked){
                    searchCriteria.conditionProjectStatus.push(cProjectStatus.value);
                }
            }
            
            var cManagements = $('#setting-search-modal input[name=condition_management]');
            for(var cManagementIndex = 0; cManagementIndex < cManagements.length; cManagementIndex++){
                var cManagement = cManagements[cManagementIndex];
                if(cManagement.checked){
                    var id = cManagement.id;
                    searchCriteria.conditionManagement[id] = $('#setting-search-modal select[name='+id+']').val();
                }
            }
            this.$emit('refreshProjectList', searchCriteria);
            this.close();
        },
        init(){

        },
        close(){
            $('#setting-search-modal').modal('hide');
        },
        _reset(){
            
        },
    }
};