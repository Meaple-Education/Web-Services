
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

export default function GuestHoc(ComponentToProtect: any) {
    class GuestHoc extends React.Component<
        IProps,
        IStates
    > {
        constructor(props: IProps) {
            super(props);
            this.state = {
            };
        }

        componentDidMount() {
            if (this.props.authState.verifyPassword && this.props.location.pathname !== PageEndpoint.verifyPassword) {
                this.props.history.push(PageEndpoint.verifyPassword);
                return;
            }

            if (this.props.authState.isLoggin && !this.props.authState.verifyPassword) {
                this.props.history.push(PageEndpoint.schoolList);
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
    }, {})(GuestHoc)
}