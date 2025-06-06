/**
 * Sends a token to the server for verification.
 *
 * @param {*} token - The token to be sent for verification.
 *
 * @returns {Promise<void>} A promise that resolves when the token is successfully verified.
 */
const sendAndVerifyToken = async (token) => {
    const res = await fetch('/wp-json/firebase-auth/v1/verify-token', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ token }),
    });

    if (!res.ok) {
        throw new Error('Failed to verify token');
    }
};

export { sendAndVerifyToken };
