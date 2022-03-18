import React from 'react';
import { InputAtomPropInterface } from '../../interfaces/components/atoms/InputAtomInterface';
import { LabelAtomPropsInterface } from '../../interfaces/components/atoms/LabelAtomInterface';
import InputAtom from '../atoms/InputAtom';
import LabelAtom from '../atoms/LabelAtom';
import SpacerAtom from '../atoms/SpacerAtom';

interface IProps {
    label: LabelAtomPropsInterface;
    input: InputAtomPropInterface;
}

export default class LabelInputMolecule extends React.Component<IProps> {
    render() {
        return <div className="label-input-molecules">
            <LabelAtom {...this.props.label} />
            <SpacerAtom height={10} />
            <InputAtom {...this.props.input} />
        </div>;
    }
}
