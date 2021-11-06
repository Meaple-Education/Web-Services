import React, { CSSProperties } from 'react';

interface IProps {
    height?: number;
}

interface CSSProp extends CSSProperties {
    "--height": string
}

class SpacerAtom extends React.Component<IProps> {
    render() {
        const cssProps: CSSProp = { "--height": (this.props.height ?? 20).toString() + "px" }
        return <>
            <div className="spacer-atom" style={cssProps}>&nbsp;</div>
        </>;
    }
}

export default SpacerAtom;
