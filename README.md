# Lisboa+Perto - Urban Management Platform 🏙️🇵🇹

## About the Project
**Lisboa+Perto** is a web-based application developed for the **Web Applications and Services** (Aplicações e Serviços na Web - ASW) course at the Faculty of Sciences, University of Lisbon (FCUL) during the 2023/2024 academic year.

The platform's primary goal is to bridge the gap between citizens and the **Lisbon City Hall (CML)**. It empowers citizens to report urban issues (such as potholes, broken streetlights, or waste accumulation) and provides CML staff with a back-office interface to manage, prioritize, and resolve these occurrences efficiently.

## Core Features

### 🌍 For Visitors & Citizens
* **Report Occurrences:** Registered users can report issues by selecting categories (e.g., Public Lighting), subcategories, providing a description, uploading photos, and pinning the exact location on a **Map**.
* **Status Tracking:** Monitor the lifecycle of reported issues (Registered -> Open -> Resolved).
* **Search:** Filter occurrences by street, locality, category, or status.
* **Communication:** Real-time **Chat** functionality to communicate directly with CML staff regarding specific issues.
* **Notifications:** Receive alerts when new occurrences are reported in the user's residential area.

### 🏛️ For CML Staff (Back-Office)
* **Management Dashboard:** View, filter, and change the status of reported occurrences.
* **Prioritization:** Assign urgency levels to critical issues.
* **Statistics:** Access charts and reports on resolution times and most problematic categories.
* **Citizen Interaction:** Send notifications and chat with citizens to request more info or provide feedback.

### 🔗 Integration (Web Services)
* **SOAP Web Service:** The project includes a SOAP API (`ListaOcorrencias`) designed for external repair entities (e.g., "REN-Reparações"). It allows third-party systems to fetch data about specific occurrences (location, photo, description) to execute repairs.

## Technical Architecture
The project was built in three stages, evolving from a static prototype to a fully dynamic web application.

* **Frontend:** HTML5, CSS3, JavaScript (AJAX for asynchronous updates).
* **Backend:** PHP.
* **Database:** SQL (Relational Database for users, occurrences, and logs).
* **Web Services:** NuSOAP (PHP) for the implementation of the SOAP Service.
* **Security:** Password encryption, input validation, and session management.

## Project Stages
1.  **Stage 1:** Interface design, visitor features, and database modeling.
2.  **Stage 2:** Authentication system (Login/Logout), state management, and back-office logic.
3.  **Stage 3:** Asynchronous features (AJAX Chat), Map integration, and SOAP Web Service implementation.

## How to Run
1.  **Environment:** Ensure you have a LAMP/WAMP/XAMPP stack installed (Apache, PHP, MySQL).
2.  **Database:** Import the `database.sql` file into your MySQL server.
3.  **Config:** Update the database connection settings in the PHP configuration file.
4.  **Run:** Place the project folder in your server's root directory (`htdocs` or `www`) and access it via the browser.



---
*This project was developed for educational purposes.*
