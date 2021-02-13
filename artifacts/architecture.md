
Populate each section with information as it applies to your project. If a section does not apply, explain why. Include diagrams (or links to diagrams) in each section, as appropriate.  For example, sketches of the user interfaces along with an explanation of how the interface components will work; ERD diagrams of the database; rough class diagrams; context diagrams showing the system boundary; etc. Do _not_ link to your diagrams, embed them directly in this document by uploading the images to your GitHub and linking to them. Do _not_ leave any section blank.

# Program Organization

You should have your context, container, and component (c4model.com) diagrams in this section, along with a description and explanation of each diagram and a table that relates each block to one or more user stories. 

See Code Complete, Chapter 3 and https://c4model.com/

# Code Design UML Diagram
![Code Design UML Diagram](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/UMLDiagram.png)

The user in the class diagram should hold the users ID, the users Password, the users Email, and the users spotify account link. The user shall be able to modify there information. The users should be able to create private parties that have a party ID, party passcode, party members, and assign a party leader. In the party class the user can create, close, share the party information, and set the song to listen to. Users can vote on tracks that they like. The tracks are listed on a leaderboard. The comment class allows the users to comment on certain tracks that they have listened. In the comment class the user can write content, give a rating, list who made the comment, and show what song these comments were applied to.

# Data Design

If you are using a database, you should have a basic Entity Relationship Diagram (ERD) in this section. This diagram should describe the tables in your database and their relationship to one another (especially primary/foreign keys), including the columns within each table. 

See Code Complete, Chapter 3

# Business Rules

You should list the assumptions, rules, and guidelines from external sources that are impacting your program design. 

See Code Complete, Chapter 3

# User Interface Design

## Sign-In Page
![Sign-In Page](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/UiPages/signInPage.png)
This is the sign on page and the first page the user would see on visiting the site. It allows existing users to login. On login, it leads to the home page. The register button leads to the register page for new users. The forgot password link leads to the forgot password page.

## Forgot Password Page
![Forgot Password Page](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/UiPages/forgotPasswordPage.png)
This is the forgot password page for existing users who forgot their password. If the user exists, a forgot password link will be sent to their email, and the page will redirect to sign in.

## Register Page
![Register Page](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/UiPages/registerPage.png)
This page allows new users to register. On clicking register, if all fields are valid, an account will be created for the user and they will be redirected to the homepage. If the user already has an account, they can go back to the login page by clicking login.

## Home Page
![Home Page](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/UiPages/homePage.png)
This is the homepage after logging in as an existing user. This page includes the rankings of tracks by VibeCity users. Users can press the rating buttons to rate up and down the tracks. They can go to the party page to host and join parties through the party button. They can view their profile through the profile button.

## Profile Page
![Profile Page](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/UiPages/userProfilePage.png)
This is the user profile page. It has all the user's information. It also has the user's linked spotify account. This page can go to the home page through the home button. It can also go to the party page through the party button.

## Party Page
![Party Page](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/UiPages/partyPage.png)
The party page contains the song the party is listening to and a join code to join/invite to the party. The home page button goes to the home page. The profile button goes to the user's profile. Finally, the join code button allows for joining and inviting to a party through a popup.

## Join Code Popup
![Join Code Popup](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/UiPages/joinCodePage.png)
The join code popup can be used to enter or retrieve the party join code. The join code popup has an exit button to close the popup.

## UI Flow Chart
![UI Flow Chart](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/uiDiagram.png)
This is the flow of a normal user throughout the website pages.

## Page / User Story Table

| UI Screen         |     User Story ID   |
|-------------------|:-------------------:|
|    Login Page     |     001, 015        |
|  Forgot Password  |       003, 015      |
|  Register Page    |     000, 015        |
|     Home Page     | 008, 009, 010, 013  |
| User Profile Page |    002, 011, 012    |
|     Party Page    |    004, 006, 007    |
|    Join Code Page |      005, 014       |


# Resource Management

See Code Complete, Chapter 3

# Security

See Code Complete, Chapter 3

# Performance

See Code Complete, Chapter 3

# Scalability

See Code Complete, Chapter 3

# Interoperability

See Code Complete, Chapter 3

# Internationalization/Localization

See Code Complete, Chapter 3

# Input/Output

See Code Complete, Chapter 3

# Error Processing

See Code Complete, Chapter 3

# Fault Tolerance

See Code Complete, Chapter 3

# Architectural Feasibility

See Code Complete, Chapter 3

# Overengineering

See Code Complete, Chapter 3

# Build-vs-Buy Decisions

This section should list the third party libraries your system is using and describe what those libraries are being used for.

See Code Complete, Chapter 3

# Reuse

See Code Complete, Chapter 3

# Change Strategy

See Code Complete, Chapter 3