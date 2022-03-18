import { SchoolReducerInterface } from "../../interfaces/school/SchoolInterface";
import { Action, ActionTypes } from "../actions/types";

let initialValue: SchoolReducerInterface = {
    list: [],
    loading: false,
}

const SchoolReducer = (state: SchoolReducerInterface = initialValue, action: Action) => {
    let newState = state;

    switch (action.type) {
        case ActionTypes.fetchSchoolAction:
            newState = { ...newState, ...action.payload };
            break;

        case ActionTypes.addSchoolAction:
            newState.list.push(action.payload);
            break;
    }

    state = { ...state, ...newState }

    return state;
}

export default SchoolReducer;
