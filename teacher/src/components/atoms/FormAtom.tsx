import React from 'react';
import { FormAtomPropsInterface } from '../../interfaces/components/atoms/FormAtomInterface';

interface IProps extends FormAtomPropsInterface { }

class FormAtom extends React.Component<IProps> {
    handleSubmit = (e: React.ChangeEvent<HTMLFormElement>) => {
        if (this.props.restrict) {
            e.preventDefault();

            if (this.props.callback) {
                this.props.callback()
            }
        }

        return true;
    }

    render() {
        return <>
            <form className={`form-atom`} onSubmit={this.handleSubmit} action={this.props.action ?? ''} method={this.props.method ?? ''}>
                {this.props.children}
            </form>
        </>
    }
}

export default FormAtom;
