import React from "react"
import { Link } from "react-router-dom";
import { SchoolItemInterface } from "../../interfaces/school/SchoolInterface";
import { BuildPath, PageEndpoint } from "../../routes/PageEndPoint";

interface IProps {
    school: SchoolItemInterface,
}

class SchoolListItemAtom extends React.Component<IProps> {
    render() {
        return <Link to={{ pathname: BuildPath(PageEndpoint.dashboard, { 'schoolID': this.props.school.id }) }}>
            {this.props.school.name}&nbsp;&nbsp;&nbsp;
        </Link>
    }
}

export default SchoolListItemAtom;
