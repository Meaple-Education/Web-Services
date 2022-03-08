export interface InputAtomPropInterface {
    type: 'text' | 'email' | 'password' | 'number';
    name?: string;
    placeholder?: string;
    id?: string;
    initialValue: string;
    callback: (value: string) => void;
}
