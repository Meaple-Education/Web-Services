import React from 'react';

function LeftSide(props: any) {
    return null;
}

function LeftSideFooterAction(props: any) {
    return null;
}

function RightSide(props: any) {
    return null;
}

class SplitLayout extends React.Component {
    static LeftSide = LeftSide;
    static LeftSideFooterAction = LeftSideFooterAction;
    static RightSide = RightSide;

    render() {
        const { children }: any = this.props;
        let childProps = children;

        if (!Array.isArray(childProps)) {
            childProps = [childProps];
        }

        const leftSide = childProps.find((el: any) => el.type === LeftSide)
        const rightSide = childProps.find((el: any) => el.type === RightSide)
        const leftSideFooterAction = childProps.find((el: any) => el.type === LeftSideFooterAction)

        return (
            <div className="split-layout">
                <div className="sl-left">
                    {leftSide &&
                        <>
                            <div className="sl-l-main-content">
                                {leftSide.props.children}
                            </div>
                            {leftSideFooterAction ? leftSideFooterAction.props.children : null}
                        </>
                    }
                </div>
                <div className="sl-right">
                    {rightSide ? rightSide.props.children : null}
                </div>
            </div>
        )
    }
}


export default SplitLayout;
