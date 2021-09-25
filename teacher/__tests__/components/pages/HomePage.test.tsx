
import ReactDOM from 'react-dom';
import ReactTestUtils, { act } from 'react-dom/test-utils';
import HomePage from '../../../src/components/pages/HomePage';

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

describe("Home page Test", () => {
    it('home page should render', () => {
        if (container) {
            act(() => { ReactDOM.render(<HomePage />, container); });
            expect(container.querySelector('[data-test="homePage"]')?.innerHTML).toBe('HomePage TO BE IMPLEMENTED');
        }
    })
})

export { }
