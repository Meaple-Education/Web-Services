
import ReactDOM from 'react-dom';
import ReactTestUtils, { act } from 'react-dom/test-utils';
import StudentCreatePage from '../../../../src/components/pages/student/StudentCreatePage';

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

describe("StudentCreate page Test", () => {
    it('StudentCreate page should render', () => {
        if (container) {
            act(() => { ReactDOM.render(<StudentCreatePage />, container); });
            expect(container.querySelector('[data-test="studentCreatePage"]')?.innerHTML).toBe('StudentCreatePage TO BE IMPLEMENTED');
        }
    })
})

export { }
