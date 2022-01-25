import React from 'react';

interface IProps {
    closeConfirmation?: boolean;
    processing?: boolean;
    closeCallback?: Function;
    // poupType: number;
}

interface IStates { }

class PopupAtom extends React.Component<IProps, IStates> {
    constructor(props: IProps) {
        super(props);
    }

    mounted() {
        if (this.props.closeConfirmation) {
            window.addEventListener('beforeunload', (e: any) => {
                e.preventDefault();
                e.returnValue = "";
                return "";
            });
            window.addEventListener('unload', this.closeConfirmation);
        }
    }

    closePopup = () => {
        if (this.props.closeConfirmation) {
            this.closeConfirmation(null);
        } else {
            if (this.props.closeCallback) {
                this.props.closeCallback();
            }
        }
    }

    closeConfirmation = (e: any) => {
        if (e) {

        }
        let closeConfirmed = window.confirm("Close confirmation");

        if (closeConfirmed && this.props.closeCallback) {
            this.props.closeCallback();
            return true;
        }

        return false;
    }

    render(): React.ReactNode {
        return <div className="popup-atom">
            {this.props.children}
            <button type="button" onClick={() => this.closePopup()}>Close</button>
        </div>
    }
}

export default PopupAtom;
