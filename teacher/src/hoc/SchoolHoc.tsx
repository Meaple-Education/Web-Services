
import React from 'react';
import { connect } from 'react-redux';
import { RouteComponentProps } from 'react-router';
import { StoreState } from '../redux/reducers';
import { setSchoolID, SetSchoolIDState } from '../redux/actions'
import { ClassReducerInterface } from '../interfaces/class/ClassInterface';

interface RouteInfo {
    schoolID: string;
}

interface IProps extends RouteComponentProps<RouteInfo> {
    classState: ClassReducerInterface;
    setSchoolID: SetSchoolIDState;
}

interface IStates {
}

export default function SchoolHoc(ComponentToProtect: any) {
    class SchoolHoc extends React.Component<
        IProps,
        IStates
    > {
        constructor(props: IProps) {
            super(props);
            this.state = {
            };
        }

        componentDidMount() {
            this.props.setSchoolID(parseInt(this.props.match.params.schoolID));
        }

        render() {
            if (this.props.classState.schoolID === 0) {
                return <>Loading...</>
            }
            return (
                <React.Fragment>
                    <ComponentToProtect {...this.props} />
                </React.Fragment>
            );
        }
    }

    return connect(({ classState }: StoreState) => {
        return {
            classState,
        };
    }, {
        setSchoolID,
    })(SchoolHoc)
}
