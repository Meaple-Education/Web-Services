
import React from 'react';
import { connect } from 'react-redux';
import { RouteComponentProps } from 'react-router';
import AuthInterface from '../interfaces/AuthInterface';
import { StoreState } from '../redux/reducers';
import { PageEndpoint } from '../routes/PageEndPoint';

interface IProps extends RouteComponentProps {
    authState: AuthInterface;
}

interface IStates {
}

export default function MemberHoc(ComponentToProtect: any) {
    class MemberHoc extends React.Component<
        IProps,
        IStates
    > {
        constructor(props: IProps) {
            super(props);
            this.state = {
            };
        }

        componentDidMount() {
            if (!this.props.authState.isLoggin) {
                this.props.history.push(PageEndpoint.home);
                return;
            }

            if (this.props.authState.isLoggin && [PageEndpoint.verifyAccount, PageEndpoint.signin, PageEndpoint.signup].includes(this.props.location.pathname)) {
                this.props.history.push(PageEndpoint.verifyPassword);
            }
        }

        render() {
            return (
                <React.Fragment>
                    <ComponentToProtect {...this.props} />
                </React.Fragment>
            );
        }
    }

    return connect(({ authState }: StoreState) => {
        return {
            authState,
        };
    }, {})(MemberHoc)
}
