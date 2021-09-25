import axios from "axios";

export default class BaseService {
    constructor() {
        console.log('sdasd', process.env.REACT_APP_API_URL);
        axios.defaults.baseURL = process.env.REACT_APP_API_URL;
    }

    getMethod(url: string) {
        return axios.get(url);
    }

    postMethod(url: string, data: FormData) {
        return axios({ url: url, data: data, method: 'post' });
    }

    deleteMethod(url: string) {
        return axios.delete(url);
    }
}
