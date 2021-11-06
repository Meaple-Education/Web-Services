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

interface IProps extends RouteComponentProps { }

interface IStates {
    name: string;
    email: string;
    password: string;
    processing: boolean;
    registered: boolean;
}

class SignupPage extends React.Component<IProps, IStates> {

    constructor(props: IProps) {
        super(props);
        this.state = {
            name: '',
            email: '',
            password: '',
            processing: false,
            registered: false,
        }
    }

    updateInput = (value: string, name: string) => {
        this.setState({
            ...this.state,
            [name]: value,
        })
    }

    formSubmit = async () => {
        const { name, email, password, processing } = this.state;

        if (processing) {
            return
        }

        const authService = new AuthService();

        this.setState({
            processing: true,
        });

        const register = await authService.signup(
            email,
            name,
            password,
        )

        this.setState({
            processing: false,
        });

        console.log('register', register)

        if (!register.status) {
            alert(register.msg);
        } else {
            this.setState({
                registered: true,
            });
        }
    }

    registrationForm() {
        return <>
            <FormAtom
                restrict={true}
                callback={this.formSubmit}
            >
                <LabelInputMolecule
                    label={{
                        title: "Name",
                        for: "signUpName"
                    }}
                    input={{
                        id: "signUpName",
                        type: "text",
                        name: "name",
                        placeholder: "Name",
                        initialValue: "",
                        callback: (val: string) => this.updateInput(val, 'name')
                    }}
                />

                <LabelInputMolecule
                    label={{
                        title: "Email",
                        for: "signUpEmail"
                    }}
                    input={{
                        id: "signUpEmail",
                        type: "email",
                        name: "email",
                        placeholder: "Email",
                        initialValue: "",
                        callback: (val: string) => this.updateInput(val, 'email')
                    }}
                />

                <LabelInputMolecule
                    label={{
                        title: "Password",
                        for: "signUpPassword"
                    }}
                    input={{
                        id: "signUpPassword",
                        type: "password",
                        name: "signUpPassword",
                        placeholder: "Password",
                        initialValue: "",
                        callback: (val: string) => this.updateInput(val, 'password')
                    }}
                />

                <ButtonAtom title="REGISTER" type="submit" />
                <SpacerAtom />
                Or
                <SpacerAtom />
                <ButtonAtom
                    title="LOGIN"
                    type="button"
                    callback={() => {
                        this.props.history.push(PageEndpoint.signin);
                    }}
                />
            </FormAtom>
        </>
    }

    render() {
        const { processing, registered, email } = this.state;
        return <AuthenticateTemplate>
            <AuthBoxOrganism>
                <ImageAtom src="/images/logo.png" figureClass="auth-logo" />
                {
                    !registered &&
                    this.registrationForm()
                }
                {
                    registered &&
                    <p className="verification-message">Verification email is send to {email}.</p>
                }
                {
                    processing &&
                    <OverlayLoadingAtom position="absolute" />
                }
            </AuthBoxOrganism>
        </AuthenticateTemplate>;
    }
}

export default withRouter(SignupPage);
