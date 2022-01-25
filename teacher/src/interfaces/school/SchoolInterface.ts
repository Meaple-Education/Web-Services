export interface SchoolInterface {
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
    list: SchoolInterface[],
    loading: boolean;
}
