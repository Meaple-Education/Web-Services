import React from 'react';
import { connect } from 'react-redux';
import { Link, RouteComponentProps } from 'react-router-dom';
import { ClassReducerInterface } from '../../../interfaces/class/ClassInterface';
import { StoreState } from '../../../redux/reducers';
import { BuildPath, PageEndpoint } from '../../../routes/PageEndPoint';
import SchoolClassService from '../../../services/SchoolClassService';
import ContainerAtom from '../../atoms/ContainerAtom';
import ScrollableAtom from '../../atoms/ScrollableAtom';
import ContentMenuLayout from '../../layouts/ContentMenuLayout';
import SplitLayout from '../../layouts/SplitLayout';
import StandardLayout from '../../layouts/StandardLayout';
import LabelInputMolecule from '../../molecules/LabelInputMolecule';
import LabelTextAreaMolecule from '../../molecules/LabelTextareaMolecule';

interface RouteInfo {
    classID: string;
}

interface IProps extends RouteComponentProps<RouteInfo> {
    classState: ClassReducerInterface;
}

interface IStates {
    name: string;
    description: string;
    loading: boolean;
    edit: boolean;
}

class ClassDetailPage extends React.Component<IProps, IStates> {
    constructor(props: IProps) {
        super(props);
        this.state = {
            name: '',
            description: '',
            loading: false,
            edit: false,
        }
    }

    componentDidMount() {
        this.fetchClassInfo();
    }

    fetchClassInfo = async () => {
        let classService = new SchoolClassService();
        let fetchClass = await classService.fetchClass(this.props.classState.schoolID, this.props.match.params.classID);

        if (!fetchClass.status) {
            alert("Failed to fetch class info!");
            return;
        }

        this.setState({
            name: fetchClass.data.name,
            description: fetchClass.data.description,
        });
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
        let updateClass = await classService.updateClass(this.props.classState.schoolID, this.props.match.params.classID, name, description);

        if (!updateClass.status) {
            this.setState({
                loading: false,
            });
            alert(updateClass.msg);
            return;
        }

        this.setState({
            edit: false,
        });
    }

    render() {
        const { classState } = this.props;
        const {
            loading,
            description,
            name,
            edit,
        } = this.state;

        return <StandardLayout>
            <StandardLayout.Sidebar>
                <ContentMenuLayout
                    items={[
                        {
                            name: 'Info',
                            section: 'info'
                        },
                        {
                            name: 'Schedule',
                            section: 'schedule'
                        },
                        {
                            name: 'Teacher',
                            section: 'teacher'
                        },
                        {
                            name: 'Student',
                            section: 'student'
                        },
                        {
                            name: 'Back to class list',
                            section: 'backToList',
                            link: BuildPath(PageEndpoint.classList, { schoolID: this.props.classState.schoolID }),
                        },
                    ]}
                    activeSection="info"
                />
            </StandardLayout.Sidebar>
            <StandardLayout.Header>
                Class detail
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
                                            initialValue: name,
                                            disabled: !edit,
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
                                            initialValue: description,
                                            disabled: !edit,
                                            callback: (val: string) => this.updateInput(val, 'description')
                                        }}
                                    />
                                </div>
                            </ContainerAtom>
                        </ScrollableAtom>
                    </SplitLayout.LeftSide>
                    <SplitLayout.LeftSideFooterAction>
                        <div className="footer-action-con">
                            {
                                edit &&
                                <>
                                    <button
                                        className="action-cancel"
                                        onClick={() => {
                                            this.setState({
                                                edit: false,
                                            });
                                        }}
                                    >Cancel</button>
                                    <button
                                        onClick={this.handleSubmit}
                                        className="action-save"
                                        type="submit"
                                        disabled={loading}
                                    >
                                        {loading ? 'processing ....' : 'Update'}
                                    </button>
                                </>
                            }
                            {
                                !edit &&
                                <button className="action-cancel" onClick={() => {
                                    this.setState({
                                        edit: true,
                                    });
                                }}>Edit</button>
                            }
                        </div>
                    </SplitLayout.LeftSideFooterAction>
                </SplitLayout>

            </StandardLayout.Content>
        </StandardLayout>;
    }
}

export default connect(({ classState }: StoreState) => {
    return { classState };
}, {})(ClassDetailPage);
