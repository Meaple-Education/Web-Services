import React from 'react';

interface IProps {
    position?: 'absolute' | 'fixed'
}

class OverlayLoadingAtom extends React.Component<IProps> {
    render() {
        return <div className={`overlay-loading-atom ${this.props.position ?? 'fixed'}`}>
            <img src="/images/loading.svg" />
        </div >
    }
}

export default OverlayLoadingAtom;
