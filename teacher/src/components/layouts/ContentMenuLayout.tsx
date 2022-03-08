import React from 'react';
import { Link } from 'react-router-dom';
import { NavItemInterface } from '../../interfaces/NavItemInterface';

interface ContentMenuLayoutProps {
    items: NavItemInterface[];
    activeSection: string;
    callback?(section: string): void;
}

interface ContentMenuLayoutState { }

class ContentMenuLayout extends React.Component<ContentMenuLayoutProps, ContentMenuLayoutState>{
    render() {
        return (
            <ul className="sub-menu">
                {this.props.items.map((item, index) => <li key={index} className={`sub-menu-item ${this.props.activeSection === item.section ? 'current-section' : ''}`}>
                    {
                        item.link &&
                        <Link to={item.link}>{item.name}</Link>
                    }
                    {
                        item.link === undefined &&
                        <button type="button" onClick={() => this.props.callback ? this.props.callback(item.section) : null}>
                            {item.name}
                        </button>
                    }
                </li>)}
            </ul>
        )
    }
}

export default ContentMenuLayout;
