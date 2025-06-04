/**
 * Internal dependencies
 */
import {
    loginWithEmailAndPassword,
    loginWithGoogle,
} from './firebase/services';

/**
 * Styles
 */
import './login.scss';

const loginForm = document.querySelector('#loginform');
const emailLoginButton = document.querySelector('#firebase-signin-btn');

// Variable to track if the login is via Firebase
let isFirebaseLogin = false;

emailLoginButton?.addEventListener('click', (e) => {
    e.preventDefault();

    isFirebaseLogin = true;

    const email = document.querySelector('#user_login').value;
    const password = document.querySelector('#user_pass').value;

    loginWithEmailAndPassword(email, password);
});

loginForm?.addEventListener('submit', (e) => {
    if (isFirebaseLogin) {
        e.preventDefault();
        isFirebaseLogin = false;
    }
});
