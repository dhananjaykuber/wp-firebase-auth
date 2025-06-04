/**
 * Internal dependencies
 */
import { auth } from './config';
import { sendAndVerifyToken } from './helper';

/**
 * Firebase dependencies
 */
import { signInWithEmailAndPassword } from 'firebase/auth';

/**
 * Login with Email and Password function
 *
 * @param {string} email - The user's email address.
 * @param {string} password - The user's password.
 *
 * @returns {Promise<void>} A promise that resolves when the user is registered successfully.
 */
const loginWithEmailAndPassword = async (email, password) => {
    const loginForm = document.querySelector('#loginform');
    loginForm.classList.remove('shake');

    try {
        const userCredential = await signInWithEmailAndPassword(
            auth,
            email,
            password
        );
        const token = await userCredential.user.getIdToken();

        await sendAndVerifyToken(token);

        // Redirect to the WordPress admin dashboard after successful login
        window.location.href = '/wp-admin/';
    } catch (error) {
        loginForm.classList.add('shake');
    }
};

export { loginWithEmailAndPassword };
