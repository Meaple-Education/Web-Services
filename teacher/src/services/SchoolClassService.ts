import { FunctionResponse } from "../interfaces/ServiceInterface";
import { BuildPath } from "../routes/PageEndPoint";
import { CreateClassURL, FetchClassesURL, FetchClassURL } from "./ApiEndPoints";
import BaseService from "./BaseService";

export default class SchoolClassService extends BaseService {
    async fetchClasses(schoolID: number | string, page: number = 1) {
        let response: FunctionResponse = {
            status: true,
            msg: 'Success',
            data: null
        }

        await this.getMethod(
            BuildPath(FetchClassesURL, { schoolID }),
        ).then((res) => {
            response.data = res.data.data.list;
        }).catch((err) => {
            if (err.response) {
                response.status = false;
                response.msg = err.response.data.msg || 'Failed to fetch class!';
            }
        });

        return response;
    }

    async fetchClass(schoolID: number | string, classID: number | string) {
        let response: FunctionResponse = {
            status: true,
            msg: 'Success',
            data: null
        }

        await this.getMethod(
            BuildPath(FetchClassURL, { schoolID, classID }),
        ).then((res) => {
            response.data = res.data.data.info;
        }).catch((err) => {
            if (err.response) {
                response.status = false;
                response.msg = err.response.data.msg || 'Failed to fetch class!';
            }
        });

        return response;
    }

    async createClass(schoolID: number | string, name: string, description: string) {
        let response: FunctionResponse = {
            status: true,
            msg: 'Success',
            data: null
        };

        const formData = new FormData();
        formData.append('name', name);
        formData.append('description', description);

        await this.postMethod(
            BuildPath(CreateClassURL, { schoolID }),
            formData,
        ).then((res) => {
            response.data = res.data.data;
        }).catch((err) => {
            if (err.response) {
                response.status = false;
                response.msg = err.response.data.msg || 'Failed to create class!';
            }
        });

        return response;
    }

    async updateClass(schoolID: number | string) {

    }

    async updateClassStatus(schoolID: number | string) {

    }

    async deleteClass(schoolID: number | string) {

    }
}
