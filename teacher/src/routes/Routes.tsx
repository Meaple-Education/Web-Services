import React from 'react';
import { Route, Switch, BrowserRouter } from 'react-router-dom';
import SigninPage from '../components/pages/auth/SigninPage';
import SignupPage from '../components/pages/auth/SignupPage';
import VerifyAccountPage from '../components/pages/auth/VerifyAccountPage';
import DashboardPage from '../components/pages/DashboardPage';
import HomePage from '../components/pages/HomePage';
import ProfilePage from '../components/pages/ProfilePage';
import StudentCreatePage from '../components/pages/student/StudentCreatePage';
import StudentDetailPage from '../components/pages/student/StudentDetailPage';
import StudentListPage from '../components/pages/student/StudentListPage';
import AuthHoc from '../hoc/AuthHoc';
import { PageEndpoint } from './PageEndPoint';

class Routes extends React.Component {
    render() {
        return <BrowserRouter basename="/">
            <Switch>
                <Route
                    path={PageEndpoint.home}
                    exact
                    component={HomePage}
                />
                <Route
                    path={PageEndpoint.signup}
                    exact
                    component={SignupPage}
                />
                <Route
                    path={PageEndpoint.signin}
                    exact
                    component={SigninPage}
                />
                <Route
                    path={PageEndpoint.verifyAccount}
                    exact
                    component={VerifyAccountPage}
                />
                <Route
                    path={PageEndpoint.profile}
                    exact
                    component={ProfilePage}
                />
                <Route
                    path={PageEndpoint.dashboard}
                    exact
                    component={AuthHoc(DashboardPage)}
                />
                <Route
                    path={PageEndpoint.studentList}
                    exact
                    component={StudentListPage}
                />
                <Route
                    path={PageEndpoint.studentCreate}
                    exact
                    component={StudentCreatePage}
                />
                <Route
                    path={PageEndpoint.studentDetail}
                    exact
                    component={StudentDetailPage}
                />
            </Switch>
        </BrowserRouter>
    }
}

export default Routes;
