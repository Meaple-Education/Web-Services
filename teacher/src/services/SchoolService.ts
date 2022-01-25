import { FunctionResponse } from "../interfaces/ServiceInterface";
import { CreateSchoolURL, FetchSchoolURL } from "./ApiEndPoints";
import BaseService from "./BaseService";

class SchoolService extends BaseService {
    async createSchool(
        name: string,
        address: string = '',
        description: string = '',
        phone_numbers: string[] = [],
    ): Promise<FunctionResponse> {
        let response: FunctionResponse = {
            status: true,
            msg: 'Success',
            data: null,
        };

        const formData = new FormData();
        formData.append('name', name);
        formData.append('description', description);
        formData.append('address', address);
        formData.append('phone_numbers', JSON.stringify(phone_numbers));

        await this.postMethod(
            CreateSchoolURL,
            formData,
        ).then((res) => {
            response.data = res.data.data;
        }).catch((err) => {
            if (err.response) {
                response.status = false;
                response.msg = err.response.data.msg || 'Failed to create school!';
            }
        });

        return response;
    }

    async fetchSchools(): Promise<FunctionResponse> {
        let response: FunctionResponse = {
            status: true,
            msg: 'Success',
            data: null
        };

        await this.getMethod(
            FetchSchoolURL,
        ).then(res => {
            response.data = res.data.data.list
        }).catch(err => {
            if (err.response) {
                response.status = false;
                response.msg = err.response.data.msg || 'Failed to fetch school list!';
            }
        })

        return response;
    }
}

export default SchoolService;
