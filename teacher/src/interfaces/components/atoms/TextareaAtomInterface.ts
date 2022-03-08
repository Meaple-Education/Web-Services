export interface TextareaAtomPropInterface {
    name?: string;
    placeholder?: string;
    id?: string;
    initialValue: string;
    callback: (value: string) => void;
}
