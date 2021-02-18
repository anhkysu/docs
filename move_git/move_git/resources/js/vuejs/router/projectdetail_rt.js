import Vue from 'vue'
import Router from 'vue-router'
import ProjectSummary from '../components/project/template/partials/ProjectSummary';
import JointStaff from '../components/project/template/partials/JointStaff';
import InputOutputData from '../components/project/template/partials/InputOutputData';
import QuotationTime from '../components/project/template/partials/QuotationTime';
import TechnicalError from '../components/project/template/partials/TechnicalError';

const WorkDoneTab = {template: "<div>Cong viec da thuc hien</div>"};
const InternalDataTab = {template: "<div>Du lieu noi bo</div>"};
const ContactListTab = {template: "<div>Danh sach nguoi lien lac</div>"};


Vue.use(Router)

export default new Router({
    linkActiveClass: "active",
    routes: [
        {
            path: '/thong-tin-du-an',
            name: 'projectSummaryTab',
            component: ProjectSummary
        },
        {
            path: '/thanh-vien',
            name: 'jointStaffTab',
            component: JointStaff
        },
        {
            path: '/du-lieu-io',
            name: 'ioDataTab',
            component: InputOutputData
        },
        {
            path: '/thoi-gian-bao-gia',
            name: 'quotationTimeTab',
            component: QuotationTime
        },
        {
            path: '/cong-viec-da-thuc-hien',
            name: 'workDoneTab',
            component: WorkDoneTab
        },
        {
            path: '/loi-ky-thuat',
            name: 'technicalErrorTab',
            component: TechnicalError
        },
        {
            path: '/du-lieu-noi-bo',
            name: 'internalDataTab',
            component: InternalDataTab
        },
        {
            path: '/danh-sach-nguoi-lien-lac',
            name: 'contactListTab',
            component: ContactListTab
        },
        {
            path: '/',
            redirect: {name: 'projectSummaryTab'}
        },
    ]
})