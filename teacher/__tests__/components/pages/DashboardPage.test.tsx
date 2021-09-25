
import ReactDOM from 'react-dom';
import ReactTestUtils, { act } from 'react-dom/test-utils';
import DashboardPage from '../../../src/components/pages/DashboardPage';

let container: ReactDOM.Container | null;

beforeEach(() => {
    container = document.createElement('div');
    document.body.appendChild(container);
});

afterEach(() => {
    if (container) {
        document.body.removeChild(container);
    }
    container = null;
});

describe("Dashboard page Test", () => {
    it('Dashboard page should render', () => {
        if (container) {
            act(() => { ReactDOM.render(<DashboardPage />, container); });
            expect(container.querySelector('[data-test="dashboardPage"]')?.innerHTML).toBe('DashboardPage TO BE IMPLEMENTED');
        }
    })
})

export { }
