/**
 * Created by macintosh on 9/1/20.
 */
import Vue from "vue";
import Vuex from "vuex";
import * as projectAction from "../project/actions";
import * as translateAction from "../translate/actions";
import * as userDashboardAction from "../userdashboard/actions";
import * as qualityManagementAction from "../qualitymanagement/actions";

const actions = Object.assign(
    {},
    projectAction.default,
    translateAction.default,
    userDashboardAction.default,
    qualityManagementAction.default
);

import * as projectMutation from "../project/mutations";
import * as translateMutation from "../translate/mutations";
import * as userDashboardMutation from "../userdashboard/mutations";
import * as qualityManagementMutation from "../qualitymanagement/mutations";

const mutations = Object.assign(
    {},
    projectMutation.default,
    translateMutation.default,
    userDashboardMutation.default,
    qualityManagementMutation.default,
);

import * as projectGetter from "../project/getters";
import * as translateGetter from "../translate/getters";
import * as userDashboardGetter from "../userdashboard/getters";
import * as qualityManagementGetter from "../qualitymanagement/getters";

const getters = Object.assign(
    {},
    projectGetter.default,
    translateGetter.default,
    userDashboardGetter.default,
    qualityManagementGetter.default
);

import * as projectState from "../project/state";
import * as translateState from "../translate/state";
import * as userDashboardState from "../userdashboard/state";
import * as qualityManagementState from "../qualitymanagement/state";

const state = Object.assign(
    {},
    projectState.default,
    translateState.default,
    userDashboardState.default,
    qualityManagementState.default
);

Vue.use(Vuex);

export default new Vuex.Store({
    state,
    mutations,
    getters,
    actions
});
