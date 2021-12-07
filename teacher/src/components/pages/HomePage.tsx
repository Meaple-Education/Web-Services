import React from 'react';
import { Link } from 'react-router-dom';
import { PageEndpoint } from '../../routes/PageEndPoint';

class HomePage extends React.Component {
    render() {
        return <div data-test="homePage">
            HomePage TO BE IMPLEMENTED
            <br />
            <ul>
                <li><Link to={PageEndpoint.signin}>Login</Link></li>
            </ul>
        </div>;
    }
}

export default HomePage;
