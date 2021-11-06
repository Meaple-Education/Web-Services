import React from 'react';
import { ButtonAtomPropsInterface } from '../../interfaces/components/atoms/ButtonAtomInterface';

interface IProps extends ButtonAtomPropsInterface {
}

class ButtonAtom extends React.Component<IProps> {
    render() {
        return <button className="button-atom" type={this.props.type ?? 'button'} onClick={() => {
            if (this.props.callback) {
                this.props.callback();
            }
        }}>{this.props.title}</button>;
    }
}

export default ButtonAtom;
