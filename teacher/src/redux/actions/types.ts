import { AuthToggleValidatingStateAction } from ".";
import { AuthLoadProfileAction } from "./auth_action";

export enum ActionTypes {
    authLoadProfileAction,
    authToggleValidatingAction,
}

export type Action = AuthLoadProfileAction |
    AuthToggleValidatingStateAction
