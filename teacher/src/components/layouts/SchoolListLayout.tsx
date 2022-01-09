import React from 'react';
import ImageAtom from '../atoms/ImageAtom';

class SchoolListLayout extends React.Component {
    render() {
        return <div className='school-list'>
            <header className='dashboard-header'>
                <ImageAtom src="/images/logo.png" figureClass="dashboard-logo" />
                <div>user info widget</div>
            </header>
            <main className="dashboard-content">
                {this.props.children}
            </main>
            <footer className="dashboard-footer">
                &copy;{new Date().getFullYear()} Meaple Education
            </footer>
        </div>;
    }
}

export default SchoolListLayout;
