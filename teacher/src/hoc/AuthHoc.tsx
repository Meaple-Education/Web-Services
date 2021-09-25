import React from 'react';

interface IProps { }

interface IStates {
}

export default function AuthHoc(ComponentToProtect: any) {
    return class extends React.Component<
        IProps,
        IStates
    > {
        constructor(props: IProps) {
            super(props);
            this.state = {
            };
        }

        componentDidMount() {

        }

        render() {
            return (
                <React.Fragment>
                    <ComponentToProtect {...this.props} />
                </React.Fragment>
            );
        }
    }
}
