
import ReactDOM from 'react-dom';
import ReactTestUtils, { act } from 'react-dom/test-utils';
import ProfilePage from '../../../src/components/pages/ProfilePage';

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

describe("Profile page Test", () => {
    it('Profile page should render', () => {
        if (container) {
            act(() => { ReactDOM.render(<ProfilePage />, container); });
            expect(container.querySelector('[data-test="profilePage"]')?.innerHTML).toBe('ProfilePage TO BE IMPLEMENTED');
        }
    })
})

export { }
