import AuthInterface from "../../interfaces/AuthInterface";
import { Action, ActionTypes } from "../actions/types";

let initialValue: AuthInterface = {
    validating: true,
    isLoggin: false,
    verifyPassword: false,
    profile: {},
}

const AuthReducer = (state: AuthInterface = initialValue, action: Action) => {
    let newState = state;

    switch (action.type) {
        case ActionTypes.authLoadProfileAction:
            newState = { ...newState, ...action.payload }
            break;

        case ActionTypes.authToggleValidatingAction:
            newState.validating = action.payload;
            break;
    }

    state = { ...state, ...newState }

    return state;
}

export default AuthReducer;
