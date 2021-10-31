
import ReactDOM from 'react-dom';
import ReactTestUtils, { act } from 'react-dom/test-utils';
import InputAtom from '../../../src/components/atoms/InputAtom';

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

describe("Input atom Test", () => {
    it('Input atom should render', () => {
        if (container) {
            act(() => { ReactDOM.render(<InputAtom />, container); });
            expect(container.querySelectorAll('input').length).toBe(1);
        }
    })
})

export { }
