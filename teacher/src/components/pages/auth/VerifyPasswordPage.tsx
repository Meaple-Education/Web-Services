import React from 'react';
import { RouteComponentProps, withRouter } from 'react-router';
import { AuthEnum } from '../../../enum/auth';
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
    password: string;
    processing: boolean;
}

class VerifyPasswordPage extends React.Component<IProps, IStates> {

    constructor(props: IProps) {
        super(props);
        this.state = {
            password: '',
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
        const { password, processing } = this.state;
        const authService = new AuthService();

        this.setState({
            processing: true,
        });

        const verifyPassword = await authService.verifyPassword(password)
        console.log('verifyPassword', verifyPassword)
        if (!verifyPassword.status) {
            if (verifyPassword.data.logout) {
                localStorage.removeItem(AuthEnum.Token);
                localStorage.removeItem(AuthEnum.SessionIdentifier);
                window.location.assign(PageEndpoint.signin);
                return;
            }

            alert(verifyPassword.msg);
            this.setState({
                processing: false,
            });
            return;
        }

        window.location.assign(PageEndpoint.schoolList);
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
                            title: "Password",
                            for: "signInPassword"
                        }}
                        input={{
                            id: "signInPassword",
                            type: "password",
                            name: "password",
                            placeholder: "Password",
                            initialValue: "",
                            callback: (val: string) => this.updateInput(val, 'password')
                        }}
                    />

                    <ButtonAtom title="VERIFY" type="submit" />
                    <SpacerAtom />
                    <div className="text-center flex">Or</div>
                    <SpacerAtom />
                    <ButtonAtom
                        title="LOG OUT"
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

export default withRouter(VerifyPasswordPage);
