import React from "react";
import { connect } from "react-redux";
import { Link } from "react-router-dom";
import { ClassReducerInterface } from "../../interfaces/class/ClassInterface";
import { StoreState } from "../../redux/reducers";
import { BuildPath, PageEndpoint } from "../../routes/PageEndPoint";

interface IProps {
    classState: ClassReducerInterface;
};

class StandardSideNav extends React.Component<IProps> {
    render(): React.ReactNode {
        return <nav className="st-nav">
            <ul>
                <li>
                    <Link to={BuildPath(PageEndpoint.dashboard, { 'schoolID': this.props.classState.schoolID })} className="st-nav-link">
                        <i className="material-icons">dashboard</i>
                    </Link>
                </li>
                <li>
                    <Link to={BuildPath(PageEndpoint.classList, { 'schoolID': this.props.classState.schoolID })} className="st-nav-link">
                        <i className="material-icons">class</i>
                    </Link>
                </li>
                <li>
                    <Link to={BuildPath(PageEndpoint.studentList, { 'schoolID': this.props.classState.schoolID })} className="st-nav-link">
                        <i className="material-icons">groups</i>
                    </Link>
                </li>
                <li>
                    <Link to={BuildPath(PageEndpoint.gurdianList, { 'schoolID': this.props.classState.schoolID })} className="st-nav-link">
                        <i className="material-icons">supervisor_account</i>
                    </Link>
                </li>
                <li>
                    <Link to={BuildPath(PageEndpoint.staffList, { 'schoolID': this.props.classState.schoolID })} className="st-nav-link">
                        <i className="material-icons">badge</i>
                    </Link>
                </li>
                <li>
                    <Link to={BuildPath(PageEndpoint.setting, { 'schoolID': this.props.classState.schoolID })} className="st-nav-link">
                        <i className="material-icons">settings</i>
                    </Link>
                </li>
            </ul>
        </nav>;
    }
}

export default connect(({ classState }: StoreState) => {
    return { classState };
}, {})(StandardSideNav);
