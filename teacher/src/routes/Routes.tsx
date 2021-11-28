import React from 'react';
import { Route, Switch, BrowserRouter } from 'react-router-dom';
import SigninPage from '../components/pages/auth/SigninPage';
import SignupPage from '../components/pages/auth/SignupPage';
import VerifyAccountPage from '../components/pages/auth/VerifyAccountPage';
import VerifyPasswordPage from '../components/pages/auth/VerifyPasswordPage';
import DashboardPage from '../components/pages/DashboardPage';
import HomePage from '../components/pages/HomePage';
import ProfilePage from '../components/pages/ProfilePage';
import SchoolListPage from '../components/pages/SchoolListPage';
import StudentCreatePage from '../components/pages/student/StudentCreatePage';
import StudentDetailPage from '../components/pages/student/StudentDetailPage';
import StudentListPage from '../components/pages/student/StudentListPage';
import AuthHoc from '../hoc/AuthHoc';
import GuestHoc from '../hoc/GuestHoc';
import MemberHoc from '../hoc/MemberHoc';
import { PageEndpoint } from './PageEndPoint';


const routes = [
    {
        path: PageEndpoint.home,
        component: AuthHoc(HomePage),
    },
    {
        path: PageEndpoint.signup,
        component: AuthHoc(GuestHoc(SignupPage)),
    },
    {
        path: PageEndpoint.signin,
        component: AuthHoc(GuestHoc(SigninPage)),
    },
    {
        path: PageEndpoint.verifyAccount,
        component: AuthHoc(GuestHoc(VerifyAccountPage)),
    },
    {
        path: PageEndpoint.verifyPassword,
        component: AuthHoc(MemberHoc(VerifyPasswordPage)),
    },
    {
        path: PageEndpoint.profile,
        component: AuthHoc(MemberHoc(ProfilePage)),
    },
    {
        path: PageEndpoint.schoolList,
        component: AuthHoc(MemberHoc(SchoolListPage)),
    },
    {
        path: PageEndpoint.dashboard,
        component: AuthHoc(MemberHoc(DashboardPage)),
    },
    {
        path: PageEndpoint.studentList,
        component: AuthHoc(MemberHoc(StudentListPage)),
    },
    {
        path: PageEndpoint.studentCreate,
        component: AuthHoc(MemberHoc(StudentCreatePage)),
    },
    {
        path: PageEndpoint.studentDetail,
        component: AuthHoc(MemberHoc(StudentDetailPage)),
    },
];

class Routes extends React.Component {
    render() {
        return <BrowserRouter basename="/">
            <Switch>
                {
                    routes.map((r, index) => {
                        return <Route
                            key={index}
                            path={r.path}
                            exact
                            component={r.component}
                        />
                    })
                }
            </Switch>
        </BrowserRouter>
    }
}

export default Routes;
