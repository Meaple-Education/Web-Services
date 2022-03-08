import React from 'react';
import { connect } from 'react-redux';
import { Link } from 'react-router-dom';
import { ClassReducerInterface } from '../../../interfaces/class/ClassInterface';
import { StoreState } from '../../../redux/reducers';
import { BuildPath, PageEndpoint } from '../../../routes/PageEndPoint';
import ContainerAtom from '../../atoms/ContainerAtom';
import ScrollableAtom from '../../atoms/ScrollableAtom';
import ContentMenuLayout from '../../layouts/ContentMenuLayout';
import StandardLayout from '../../layouts/StandardLayout';

interface IProps {
    classState: ClassReducerInterface;
}

class ClassDetailPage extends React.Component<IProps> {
    render() {
        const { classState } = this.props;

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
                <ScrollableAtom>
                    <ContainerAtom>
                        <div data-test="ClassDetailPage">
                            {classState.classLoading &&
                                <>Loading...</>
                            }
                            {!classState.classLoading &&
                                <>
                                    Class Detail page
                                </>
                            }
                        </div>
                    </ContainerAtom>
                </ScrollableAtom>
            </StandardLayout.Content>
        </StandardLayout>;
    }
}

export default connect(({ classState }: StoreState) => {
    return { classState };
}, {})(ClassDetailPage);
