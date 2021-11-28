import { combineReducers } from "redux";
import AuthInterface from "../../interfaces/AuthInterface";
import AuthReducer from "./auth_reducer";

export interface StoreState {
    authState: AuthInterface
}

const rootReducer = combineReducers<StoreState>({
    authState: AuthReducer
})

export default rootReducer;
