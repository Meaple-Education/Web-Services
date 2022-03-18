import React from 'react';
import { TextareaAtomPropInterface } from '../../interfaces/components/atoms/TextareaAtomInterface';

interface IProps extends TextareaAtomPropInterface { }

class TextareaAtom extends React.Component<IProps> {
    updateInput = (e: React.ChangeEvent<HTMLTextAreaElement>) => {
        this.props.callback(e.target.value)
    }

    render() {
        return <>
            <textarea
                id={this.props.id ?? ''}
                name={this.props.name ?? ''}
                onChange={this.updateInput}
                className="textarea-atom"
                placeholder={this.props.placeholder ?? ''}
                value={this.props.initialValue}
                disabled={this.props.disabled ?? false}
            ></textarea>
        </>;
    }
}

export default TextareaAtom;
