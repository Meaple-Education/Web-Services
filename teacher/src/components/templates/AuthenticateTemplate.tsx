import React from 'react';

class AuthenticateTemplate extends React.Component {
    render() {
        return <div className='non-auth-template'>
            {this.props.children}
        </div>;
    }
}

export default AuthenticateTemplate;
