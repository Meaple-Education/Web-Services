import React from 'react';
import { Route, Switch, BrowserRouter } from 'react-router-dom';
import SigninPage from '../components/pages/auth/SigninPage';
import SignupPage from '../components/pages/auth/SignupPage';
import VerifyAccountPage from '../components/pages/auth/VerifyAccountPage';
import VerifyPasswordPage from '../components/pages/auth/VerifyPasswordPage';
import HomePage from '../components/pages/HomePage';
import ProfilePage from '../components/pages/ProfilePage';
import SchoolListPage from '../components/pages/SchoolListPage';
import AuthHoc from '../hoc/AuthHoc';
import GuestHoc from '../hoc/GuestHoc';
import MemberHoc from '../hoc/MemberHoc';
import ClassRoute from './ClassRoutes';
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
                <Route path={PageEndpoint.dashboard} component={ClassRoute} />
            </Switch>
        </BrowserRouter>
    }
}

export default Routes;
