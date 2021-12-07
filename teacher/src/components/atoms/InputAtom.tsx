import React from 'react';
import { InputAtomPropInterface } from '../../interfaces/components/atoms/InputIAtomInterface';

interface IProps extends InputAtomPropInterface { }

class InputAtom extends React.Component<IProps> {
    updateInput = (e: React.ChangeEvent<HTMLInputElement>) => {
        this.props.callback(e.target.value)
    }

    render() {
        return <>
            <input id={this.props.id ?? ''} name={this.props.name ?? ''} type={this.props.type ?? 'text'} onChange={this.updateInput} className="input-atom" placeholder={this.props.placeholder ?? ''} />
        </>;
    }
}

export default InputAtom;
