import { ClassReducerInterface } from "../../interfaces/class/ClassInterface";
import { Action, ActionTypes } from "../actions/types";

let initialValue: ClassReducerInterface = {
    schoolID: 0,
    classLoading: false,
    classInfo: {
        id: 0,
        name: '',
        description: '',
        status: 1,
    },
}

const ClassReducer = (state: ClassReducerInterface = initialValue, action: Action) => {
    let newState = state;

    switch (action.type) {
        case ActionTypes.setSchoolIDAction:
            newState.schoolID = action.payload;
            break;
        case ActionTypes.setClassLoadingAction:
            newState.classLoading = action.payload;
            break;
        case ActionTypes.loadClassInfoAction:
            newState = { ...newState, ...action.payload };
            break;
    }

    state = { ...state, ...newState }

    return state;
}

export default ClassReducer;
