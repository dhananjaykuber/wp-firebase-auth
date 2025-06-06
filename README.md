## Firebase Authentication

A WordPress plugin that enables users to log into WordPress using their Firebase Authentication credentials (email and password). This plugin seamlessly integrates Firebase Authentication with WordPress

### Features

-   **Firebase Integration**: Direct authentication using Firebase Auth
-   **Automatic User Creation**: Creates WordPress users automatically for new Firebase users
-   **Login Form Integration**: Adds Firebase login button to WordPress login page
-   **Admin Settings Page**: Easy configuration through WordPress admin
-   **Role Management**: Automatically assigns subscriber role to new users

### Installation

-   Download the plugin files
-   Upload the firebase-authentication folder to `/wp-content/plugins/`
-   Navigate to the plugin directory and run:

```bash
composer install
```

-   Activate the plugin through the 'Plugins' menu in WordPress
-   Configure the plugin settings under `Settings --> Firebase Authentication`

### Required Configuration Fields

```
API Key: YOUR_API_KEY
Auth Domain: YOUR_AUTH_DOMAIN
Project ID: YOUR_PROJECT_ID
Storage Bucket: YOUR_STORAGE_BUCKET
Messaging Sender ID: YOUR_MESSAGING_SENDER_ID
App ID: YOUR_APP_ID
```

### Screenshots

![Screenshot 2025-06-06 at 8 08 53 PM](https://github.com/user-attachments/assets/db61abe0-6585-4eb5-9189-02ee49f2c6a7)
![Screenshot 2025-06-06 at 8 21 51 PM](https://github.com/user-attachments/assets/0d6007d7-fe5b-4aba-b9f1-567932c9f239)

Made by [@dhananjaykuber](https://github.com/dhananjaykuber/)
