import React from 'react';
import { RouteComponentProps } from 'react-router';
import { Link } from 'react-router-dom';
import { PageEndpoint } from '../../../routes/PageEndPoint';
import AuthService from '../../../services/AuthService';
import ImageAtom from '../../atoms/ImageAtom';
import LinkButtonAtom from '../../atoms/LinkButtonAtom';
import AuthBoxOrganism from '../../organisms/AuthBoxOrganism';
import AuthenticateTemplate from '../../templates/AuthenticateTemplate';

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
        return <>
            <p data-test="verificationSuccessMessageSection" className="verification-message">Validation complete</p>
            <LinkButtonAtom
                url={PageEndpoint.signin}
                title="LOGIN"
            />
        </>
    }

    render() {
        const {
            hasError,
            errorMesg,
            validating,
        } = this.state;
        return <AuthenticateTemplate>
            <AuthBoxOrganism>
                <ImageAtom src="/images/logo.png" figureClass="auth-logo" />
                {
                    validating &&
                    <p className="verification-message">Validating</p>

                }
                {
                    !validating &&
                    (hasError ? <p className="verification-message">{errorMesg}</p> : this.verificationSuccessUI())
                }
            </AuthBoxOrganism>
        </AuthenticateTemplate>;
    }
}

export default VerifyAccountPage;
