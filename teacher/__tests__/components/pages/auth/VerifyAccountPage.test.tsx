
import axios, { AxiosError, AxiosResponse } from 'axios';
import ReactDOM from 'react-dom';
import { act } from 'react-dom/test-utils';
import { BrowserRouter } from 'react-router-dom';
import VerifyAccountPage from '../../../../src/components/pages/auth/VerifyAccountPage';

let container: ReactDOM.Container | null;
let routeComponentPropsMock: any;

jest.mock('axios');

beforeEach(() => {
    container = document.createElement('div');
    document.body.appendChild(container);
    routeComponentPropsMock = {
        history: {} as any,
        location: {
            search: "",
        } as any,
        match: {} as any,
    };
});

afterEach(() => {
    if (container) {
        document.body.removeChild(container);
    }
    container = null;
});

describe("Verify Account page Test", () => {
    it('Verify Account page should render', async () => {
        if (container) {
            act(() => { ReactDOM.render(<VerifyAccountPage {...routeComponentPropsMock} />, container); });
            expect(container.querySelectorAll('[data-test="verifyAccountPage"]').length).toBe(1);
        }
    })

    it('Should have success axios verification', async () => {
        routeComponentPropsMock.location.search = "?code=verificationCode&email=test@meaple-education.com";
        if (container) {
            const mockedAxios = axios as jest.Mocked<typeof axios>;

            mockedAxios.post.mockResolvedValue({
                data: {
                    status: true,
                    code: 200,
                    data: {},
                    msg: 'Success',
                },
                status: 200,
                statusText: 'OK',
                headers: {},
                config: {},
            } as AxiosResponse);

            act(() => {
                ReactDOM.render(<BrowserRouter>
                    <VerifyAccountPage {...routeComponentPropsMock} />
                </BrowserRouter>, container);
            });

            await new Promise(resolve => { setTimeout(() => resolve(true), 50); });
            expect(container.querySelectorAll('[data-test="verificationSuccessSection"]').length).toBe(1);
            expect(container.querySelector('[data-test="verificationSuccessMessageSection"]')?.innerHTML).toBe('Validation complete');
        }
    })

    it('Should have failed axios verification', async () => {
        routeComponentPropsMock.location.search = "?code=verificationCode&email=test@meaple-education.com";
        if (container) {
            const mockedAxios = axios as jest.Mocked<typeof axios>;

            mockedAxios.post.mockRejectedValueOnce({
                response: {
                    data: {
                        status: false,
                        code: 422,
                        data: {},
                        msg: 'Custom failed error message',
                    },
                    status: 422,
                    statusText: 'Unprocessable Entity',
                    headers: {},
                    config: {},
                },
            } as AxiosError);

            act(() => {
                ReactDOM.render(<BrowserRouter>
                    <VerifyAccountPage {...routeComponentPropsMock} />
                </BrowserRouter>, container);
            });

            await new Promise(resolve => { setTimeout(() => resolve(true), 50); });
            expect(container.querySelectorAll('[data-test="verificationFailedSection"]').length).toBe(1);
            expect(container.querySelector('[data-test="verificationFailedSection"]')?.innerHTML).toBe('Custom failed error message');
        }
    })

    it('Should have failed axios verification with empty error message', async () => {
        routeComponentPropsMock.location.search = "?code=verificationCode&email=test@meaple-education.com";
        if (container) {
            const mockedAxios = axios as jest.Mocked<typeof axios>;

            mockedAxios.post.mockRejectedValueOnce({
                response: {
                    data: {
                        status: false,
                        code: 422,
                        data: {},
                        msg: '',
                    },
                    status: 422,
                    statusText: 'Unprocessable Entity',
                    headers: {},
                    config: {},
                },
            } as AxiosError);

            act(() => {
                ReactDOM.render(<BrowserRouter>
                    <VerifyAccountPage {...routeComponentPropsMock} />
                </BrowserRouter>, container);
            });

            await new Promise(resolve => { setTimeout(() => resolve(true), 50); });
            expect(container.querySelectorAll('[data-test="verificationFailedSection"]').length).toBe(1);
            expect(container.querySelector('[data-test="verificationFailedSection"]')?.innerHTML).toBe('Failed to verify an account!');
        }
    })
})

export { }
