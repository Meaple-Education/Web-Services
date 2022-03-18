import { SchoolItemInterface } from "../../interfaces/school/SchoolInterface";
import SchoolService from "../../services/SchoolService"
import { ActionTypes } from "./types";

export interface FetchSchoolAction {
    type: ActionTypes.fetchSchoolAction;
    payload: {
        loading: boolean;
        list: SchoolItemInterface[];
    }
}

export interface FetchSchool {
    (): any
}

export const fetchSchool: FetchSchool = () => async (dispatch: any) => {
    const schoolService = new SchoolService();

    const response = await schoolService.fetchSchools();

    dispatch({
        type: ActionTypes.fetchSchoolAction,
        payload: {
            loading: false,
            list: response.data
        }
    });
}


export interface AddSchoolAction {
    type: ActionTypes.addSchoolAction
    payload: SchoolItemInterface
}

export interface AddSchool {
    (payload: SchoolItemInterface): AddSchoolAction
}


export const addSchool: AddSchool = (payload: SchoolItemInterface): AddSchoolAction => {
    return {
        type: ActionTypes.addSchoolAction,
        payload,
    };
}
