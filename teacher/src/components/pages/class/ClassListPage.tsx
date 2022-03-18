import React from 'react';
import { connect } from 'react-redux';
import { Link, RouteComponentProps } from 'react-router-dom';
import { ClassReducerInterface } from '../../../interfaces/class/ClassInterface';
import { StoreState } from '../../../redux/reducers';
import { BuildPath, PageEndpoint } from '../../../routes/PageEndPoint';
import SchoolClassService from '../../../services/SchoolClassService';
import ContainerAtom from '../../atoms/ContainerAtom';
import ScrollableAtom from '../../atoms/ScrollableAtom';
import StandardLayout from '../../layouts/StandardLayout';

interface IProps {
    classState: ClassReducerInterface;
}

interface IStates {
    classes: any[];
}

class ClassListPage extends React.Component<IProps, IStates> {
    private classService = new SchoolClassService();

    constructor(props: IProps) {
        super(props);

        this.state = {
            classes: [],
        };
    }

    componentDidMount() {
        console.log("ASD");
        this.loadClass();
    }

    loadClass = async (page: number = 1) => {
        let loadClass = await this.classService.fetchClasses(this.props.classState.schoolID, page);

        if (!loadClass.status) {
            alert(loadClass.msg);
            return;
        }

        this.setState({
            classes: loadClass.data,
        });
    }

    render() {
        const { classes } = this.state;

        return <StandardLayout>
            <StandardLayout.Sidebar>
                <ul>
                    <li>TO be implemented</li>
                </ul>
            </StandardLayout.Sidebar>
            <StandardLayout.Header>
                Class List
            </StandardLayout.Header>
            <StandardLayout.Content>
                <ScrollableAtom>
                    <ContainerAtom>
                        <div data-test="ClassListPage">
                            <div>
                                ClassListPage TO BE IMPLEMENTED
                                <Link to={BuildPath(PageEndpoint.classCreate, { schoolID: this.props.classState.schoolID })}>
                                    Create class
                                </Link>
                            </div>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Class ID</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {
                                        classes.map((c, i) => {
                                            return <tr key={i}>
                                                <td>{c.id}</td>
                                                <td>{c.name}</td>
                                                <td>{c.description}</td>
                                                <td>
                                                    <Link to={BuildPath(
                                                        PageEndpoint.classDetail, {
                                                        schoolID: this.props.classState.schoolID,
                                                        classID: c.id,
                                                    })}>Edit</Link>
                                                </td>
                                            </tr>;
                                        })
                                    }
                                </tbody>
                            </table>
                        </div>
                    </ContainerAtom>
                </ScrollableAtom>
            </StandardLayout.Content>
        </StandardLayout>;
    }
}

export default connect(({ classState }: StoreState) => {
    return { classState }
}, {})(ClassListPage);
