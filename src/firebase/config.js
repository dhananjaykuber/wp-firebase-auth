/**
 * Firebase dependencies
 */
import { initializeApp } from 'firebase/app';
import { getAuth } from 'firebase/auth';

// Firebase configuration
const firebaseConfig = {
    apiKey: firebaseAuthSettings.apiKey,
    authDomain: firebaseAuthSettings.authDomain,
    projectId: firebaseAuthSettings.projectId,
    storageBucket: firebaseAuthSettings.storageBucket,
    messagingSenderId: firebaseAuthSettings.messagingSenderId,
    appId: firebaseAuthSettings.appId,
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);

// Initialize Firebase Authentication
const auth = getAuth(app);

export { auth };
