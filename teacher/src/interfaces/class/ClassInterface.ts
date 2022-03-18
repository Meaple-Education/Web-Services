export interface ClassReducerInterface {
    schoolID: number;
    classLoading: boolean;
    classInfo: ClassInfo;
    // schedule: ClassSchedule
}

export interface ClassInfo {
    id: number;
    name: string;
    description: string;
    status: number;
}

export interface ClassSchedule { }


