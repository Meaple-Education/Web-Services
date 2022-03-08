import React from "react";
import { Switch } from "react-router";
import ProcessRoute from "./ProcessRoute";
import { PageEndpoint } from "./PageEndPoint";
import { RouteInterface } from "../interfaces/RouteInterface";

import SchoolHoc from "../hoc/SchoolHoc";
import AuthHoc from "../hoc/AuthHoc";
import MemberHoc from "../hoc/MemberHoc";

import ClassCreatePage from '../components/pages/class/ClassCreatePage';
import ClassDetailPage from '../components/pages/class/ClassDetailPage';
import ClassListPage from '../components/pages/class/ClassListPage';
import DashboardPage from '../components/pages/DashboardPage';
import GurdianCreatePage from '../components/pages/gurdian/GurdianCreatePage';
import GurdianDetailPage from '../components/pages/gurdian/GurdianDetailPage';
import GurdianListPage from '../components/pages/gurdian/GurdianListPage';
import SettingPage from '../components/pages/settings/SettingPage';
import StudentCreatePage from '../components/pages/student/StudentCreatePage';
import StudentDetailPage from '../components/pages/student/StudentDetailPage';
import StudentListPage from '../components/pages/student/StudentListPage';
import StaffCreatePage from '../components/pages/stuff/StaffCreatePage';
import StaffDetailPage from '../components/pages/stuff/StaffDetailPage';
import StaffListPage from '../components/pages/stuff/StaffListPage';
import ClassHoc from "../hoc/ClassHoc";

const routes: RouteInterface[] = [
    {
        path: PageEndpoint.dashboard,
        component: DashboardPage,
    },
    {
        path: PageEndpoint.studentList,
        component: StudentListPage,
    },
    {
        path: PageEndpoint.studentCreate,
        component: StudentCreatePage,
    },
    {
        path: PageEndpoint.studentDetail,
        component: StudentDetailPage,
    },
    {
        path: PageEndpoint.classList,
        component: ClassListPage,
    },
    {
        path: PageEndpoint.classCreate,
        component: ClassCreatePage,
    },
    {
        path: PageEndpoint.classDetail,
        component: ClassHoc(ClassDetailPage),
    },
    {
        path: PageEndpoint.gurdianList,
        component: GurdianListPage,
    },
    {
        path: PageEndpoint.gurdianCreate,
        component: GurdianCreatePage,
    },
    {
        path: PageEndpoint.gurdianDetail,
        component: GurdianDetailPage,
    },
    {
        path: PageEndpoint.staffList,
        component: StaffListPage,
    },
    {
        path: PageEndpoint.staffCreate,
        component: StaffCreatePage,
    },
    {
        path: PageEndpoint.staffDetail,
        component: StaffDetailPage,
    },
    {
        path: PageEndpoint.setting,
        component: SettingPage,
    },
];

class ClassRoute extends React.Component {
    render() {
        return (
            <Switch>
                {
                    routes.map((r) => {
                        r.component = AuthHoc(MemberHoc(SchoolHoc(r.component)));
                        return ProcessRoute(r);
                    })
                }
            </Switch>
        );
    }
}

export default ClassRoute;
