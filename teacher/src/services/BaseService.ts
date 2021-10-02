import axios from "axios";

export default class BaseService {
    getMethod(url: string) {
        return axios.get(url);
    }

    postMethod(url: string, data: FormData) {
        return axios.post(url, data);
    }

    deleteMethod(url: string) {
        return axios.delete(url);
    }
}
