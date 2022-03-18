import { ClassInfo } from "../../interfaces/class/ClassInterface";
import SchoolClassService from "../../services/SchoolClassService";
import { StoreState } from "../reducers";
import { ActionTypes } from "./types";

export interface SetSchoolIDAction {
    type: ActionTypes.setSchoolIDAction,
    payload: number
}

export interface SetSchoolIDState {
    (payload: number): SetSchoolIDAction
}

export const setSchoolID: SetSchoolIDState = (payload: number): SetSchoolIDAction => {
    return {
        type: ActionTypes.setSchoolIDAction,
        payload,
    };
};

export interface SetClassLoadingAction {
    type: ActionTypes.setClassLoadingAction,
    payload: boolean
}

export interface SetClassLoadingState {
    (payload: boolean): SetClassLoadingAction
}

export const setClassLoading: SetClassLoadingState = (payload: boolean): SetClassLoadingAction => {
    return {
        type: ActionTypes.setClassLoadingAction,
        payload,
    };
};

export interface LoadClassInfoAction {
    type: ActionTypes.loadClassInfoAction
    payload: {
        classLoading: boolean,
        classInfo: ClassInfo,
    }
}

export interface LoadClassInfo {
    (classID: number): any
}

export const loadClassInfo: LoadClassInfo = (classID: number) => async (dispatch: any, getState: any) => {
    const classService = new SchoolClassService();
    const response = await classService.fetchClass(getState().classState.schoolID, classID);

    dispatch({
        type: ActionTypes.loadClassInfoAction,
        payload: {
            classLoading: false,
            classInfo: response.data,
        }
    });
};
