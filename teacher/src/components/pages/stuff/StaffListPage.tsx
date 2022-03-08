import React from 'react';
import ContainerAtom from '../../atoms/ContainerAtom';
import ScrollableAtom from '../../atoms/ScrollableAtom';
import StandardLayout from '../../layouts/StandardLayout';

class StaffListPage extends React.Component {
    render() {
        return <StandardLayout>
            <StandardLayout.Sidebar>
                <ul>
                    <li>TO be implemented</li>
                </ul>
            </StandardLayout.Sidebar>
            <StandardLayout.Header>
                Stuff List
            </StandardLayout.Header>
            <StandardLayout.Content>
                <ScrollableAtom>
                    <ContainerAtom>
                        <div data-test="StuffListPage">StuffListPage TO BE IMPLEMENTED</div>
                    </ContainerAtom>
                </ScrollableAtom>
            </StandardLayout.Content>
        </StandardLayout>;;
    }
}

export default StaffListPage;
