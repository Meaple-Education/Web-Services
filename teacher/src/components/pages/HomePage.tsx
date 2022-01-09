import React from 'react';
import { connect } from 'react-redux';
import { Link, RouteComponentProps } from 'react-router-dom';
import AuthInterface from '../../interfaces/AuthInterface';
import { StoreState } from '../../redux/reducers';
import { PageEndpoint } from '../../routes/PageEndPoint';

interface IProps extends RouteComponentProps {
    authState: AuthInterface;
}

class HomePage extends React.Component<IProps> {
    render() {
        return <div data-test="homePage">
            HomePage TO BE IMPLEMENTED
            <br />
            <ul>
                <li>
                    {
                        !this.props.authState.isLoggin &&
                        <Link to={PageEndpoint.signin}>Login</Link>
                    }
                    {
                        this.props.authState.isLoggin &&
                        <Link to={PageEndpoint.schoolList}>Dashboard</Link>
                    }
                </li>
            </ul>
        </div>;
    }
}

export default connect(({ authState }: StoreState) => {
    return {
        authState,
    };
}, {})(HomePage);
