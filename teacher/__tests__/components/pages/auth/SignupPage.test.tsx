
import ReactDOM from 'react-dom';
import ReactTestUtils, { act } from 'react-dom/test-utils';
import SignupPage from '../../../../src/components/pages/auth/SignupPage';

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

describe("Signup page Test", () => {
    it('Signup page should render', () => {
        if (container) {
            act(() => { ReactDOM.render(<SignupPage />, container); });
            expect(container.querySelector('[data-test="signupPage"]')?.innerHTML).toBe('SignupPage TO BE IMPLEMENTED');
        }
    })
})

export { }
