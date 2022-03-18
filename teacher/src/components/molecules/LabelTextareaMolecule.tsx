import React from 'react';
import { LabelAtomPropsInterface } from '../../interfaces/components/atoms/LabelAtomInterface';
import { TextareaAtomPropInterface } from '../../interfaces/components/atoms/TextareaAtomInterface';
import LabelAtom from '../atoms/LabelAtom';
import SpacerAtom from '../atoms/SpacerAtom';
import TextareaAtom from '../atoms/TextareaAtom';

interface IProps {
    label: LabelAtomPropsInterface;
    input: TextareaAtomPropInterface;
}

export default class LabelTextAreaMolecule extends React.Component<IProps> {
    render() {
        return <div className="label-input-molecules">
            <LabelAtom {...this.props.label} />
            <SpacerAtom height={10} />
            <TextareaAtom {...this.props.input} />
        </div>;
    }
}
