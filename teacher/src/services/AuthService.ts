import { AuthEnum } from "../enum/auth";
import { FunctionResponse } from "../interfaces/ServiceInterface";
import { ProfileURL, SignInURL, SignUpURL, VerifyAccountURL, VerifyPasswordURL } from "./ApiEndPoints";
import BaseService from "./BaseService";

export default class AuthService extends BaseService {
    async signup(
        email: string,
        name: string,
        password: string,
    ): Promise<FunctionResponse> {
        let response: FunctionResponse = {
            status: true,
            msg: 'Success',
            data: null,
        };

        const formData = new FormData();
        formData.append('email', email);
        formData.append('name', name);
        formData.append('password', password);

        await this.postMethod(
            SignUpURL,
            formData,
        ).then((res) => {
            console.log('reg', res);
        }).catch((err) => {
            if (err.response) {
                response.status = false;
                response.msg = err.response.data.msg || 'Registration failed!';
            }
        })

        return response;
    }

    async signin(email: string, otp: string): Promise<FunctionResponse> {
        let response: FunctionResponse = {
            status: true,
            msg: 'Success',
            data: null,
        };

        const formData = new FormData();
        formData.append('email', email);
        formData.append('otp', otp);

        await this.postMethod(
            SignInURL,
            formData,
        ).then((res) => {
            localStorage.setItem(AuthEnum.Token, res.data.data.token);
            localStorage.setItem(AuthEnum.SessionIdentifier, res.data.data.sessionIdentifier);
        }).catch((err) => {
            if (err.response) {
                response.status = false;
                response.msg = err.response.data.msg || 'Login failed!';
            }
        })

        return response;
    }

    async verifyAccount(
        code: string,
        email: string,
    ): Promise<FunctionResponse> {
        let response: FunctionResponse = {
            status: true,
            msg: 'Success',
            data: null,
        };

        const formData = new FormData();
        formData.append('code', code);
        formData.append('email', email);

        await this.postMethod(
            VerifyAccountURL,
            formData,
        ).then((res) => {

        }).catch((err) => {
            if (err.response) {
                response.status = false;
                response.msg = err.response.data.msg || 'Failed to verify an account!';
            }

        });

        return response;
    }

    async loadProfile(): Promise<FunctionResponse> {
        let response: FunctionResponse = {
            status: true,
            msg: 'Success',
            data: {
                profile: {},
                isLoggin: false,
                verifyPassword: false,
            },
        };

        await this.getMethod(
            ProfileURL
        ).then((res) => {
            console.log("profile resulut", res);
            response.data.isLoggin = true;
        }).catch((err) => {
            response.status = false;

            if (err.response.status === 403 && err.response.data.data.verificationRequired) {
                response.data.isLoggin = true;
                response.data.verifyPassword = true;
            }

            if (err.response.status === 401) {
                localStorage.removeItem(AuthEnum.Token);
                localStorage.removeItem(AuthEnum.SessionIdentifier);
            }
        });

        return response;
    }

    async verifyPassword(password: string): Promise<FunctionResponse> {
        let response: FunctionResponse = {
            status: true,
            msg: 'Success',
            data: {
                logout: false
            },
        }

        const formData = new FormData();
        formData.append('password', password);

        await this.postMethod(
            VerifyPasswordURL,
            formData,
        ).then((res) => {

        }).catch((err) => {
            response.status = false;
            response.msg = err.response.data.msg || 'Failed to verify password';
            if (err.response.data.data.isExpire) {
                response.data.logout = err.response.data.data.isExpire;
            }
        });

        return response;
    }
}
