import React from 'react';
import { RouteComponentProps, withRouter } from 'react-router';
import { PageEndpoint } from '../../../routes/PageEndPoint';
import AuthService from '../../../services/AuthService';
import ButtonAtom from '../../atoms/ButtonAtom';
import FormAtom from '../../atoms/FormAtom';
import ImageAtom from '../../atoms/ImageAtom';
import OverlayLoadingAtom from '../../atoms/OverlayLoadingAtom';
import SpacerAtom from '../../atoms/SpacerAtom';
import LabelInputMolecule from '../../molecules/LabelInputMolecule';
import AuthBoxOrganism from '../../organisms/AuthBoxOrganism';
import AuthenticateTemplate from '../../templates/AuthenticateTemplate';

interface IProps extends RouteComponentProps {
}

interface IStates {
    email: string;
    otp: string;
    processing: boolean;
}

class SigninPage extends React.Component<IProps, IStates> {

    constructor(props: IProps) {
        super(props);
        this.state = {
            email: '',
            otp: '',
            processing: false,
        }
    }

    updateInput = (value: string, name: string) => {
        this.setState({
            ...this.state,
            [name]: value,
        })
    }

    formSubmit = async () => {
        const { email, otp, processing } = this.state;
        const authService = new AuthService();

        this.setState({
            processing: true,
        });

        const login = await authService.signin(email, otp)
        console.log('login', login)
        if (!login.status) {
            alert(login.msg);
            this.setState({
                processing: false,
            });
            return;
        }
    }

    render() {
        const { processing } = this.state;

        return <AuthenticateTemplate>
            <AuthBoxOrganism>
                <ImageAtom src="/images/logo.png" figureClass="auth-logo" />
                <FormAtom
                    restrict={true}
                    callback={this.formSubmit}
                >
                    <LabelInputMolecule
                        label={{
                            title: "Email",
                            for: "signInEmail"
                        }}
                        input={{
                            id: "signInEmail",
                            type: "text",
                            name: "email",
                            placeholder: "Email",
                            initialValue: "",
                            callback: (val: string) => this.updateInput(val, 'email')
                        }}
                    />

                    <LabelInputMolecule
                        label={{
                            title: "OTP Code",
                            for: "signInOTP"
                        }}
                        input={{
                            id: "signInOTP",
                            type: "text",
                            name: "otp",
                            placeholder: "OTP Code",
                            initialValue: "",
                            callback: (val: string) => this.updateInput(val, 'otp')
                        }}
                    />

                    <ButtonAtom title="LOGIN" type="submit" />
                    <SpacerAtom />
                    Or
                    <SpacerAtom />
                    <ButtonAtom
                        title="REGISTER"
                        callback={() => {
                            this.props.history.push(PageEndpoint.signup);
                        }}
                    />
                </FormAtom>
                {
                    processing &&
                    <OverlayLoadingAtom position="absolute" />
                }
            </AuthBoxOrganism>
        </AuthenticateTemplate>;
    }
}

export default withRouter(SigninPage);
