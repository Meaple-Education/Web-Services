import React from 'react';

class NonAuthTemplate extends React.Component {
    render() {
        return <div className='non-auth-template'>
            {this.props.children}
        </div>;
    }
}

export default NonAuthTemplate;
