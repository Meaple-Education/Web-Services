
import ReactDOM from 'react-dom';
import ReactTestUtils, { act } from 'react-dom/test-utils';
import StudentDetailPage from '../../../../src/components/pages/student/StudentDetailPage';

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

describe("StudentDetail page Test", () => {
    it('StudentDetail page should render', () => {
        if (container) {
            act(() => { ReactDOM.render(<StudentDetailPage />, container); });
            expect(container.querySelector('[data-test="studentDetailPage"]')?.innerHTML).toBe('StudentDetailPage TO BE IMPLEMENTED');
        }
    })
})

export { }
