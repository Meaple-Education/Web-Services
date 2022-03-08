
import React from 'react';
import { connect } from 'react-redux';
import { RouteComponentProps } from 'react-router';
import { StoreState } from '../redux/reducers';
import { LoadClassInfo, loadClassInfo, SetClassLoadingState, setClassLoading } from '../redux/actions'
import { ClassReducerInterface } from '../interfaces/class/ClassInterface';

interface RouteInfo {
    classID: string;
}

interface IProps extends RouteComponentProps<RouteInfo> {
    classState: ClassReducerInterface;
    loadClassInfo: LoadClassInfo;
    setClassLoading: SetClassLoadingState;
}

interface IStates {
}

export default function ClassHoc(ComponentToProtect: any) {
    class ClassHoc extends React.Component<
        IProps,
        IStates
    > {
        constructor(props: IProps) {
            super(props);
            this.state = {
            };
        }

        componentDidMount() {
            this.props.setClassLoading(true);
            this.props.loadClassInfo(parseInt(this.props.match.params.classID));
        }

        render() {
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
        loadClassInfo,
        setClassLoading,
    })(ClassHoc)
}
