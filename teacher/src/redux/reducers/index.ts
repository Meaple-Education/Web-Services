import { combineReducers } from "redux";
import AuthInterface from "../../interfaces/AuthInterface";
import { ClassReducerInterface } from "../../interfaces/class/ClassInterface";
import { SchoolReducerInterface } from "../../interfaces/school/SchoolInterface";
import AuthReducer from "./auth_reducer";
import ClassReducer from "./class_reducer";
import SchoolReducer from "./school_reducer";

export interface StoreState {
    authState: AuthInterface;
    schoolState: SchoolReducerInterface;
    classState: ClassReducerInterface;
}

const rootReducer = combineReducers<StoreState>({
    authState: AuthReducer,
    schoolState: SchoolReducer,
    classState: ClassReducer,
})

export default rootReducer;
