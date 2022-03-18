import React from 'react';
import ContainerAtom from '../atoms/ContainerAtom';
import ScrollableAtom from '../atoms/ScrollableAtom';
import StandardLayout from '../layouts/StandardLayout';

class DashboardPage extends React.Component {
    render() {
        return <StandardLayout>
            <StandardLayout.Sidebar>
                <ul>
                    <li>TO be implemented</li>
                </ul>
            </StandardLayout.Sidebar>
            <StandardLayout.Header>
                Dashboard
            </StandardLayout.Header>
            <StandardLayout.Content>
                <ScrollableAtom>
                    <ContainerAtom>
                        <div data-test="dashboardPage">
                            <h3>DashboardPage TO BE IMPLEMENTED</h3>
                            <section>
                                <ul>
                                    <li>
                                        Total class<br />13
                                    </li>
                                    <li>
                                        Total student<br />135
                                    </li>
                                    <li>
                                        Total teacher<br />5
                                    </li>
                                    <li>
                                        Attendnace<br />85%
                                    </li>
                                </ul>
                            </section>
                            <section>Weekly class attendance report</section>
                            <section>Class by class attendance report</section>
                            <section>Class by class attendance report</section>
                        </div>
                    </ContainerAtom>
                </ScrollableAtom>
            </StandardLayout.Content>
        </StandardLayout>;
    }
}

export default DashboardPage;
