import React from 'react';
import ReactDOM from 'react-dom';
import './scss/style.scss';
import App from './App';
import reportWebVitals from './reportWebVitals';
import axios from 'axios';
import { applyMiddleware, compose, createStore } from 'redux';
import { Provider } from 'react-redux';
import thunk from 'redux-thunk';
import rootReducer from './redux/reducers';
import { AuthEnum } from './enum/auth';

axios.defaults.baseURL = process.env.REACT_APP_API_URL;

const composeEnhancers =
    typeof window === 'object' &&
        (window as any).__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ ?
        (window as any).__REDUX_DEVTOOLS_EXTENSION_COMPOSE__({
        }) : compose;

const store = createStore(
    rootReducer,
    composeEnhancers(applyMiddleware(thunk)),
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
