import { AddSchoolAction, AuthToggleValidatingStateAction } from ".";
import { AuthLoadProfileAction } from "./auth_action";
import { FetchSchoolAction } from "./school_action";

export enum ActionTypes {
    authLoadProfileAction,
    authToggleValidatingAction,
    fetchSchoolAction,
    addSchoolAction
}

export type Action = AuthLoadProfileAction |
    AuthToggleValidatingStateAction |
    FetchSchoolAction |
    AddSchoolAction
