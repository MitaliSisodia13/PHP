# User Registration and Application System

## Overview

This project implements a user registration and application submission system using PHP and JSON for data storage. It allows users to create an account, fill out their personal information, educational background, work experience, and review their application before submission.

## Files and Their Functions


### 1. `register.php`

- **Purpose**: Handles user registration.
- **Key Features**:
  - Validates user input for username, email, and password.
  - Hashes the password for secure storage.
  - Saves user data in `users.json`.
  - Redirects to the login page upon successful registration.

### 2. `login.php`

- **Purpose**: Facilitates user login.
- **Key Features**:
  - Validates user credentials against stored data in `users.json`.
  - Starts a session upon successful login.

### 3. `personal_data.php`

- **Purpose**: Collects personal information from the user.
- **Key Features**:
  - Validates and sanitizes input data.
  - Stores user data in session variables for later use.
  - Provides a "Next" button to proceed to the next step.

### 4. `background_data.php`

- **Purpose**: Gathers educational background information.
- **Key Features**:
  - Validates and sanitizes input data.
  - Stores educational details in session variables.
  - Provides navigation to previous and next steps.

### 5. `experience.php`

- **Purpose**: Collects work experience details from the user.
- **Key Features**:
  - Validates input for job title, company name, years of experience, and responsibilities.
  - Stores experience details in session variables.
  - Provides navigation to previous and next steps.

### 6. `review.php`

- **Purpose**: Allows users to review their application before submission.
- **Key Features**:
  - Checks if all required session variables are set.
  - Displays collected information with edit links for each section.
  - Compiles application data for submission.
  - Clears session data and logs the user out after successful submission.
