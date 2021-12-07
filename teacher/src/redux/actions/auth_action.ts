import axios from "axios";
import AuthService from "../../services/AuthService";
import { ActionTypes } from "./types";

export interface AuthLoadProfileAction {
    type: ActionTypes.authLoadProfileAction
    payload: {
        validating: boolean,
        profile: any,
        isLoggin: boolean,
    }
}

export interface AuthLoadProfile {
    (): any
}

export const authLoadProfile: AuthLoadProfile = () => async (dispatch: any, getState: any) => {
    const authService = new AuthService();
    const response = await authService.loadProfile();
    console.log('resposne', response);
    dispatch({
        type: ActionTypes.authLoadProfileAction,
        payload: {
            validating: false,
            ...response.data,
        }
    });
};


export interface AuthToggleValidatingStateAction {
    type: ActionTypes.authToggleValidatingAction
    payload: boolean
}

export interface AuthToggleValidatingState {
    (payload: boolean): AuthToggleValidatingStateAction
}

export const authToggleValidatingState: AuthToggleValidatingState = (payload: boolean): AuthToggleValidatingStateAction => {
    return {
        type: ActionTypes.authToggleValidatingAction,
        payload,
    };
}
