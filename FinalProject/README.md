# Record Shoppe

## 📌 Overview

Welcome to **The Record Shoppe** This website is a database for adding and tracking records internally for the Record Shoppe. It is meant to be used exclusively by employees to help answer customer questions about inventory as quickly as possible.

## 🔶 Table of Contents

- Backend Files
- SQL Environment
- Logging In
- Welcome Page
- Addings Records
- Viewing Records
- DJ Rex Chatbot
- Metrics
- Logging Out

## 🔺 Backend Files

### Backend files include

### Database connection

- conn.php (main file for connecting to database)
- track_activity.php (for tracking login device and time in database)

### Security

- authentication.php (for credentials verification)
- auth_check.php (for authentication verification)
- 

### Other

- helper.php (for metrics page)
- metrics_index.php (for standalone metrics page)
- chatbox_index.php (for standalone chatbot page)
- bootstrap.php (for metrics testing)
- botMessaging.js (for chatbot functionality)
- css folder for all website styling


## 🔺 SQL Environment

### Below is the database schema for the PostgreSQL environment

  <img width="1800" alt="image" src="/FinalProject/public/images/databaseSchema.png" />


## 🔷 Logging In (login.php)

### On the Login page, you can enter a username and password that has been entered into the SQL database. There's also a "View Metrics" option, but that is explored later in this file.

  <img width="1800" alt="image" src="/FinalProject/public/images/loginPage.png" />


## 🔷 Welcome Page (welcome.php)

### Once you enter the correct credentials, you are taken to the main website page. From here, you can either add a record, view a record, or chat with DJ Rex.

  <img width="1800" alt="image" src="/FinalProject/public/images/welcomePage.png" />


## 🔷 Adding Records (addProduct.php)

### To add a record, fill in the fields. This sends the input into the SQL database and confirms whether or not the record was added successfully.

  <img width="1800" alt="image" src="/FinalProject/public/images/addProductPage.png" />


## 🔷 Viewing Records (viewProduct.php)

### This page allows you to view all records that have been added to the SQL database, whether it was done manually or through the addProduct.php page. There is a search bar, page navigation, and sorting feature to help users navigate intuitively.

  <img width="1800" alt="image" src="/FinalProject/public/images/viewProductPage.png" />


## 🔷 DJ Rex Chatbot

### DJ Rex is a chatbot with pre-determined questions and responses. The chatbot appears on the welcome page after 5 seconds of having the page loaded, and features a text input box and send button. The bot has a fallback feature for questions it is not familiar with.

  <img width="1800" alt="image" src="/FinalProject/public/images/chatbotFeature.png" />

### Questions the user can ask are listed below.

<img width="1800" alt="image" src="/FinalProject/public/images/questionsFeature.png" />


## 🔷 Metrics (metrics.php)

### The metrics page can be accessed from the login.php page. Clicking the "View Metrics" button will prompt the user with a password input. For simplicity and demo purposes, the password is "admin1". The page showcases site visits, unique visitors, dates and times of views, and the most visited pages.

  <img width="1800" alt="image" src="/FinalProject/public/images/metricsPage.png" />


## 🔷 Logging Out (logout.php)

### Selecting the red "Logout" button simply logs you out of the website, and returns the user to login.php.

## 🔗 Presentation Demo

[View Presentation](https://docs.google.com/presentation/d/1-NI0v68HZjgtM7wHq0fmlGElllwhMAGd8G5DKnhTmFk/edit?usp=sharing)

## 📄 License

This project is licensed under the MIT license. More license information can be found in the LICENSE file of the repository.
