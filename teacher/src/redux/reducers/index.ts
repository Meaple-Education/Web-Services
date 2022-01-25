import { combineReducers } from "redux";
import AuthInterface from "../../interfaces/AuthInterface";
import { SchoolReducerInterface } from "../../interfaces/school/SchoolInterface";
import AuthReducer from "./auth_reducer";
import SchoolReducer from "./school_reducer";

export interface StoreState {
    authState: AuthInterface;
    schoolState: SchoolReducerInterface;
}

const rootReducer = combineReducers<StoreState>({
    authState: AuthReducer,
    schoolState: SchoolReducer,
})

export default rootReducer;
