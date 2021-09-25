import { FunctionResponse } from "../interfaces/ServiceInterface";
import { VerifyAccountURL } from "./ApiEndPoints";
import BaseService from "./BaseService";

export default class AuthService extends BaseService {
    async signup(): Promise<FunctionResponse> {
        let response: FunctionResponse = {
            status: true,
            msg: 'Success',
            data: null,
        };

        return response;
    }

    async signin(): Promise<FunctionResponse> {
        let response: FunctionResponse = {
            status: true,
            msg: 'Success',
            data: null,
        };

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
