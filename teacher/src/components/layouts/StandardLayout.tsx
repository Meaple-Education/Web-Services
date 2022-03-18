import React from 'react';
import ImageAtom from '../atoms/ImageAtom';
import StandardSideNav from './StandardSideNav';

function Sidebar(props: any) {
    return null;
}

function Header(props: any) {
    return null;
}

function Content(props: any) {
    return null;
}

class StandardLayout extends React.Component {
    static Sidebar = Sidebar;
    static Header = Header;
    static Content = Content;

    render(): React.ReactNode {
        // console.log(this.props.location);

        const { children }: any = this.props;
        let childProps = children;

        if (!Array.isArray(childProps)) {
            childProps = [childProps];
        }

        const sidebar = childProps.find((el: any) => el.type === Sidebar)
        const header = childProps.find((el: any) => el.type === Header)
        const content = childProps.find((el: any) => el.type === Content)

        return <div className="st-root">
            <aside className="st-sidebar">
                <StandardSideNav />
                <div className="st-sub-nav">
                    <ImageAtom src="/images/logo.png" figureClass="cm-logo" />

                    {sidebar ? sidebar.props.children : null}
                </div>
            </aside>
            <section className="st-main">
                <header className="st-header">
                    <div>
                        {header ? header.props.children : null}
                    </div>
                    <div>Admin info here</div>
                </header>
                <main className="st-content">
                    {content ? content.props.children : null}
                </main>
            </section>
        </div>;
    }
}

export default StandardLayout;
