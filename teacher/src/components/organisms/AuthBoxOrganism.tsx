import React from 'react';

class AuthBoxOrganism extends React.Component {
    render() {
        return (
            <div className="auth-box-organism">
                {this.props.children}
            </div>
        );
    }
}

export default AuthBoxOrganism;
