import { AddSchoolAction, AuthToggleValidatingStateAction, LoadClassInfoAction, SetSchoolIDAction, SetClassLoadingAction } from ".";
import { AuthLoadProfileAction } from "./auth_action";
import { FetchSchoolAction } from "./school_action";

export enum ActionTypes {
    authLoadProfileAction,
    authToggleValidatingAction,
    fetchSchoolAction,
    addSchoolAction,
    setSchoolIDAction,
    loadClassInfoAction,
    setClassLoadingAction,
}

export type Action = AuthLoadProfileAction |
    AuthToggleValidatingStateAction |
    FetchSchoolAction |
    AddSchoolAction |
    SetSchoolIDAction |
    LoadClassInfoAction |
    SetClassLoadingAction
