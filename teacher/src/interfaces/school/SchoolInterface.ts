export interface SchoolItemInterface {
    id: number;
    name: string;
    logo: string;
    status: string;
    description: string;
    address: string;
    phone_numbers: string[];
    user_id: string;
}

export interface SchoolReducerInterface {
    list: SchoolItemInterface[],
    loading: boolean;
}
