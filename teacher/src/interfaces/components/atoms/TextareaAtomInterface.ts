export interface TextareaAtomPropInterface {
    name?: string;
    placeholder?: string;
    id?: string;
    initialValue: string;
    disabled?: boolean;
    callback: (value: string) => void;
}
