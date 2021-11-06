import React from 'react';
import { Link } from 'react-router-dom';

interface IProps {
    url: string;
    title: string;
}

class LinkButtonAtom extends React.Component<IProps> {
    render() {
        return <Link className="button-atom" to={this.props.url}>{this.props.title}</Link>;
    }
}

export default LinkButtonAtom;
