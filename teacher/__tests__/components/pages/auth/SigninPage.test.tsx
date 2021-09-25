
import ReactDOM from 'react-dom';
import ReactTestUtils, { act } from 'react-dom/test-utils';
import SigninPage from '../../../../src/components/pages/auth/SigninPage';

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

describe("Signin page Test", () => {
    it('Signin page should render', () => {
        if (container) {
            act(() => { ReactDOM.render(<SigninPage />, container); });
            expect(container.querySelector('[data-test="signinPage"]')?.innerHTML).toBe('SigninPage TO BE IMPLEMENTED');
        }
    })
})

export { }
