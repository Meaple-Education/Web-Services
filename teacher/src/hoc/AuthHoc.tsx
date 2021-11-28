import React from 'react';
import { RouteComponentProps } from 'react-router';
import OverlayLoadingAtom from '../components/atoms/OverlayLoadingAtom';
import { AuthEnum } from '../enum/auth';
import { connect } from "react-redux";
import { AuthLoadProfile, authLoadProfile, AuthToggleValidatingState, authToggleValidatingState } from '../redux/actions';
import { StoreState } from '../redux/reducers';
import AuthInterface from '../interfaces/AuthInterface';

interface IProps extends RouteComponentProps {
    authState: AuthInterface;
    authLoadProfile: AuthLoadProfile;
    authToggleValidatingState: AuthToggleValidatingState;
}

interface IStates {
}

export default function AuthHoc(ComponentToProtect: any) {
    class HOCComponent extends React.Component<
        IProps,
        IStates
    > {
        constructor(props: IProps) {
            super(props);
            this.state = {
            };
        }

        componentDidMount() {
            this.validateAuth();
        }

        validateAuth() {
            const token = localStorage.getItem(AuthEnum.Token) ?? '';
            const sessionIdentifier = localStorage.getItem(AuthEnum.SessionIdentifier) ?? '';

            if (token !== '' && sessionIdentifier !== '') {
                console.log("Loading");
                this.props.authLoadProfile();
            } else {
                this.props.authToggleValidatingState(false);
            }
        }

        render() {
            const { authState } = this.props;

            return (
                <>
                    {
                        authState.validating &&
                        <OverlayLoadingAtom />
                    }
                    {
                        !authState.validating &&
                        < React.Fragment >
                            <ComponentToProtect {...this.props} />
                        </React.Fragment >
                    }
                </>
            );
        }
    }

    return connect(({ authState }: StoreState) => {
        return { authState };
    }, {
        authLoadProfile,
        authToggleValidatingState,
    })(HOCComponent);
}
