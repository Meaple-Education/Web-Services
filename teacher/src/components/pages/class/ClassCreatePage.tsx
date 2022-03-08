import React from 'react';
import { connect } from 'react-redux';
import { Link, RouteComponentProps, withRouter } from 'react-router-dom';
import { ClassReducerInterface } from '../../../interfaces/class/ClassInterface';
import { StoreState } from '../../../redux/reducers';
import { BuildPath, PageEndpoint } from '../../../routes/PageEndPoint';
import SchoolClassService from '../../../services/SchoolClassService';
import ContainerAtom from '../../atoms/ContainerAtom';
import InputAtom from '../../atoms/InputAtom';
import ScrollableAtom from '../../atoms/ScrollableAtom';
import ContentMenuLayout from '../../layouts/ContentMenuLayout';
import SplitLayout from '../../layouts/SplitLayout';
import StandardLayout from '../../layouts/StandardLayout';
import LabelInputMolecule from '../../molecules/LabelInputMolecule';
import LabelTextAreaMolecule from '../../molecules/LabelTextareaMolecule';

interface IProps extends RouteComponentProps {
    classState: ClassReducerInterface;
}

interface IStates {
    name: string;
    description: string;
    loading: boolean;
}

class ClassCreatePage extends React.Component<IProps, IStates> {
    constructor(props: IProps) {
        super(props);
        this.state = {
            name: '',
            description: '',
            loading: false,
        }
    }

    updateInput = (value: string, name: string) => {
        this.setState({
            ...this.state,
            [name]: value,
        })
    }

    handleSubmit = async () => {
        const { name, description } = this.state;

        if (name === '') {
            alert("Name cannot be empty!");
            return;
        }

        if (description === '') {
            alert("Description cannot be empty!");
            return;
        }

        this.setState({
            loading: true,
        });

        let classService = new SchoolClassService();
        let createClass = await classService.createClass(this.props.classState.schoolID, name, description);

        if (!createClass.status) {
            this.setState({
                loading: false,
            });
            alert(createClass.msg);
            return;
        }

        this.props.history.push(BuildPath(PageEndpoint.classList, { schoolID: this.props.classState.schoolID }));
    }

    render() {
        const { loading } = this.state;

        return <StandardLayout>
            <StandardLayout.Sidebar>
                <ul className="sub-menu">
                    <li className="sub-menu-item">
                        <Link to={BuildPath(PageEndpoint.classList, { schoolID: this.props.classState.schoolID })}>Back to class list</Link>
                    </li>
                </ul>
            </StandardLayout.Sidebar>
            <StandardLayout.Header>
                Create class
            </StandardLayout.Header>
            <StandardLayout.Content>
                <SplitLayout>
                    <SplitLayout.LeftSide>
                        <ScrollableAtom>
                            <ContainerAtom>
                                <div data-test="ClassCreatePage">
                                    <LabelInputMolecule
                                        label={{
                                            title: "Name",
                                            for: "cfClassName"
                                        }}
                                        input={{
                                            id: "cfClassName",
                                            type: "text",
                                            name: "name",
                                            placeholder: "Class Name",
                                            initialValue: "",
                                            callback: (val: string) => this.updateInput(val, 'name')
                                        }}
                                    />
                                </div>
                                <div data-test="ClassCreatePage">
                                    <LabelTextAreaMolecule
                                        label={{
                                            title: "Description",
                                            for: "cfClassDesc"
                                        }}
                                        input={{
                                            id: "cfClassDesc",
                                            name: "desc",
                                            placeholder: "Class Description",
                                            initialValue: "",
                                            callback: (val: string) => this.updateInput(val, 'description')
                                        }}
                                    />
                                </div>
                            </ContainerAtom>
                        </ScrollableAtom>
                    </SplitLayout.LeftSide>
                    <SplitLayout.LeftSideFooterAction>
                        <div className="footer-action-con">
                            <Link className="action-cancel" to={BuildPath(PageEndpoint.classList, { schoolID: this.props.classState.schoolID })}>Cancel</Link>
                            <button
                                onClick={this.handleSubmit}
                                className="action-save"
                                type="submit"
                                disabled={loading}
                            >
                                {loading ? 'processing ....' : 'Create'}
                            </button>
                        </div>
                    </SplitLayout.LeftSideFooterAction>
                </SplitLayout>
            </StandardLayout.Content>
        </StandardLayout>
    }
}

export default connect(({ classState }: StoreState) => {
    return { classState };
}, {})(withRouter(ClassCreatePage));
