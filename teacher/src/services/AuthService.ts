import { FunctionResponse } from "../interfaces/ServiceInterface";
import { SignInURL, SignUpURL, VerifyAccountURL } from "./ApiEndPoints";
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
            console.log('login res', res);
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
}
