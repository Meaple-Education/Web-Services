import React from 'react';
import { LabelAtomPropsInterface } from '../../interfaces/components/atoms/LabelAtomInterface';

interface IProps extends LabelAtomPropsInterface { }

class LabelAtom extends React.Component<IProps> {
    render() {
        return <label htmlFor={(this.props.for ?? '').toString()} className="label-atom">{this.props.title}</label>;
    }
}

export default LabelAtom;
