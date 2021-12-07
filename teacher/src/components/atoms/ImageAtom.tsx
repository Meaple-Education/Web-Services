import React from 'react';
import { ImageAtomPropsInterface } from '../../interfaces/components/atoms/ImageAtomInterface';

interface IProps extends ImageAtomPropsInterface {
}

class ImageAtom extends React.Component<IProps> {
    render() {
        return <figure className={`image-atom ${this.props.figureClass ?? ''}`}>
            <img src={this.props.src} alt={this.props.alt ?? ''} title={this.props.title ?? ''} className={`${this.props.imgClass ?? ''}`} />
        </figure>;
    }
}

export default ImageAtom;
