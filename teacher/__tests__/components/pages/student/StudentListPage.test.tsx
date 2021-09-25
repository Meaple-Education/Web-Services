
import ReactDOM from 'react-dom';
import ReactTestUtils, { act } from 'react-dom/test-utils';
import StudentListPage from '../../../../src/components/pages/student/StudentListPage';

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

describe("StudentList page Test", () => {
    it('StudentList page should render', () => {
        if (container) {
            act(() => { ReactDOM.render(<StudentListPage />, container); });
            expect(container.querySelector('[data-test="studentListPage"]')?.innerHTML).toBe('StudentListPage TO BE IMPLEMENTED');
        }
    })
})

export { }
