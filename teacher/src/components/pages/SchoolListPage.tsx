import React from 'react';
import FormAtom from '../atoms/FormAtom';
import PopupAtom from '../atoms/PopupAtom';
import SchoolListLayout from '../layouts/SchoolListLayout';
import LabelInputMolecule from '../molecules/LabelInputMolecule';
import SchoolService from '../../services/SchoolService';
import ButtonAtom from '../atoms/ButtonAtom';
import { connect } from 'react-redux';
import { StoreState } from '../../redux/reducers';
import { SchoolReducerInterface } from '../../interfaces/school/SchoolInterface';
import { AddSchool, addSchool } from '../../redux/actions';
import SchoolListItemAtom from '../atoms/SchoolListItemAtom';

interface IProps {
    schoolState: SchoolReducerInterface,
    addSchool: AddSchool
}

interface IStates {
    openCreateForm: boolean;
    name: string;
    address: string;
    description: string;
    phone: string[];
}

class SchoolListPage extends React.Component<IProps, IStates> {
    constructor(props: IProps) {
        super(props);
        this.state = {
            openCreateForm: false,
            name: '',
            address: '',
            description: '',
            phone: [],
        };
    }

    toggleCreateForm = () => {
        this.setState({
            openCreateForm: !this.state.openCreateForm,
        });
    }

    updateInput = (value: string, name: string) => {
        this.setState({
            ...this.state,
            [name]: value,
        })
    }

    createSchool = async () => {
        let schoolService = new SchoolService();

        let createSchool = await schoolService.createSchool(
            this.state.name,
            this.state.address,
            this.state.description,
            this.state.phone,
        );

        if (!createSchool.status) {
            alert(createSchool.msg);
            return;
        }

        this.props.addSchool(createSchool.data);

        this.setState({
            name: '',
            address: '',
            description: '',
            phone: [],
            openCreateForm: false,
        });
    }

    render() {
        const {
            openCreateForm,
            name,
            phone,
            address,
            description,
        } = this.state;

        return <div data-test="dashboardPage">
            <SchoolListLayout>
                {
                    this.props.schoolState.list.map(s => <SchoolListItemAtom school={s} />)
                }
                <div onClick={this.toggleCreateForm}>Add new school</div>
            </SchoolListLayout>
            {
                openCreateForm &&
                <PopupAtom
                    closeConfirmation={name !== '' || address !== ''}
                    processing={false}
                    closeCallback={() => {
                        this.setState({
                            openCreateForm: false,
                        })
                    }}
                >
                    <div>
                        <FormAtom
                            restrict={true}
                            callback={this.createSchool}
                        >
                            <LabelInputMolecule
                                label={{
                                    title: "Name",
                                    for: "cfSchoolName"
                                }}
                                input={{
                                    id: "cfSchoolName",
                                    type: "text",
                                    name: "name",
                                    placeholder: "School Name",
                                    initialValue: "",
                                    callback: (val: string) => this.updateInput(val, 'name')
                                }}
                            />
                            <LabelInputMolecule
                                label={{
                                    title: "Address",
                                    for: "cfSchoolAddress"
                                }}
                                input={{
                                    id: "cfSchoolAddress",
                                    type: "text",
                                    name: "address",
                                    placeholder: "School Address",
                                    initialValue: "",
                                    callback: (val: string) => this.updateInput(val, 'address')
                                }}
                            />
                            <LabelInputMolecule
                                label={{
                                    title: "Description",
                                    for: "cfSchoolDescription"
                                }}
                                input={{
                                    id: "cfSchoolDescription",
                                    type: "text",
                                    name: "description",
                                    placeholder: "School Description",
                                    initialValue: "",
                                    callback: (val: string) => this.updateInput(val, 'description')
                                }}
                            />
                            <ButtonAtom
                                type='submit'
                                title='Submit'
                            />
                        </FormAtom>
                    </div>
                </PopupAtom>
            }
        </div>;
    }
}

export default connect(({ schoolState }: StoreState) => {
    return { schoolState }
}, {
    addSchool
})(SchoolListPage);
