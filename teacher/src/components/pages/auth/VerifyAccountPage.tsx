import React from 'react';
import { RouteComponentProps } from 'react-router';
import { Link } from 'react-router-dom';
import { PageEndpoint } from '../../../routes/PageEndPoint';
import AuthService from '../../../services/AuthService';
import NonAuthTemplate from '../../templates/NonAuthTemplate';

interface IProps extends RouteComponentProps<any> { }

interface IStates {
    hasError: boolean;
    errorMesg: string;
    validating: boolean;
}

class VerifyAccountPage extends React.Component<IProps, IStates> {
    constructor(props: IProps) {
        super(props);
        this.state = {
            hasError: false,
            errorMesg: '',
            validating: true,
        };
    }

    componentDidMount() {
        this.validateParams();
    }

    async validateParams() {
        let urlParams = new URLSearchParams(this.props.location.search);
        let code = urlParams.get('code') || '';
        let email = urlParams.get('email') || '';

        if (code !== '' && email !== '') {

            const authService = new AuthService();
            const verifyAccount = await authService.verifyAccount(code, email);

            if (!verifyAccount.status) {
                this.setState({
                    validating: false,
                    hasError: true,
                    errorMesg: verifyAccount.msg,
                });
            } else {
                this.setState({
                    validating: false,
                });
            }
        } else {
            this.setState({
                validating: false,
                hasError: true,
                errorMesg: 'Invalid request!',
            });
        }
    }

    verificationSuccessUI() {
        return <div data-test="verificationSuccessSection">
            <span data-test="verificationSuccessMessageSection">Validation complete</span><br />
            <Link to={PageEndpoint.signin}>Login</Link>
        </div>
    }

    render() {
        const {
            hasError,
            errorMesg,
            validating,
        } = this.state;
        return <NonAuthTemplate>
            <div data-test="verifyAccountPage">
                {
                    validating &&
                    "Validating"

                }
                {
                    !validating &&
                    (hasError ? <div data-test="verificationFailedSection">{errorMesg}</div> : this.verificationSuccessUI())
                }
            </div>
        </NonAuthTemplate>;
    }
}

export default VerifyAccountPage;
