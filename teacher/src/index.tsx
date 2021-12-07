import React from 'react';
import ReactDOM from 'react-dom';
import './scss/style.scss';
import App from './App';
import reportWebVitals from './reportWebVitals';
import axios from 'axios';
import { applyMiddleware, createStore } from 'redux';
import { Provider } from 'react-redux';
import thunk from 'redux-thunk';
import rootReducer from './redux/reducers';
import { AuthEnum } from './enum/auth';

axios.defaults.baseURL = process.env.REACT_APP_API_URL;


const store = createStore(
    rootReducer,
    applyMiddleware(thunk)
)

axios.defaults.headers['Authorization'] = 'Bearer ' + localStorage.getItem(AuthEnum.Token)
axios.defaults.headers[AuthEnum.SessionIdentifier] = localStorage.getItem(AuthEnum.SessionIdentifier)

ReactDOM.render(
    <Provider store={store}>
        <React.StrictMode>
            <App />
        </React.StrictMode>
    </Provider>,
    document.getElementById('root')
);

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals();
