# Program Organization

## System Context Diagram

![System Context Diagram](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/contextDiagram.png)

This diagram shows the VibeCity System, users, and the interactions between them. At a high level, users interact with the
VibeCity system to form parties of users that listen to music together and to rate songs. The VibeCity system is where all
of our software is maintained, such as our application, the backend behind parties and ratings, and the server we use to
transfer all the data to/from the application. Our database system includes the data needed for our app to have users,
parties, and track ratings.

|     Context       |     User Story ID         |
|-------------------|:-------------------------:|
|   VibeCity User   |      000 - 001, 002, 015  |
|  VibeCity System  |      000 - 029            |
|  Database System  |      000-010, 013-023, 024-026 |

## Container Diagram

![Container Diagram](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/containerDiagram.png)

This diagram shows the VibeCity System in more depth, showing the system and its inner containers. The system hosts our application and
our backend which provides the capabilities for parties, users, rating, and comment systems. The system also communicated with our database
to get all of the attributes needed for parties, users, ratings, etc; the spotify api, which gives users spotify account info and music, and
the amazon email server, which is used to send emails like reset password.

|     Container               |     User Story ID        |
|-----------------------------|:------------------------:|
|   VibeCity User             |      000 - 026           |
|   Application               | 004, 005 - 011, 013-029  |
|    VibeCity API Application | 000 - 003, 008 - 029     |
| Email System                |  003,                    |
| Database System             |  000-010, 013-023, 024, 026 |
| Spotify System              |  004, 007, 013, 019, 025, 029   | 

## Component Diagram

![Component Diagram](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/compDiagram.png)

Our system component diagram splits up the VibeCity system into vital components. First there is the application layer, which lalows users to interact with our party and rating systems, hosted on our backend server. The application will communicate with the server through API calls and it interacts with controllers for each task needed. For example, it interacts with the user controlled to achieve registration and login for users, while the party controller achieves placing a group of users together to listen to music. The respective models that the controllers access will give any information needed to process the request. The models communicate with the database system or expernel APIs to retrieve information necessary, such as a spotify song or user password. The external APIs for this system are an email server, AWS SES, our database system (MySQL), and the Spotify API.


|          Context          |     User Story ID        |
|---------------------------|:------------------------:|
|    Application            |      000 - 029           |
| User Controller           |  000, 001, 002, 015      |
| Profile Controller        |     002, 011, 012, 018   |
| Leaderboard Controller    |  008, 009, 010, 013, 023, 024, 026 |
| Spotify Controller        |  004, 007, 013           |
| Party Controller          |  004, 006, 007, 019, 021, 022, 025, 027-028 |
| Connected Account Model   |  025, 029                 |
| Email Model               |  003, 015, 17            |
| User Model                |  000, 001, 002           |
| Track Model               |  008, 009, 010           |
| Rating Model              |  013                     |
| Comment Model             |  010, 026                |
| Party Model               |  004, 005, 006, 007, 014 |
| Join Code Model           |  005                     |
| Email System              |  003, 017                |
| Database System           |  000-010, 013-023, 024-026 |
| Spotify System (API)      |  004, 007, 013, 025, 029           | 


# Code Design UML Diagram

## Class Diagram

![Code Design UML Diagram](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/ClassDiagram1.png)

The user in the class diagram should hold the users ID, the users Password, the users Email, the users two factor authentication, and the users spotify
account link. The user shall be able to modify their information. The users should be able to create private parties
that have a party ID, party join code, party members, the state of the party being open or closed, and assign a party leader. In the party class the user can create,
close, share the party information, and set the song to listen to. The spotify controller controls the spotify actions
for these parties. Users can vote on tracks that they like. The tracks
are listed on a leaderboard. The comment class allows the users to comment on certain tracks that they have listened to. In
the comment class the user can write content, give a rating, list who made the comment, and show what song these
comments were applied to.

| Classes                   |      User Story ID       |
|---------------------------|:------------------------:|
| User Controller           |  000, 001, 002, 015      |
| Profile Controller        |     002, 011, 012, 018   |
| Leaderboard Controller    |  008, 009, 010, 013, 023, 024, 026 |
| Spotify Controller        |  004, 007, 013           |
| Party Controller          |  004, 006, 007, 019, 021, 022, 025, 027-028 |
| Connected Account Model   |  025, 029                 |
| Email Model               |  003, 015, 17            |
| User Model                |  000, 001, 002           |
| Track Model               |  008, 009, 010           |
| Rating Model              |  013                     |
| Comment Model             |  010, 026                |
| Party Model               |  004, 005, 006, 007, 014 |
| Join Code Model           |  005                     |

## Activity Diagram

![Activity Diagram](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/activitydiagramdone.png)

This diagram shows the flow of activities for a given user in the system. It shows the user login and authentication
section, then all the actions the user can perform once logged into the site. These include viewing the party page,
party actions, viewing the profile page, profile actions, and viewing the leaderboard page, as well as leaderboard
actions. Finally, the system ends with the user logging out.

# Data Design

![Database ER Diagram](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/DatabaseDiagram.png)

The user should be able to join a party and add comments to tracks. Parties should be able to listen to tracks. Tracks
should be able to have comments on them. The Party should leader should be able to kick people from the party.
The party leader is able to select which strong can be played. 

# Business Rules

In the present, the architecture does not depend on any business logic, however in the future, we will ensure GDPR, and
other compliance of the like which will need to be taken into consideration when designing the architecture to ensure
proper compliance to anything we deem necessary.

# User Interface Design

## Individual Pages
### Sign-In Page

![Sign-In Page](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/UiPages/userLoginPage.png)

This is the sign on page and the first page the user would see on visiting the site. It allows existing users to login.
On login, it leads to the home page if the user does not have TFA.
If the user does have TFA, login leads to the TFA login screen. The user can also login with spotify.
The forgot password link leads to the forgot password page.

### TFA Login Page

![TFA Login Page](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/UiPages/tfaLoginPage.png)

This is the TFA login page. This is reached if a user has TFA and tries to sign in.
When the user enters the TFA code from their device or their recovery code and logs in, they are redirected to the home page.

### Forgot Password Page

![Forgot Password Page](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/UiPages/forgotPasswordPage.png)

This is the forgot password page for existing users who forgot their password. If the user exists, a forgot password
link will be sent to their email, and the page will redirect to reset password.

### Reset Password Page

![Reset Password Page](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/UiPages/resetPasswordPage.png)

This is the reset password page for existing users to reset their password. If a user recieves a reset password email, then
they are redirected here. They are able to enter a valid password and their email, and are then redirected to login with
that new password.

### Register Page

![Register Page](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/UiPages/registerPage.png)

This page allows new users to register. On clicking register, if all fields are valid, an account will be created for
the user and they will be redirected to the homepage. If the user already has an account, they can go back to the login
page by clicking "already registered". The user can also register with spotify.

### Home Page

![Home Page](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/UiPages/mainDashboard.png)

This is the homepage after logging in as an existing user. This page includes the rankings of tracks by VibeCity users.
Users are be able to press the rating buttons to rate up the tracks. They can also comment by pressing the comment
button to load a comment area for that track, which then shows all the past comments and allows for leading / deleting
comments for the current user.  They can go to the party page to host and join
parties through the party button. They can view their profile through the profile button. They can also view the spotify
leaderboard through the Spotify Leaderboard link.


### Spotify Leaderboard
![Spotify Leaderboard](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/UiPages/spotifyLeaderboardPage.png)

This is the spotify leaderboard, which contains a live list of the top 50 tracks on spotify today. Users can go to the 
party page to host and join parties through the party button. They can view their profile through the profile button. 
They can also view the VibeCity home page leaderboard through the Leaderboard link. 

### Profile Page

![Profile Page](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/UiPages/profilePage.png)

This is the user profile page. It has all the user's information. The user can update their name and email.
The user can also update their password. The user is able to sign up to TFA through the TFA area, which opens
a TFA confirmation pop. On signing up, they are given a QR code to enable tfa on their own device. The user is
able to logout of other browser sessions through the browser session area. This opens a popup to confirm.
The user is able to permanently delete their account through the delete account button, which opens a confirmation
popup. Finally the user is able to link spotify to their account through the connected accounts area, which redirects
to spotify.


### TFA Confirmation Popup

![TFA Confirmation Popup](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/UiPages/TFAConfirmPopup.png)

The TFA confirmation popup appears when a user enabled TFA through their profile. It asks the user for their password.
If they press nevermind, they go back to the profile and do not enable TFA. If they enter their password and confirm
they are given a QR code and taken back to their profile.


### Logout Browser Sessions Popup
![Logout Browser Sessions Popup](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/UiPages/logoutSessionsConfirmPopup.png)

The logout browser session popup appears when a user tries to logout their other browser sessiosn through their profile.
It asks the user for their password. If they enter it and press nevermind, they go back to the profile and do not logout
other sessions. If they enter their password and press logout other sessions, they logout other sessions can go back
to the profile

### Delete Account Popup

![Delete Account Popup](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/UiPages/deleteAccountConfirmPopup.png)

The delete account popup appears when a user tries to delete their account on their profile. It asks the user for their password.
If they enter it and press nevermind, they go back to the profile and do not delete their account. Alternatively, if they
enter the password and press delete account, then they are rerouted to the register screen and their account is removed.

### Create Party Page

![Party Page](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/UiPages/firstPartyPage.png)

The party page contains the ability to create a party using the create party button. This leads to the party page the user made.
There is also a join party with code button and input, which leads to the party code host's party page if the code if valid. Finally, the user can listen to music. Pressing play plays the users' current track, rewind plays the previous, fastforward plays the next, sync will sync with a party host (if in a party), and + will open a add song screen to search and select a song. The home page button goes to the home page. The profile button goes to the user's profile.


### Party Page

![Party Page](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/UiPages/finalPartyPage.png)

The party page contains the song the party is listening to and a join code button to get a code to join/invite to the party. 
The home page button goes to the home page. The profile button goes to the user's profile. The delete party button appears for
the party host and allows for deleting the party. The join code button appears for the party host and will generate a join code 
for the party. After the join code button appears, the host will see a 'close party' button, which will make it so no new users
can join the party. If the party is closed, an 'open party' button will appear that lets the host open to party so new users
can join. The host can also see a 'show kick' button, which makes 'x's appear by each user that can be kicked and makes a 'hide kick'
button appear to end this stage. The host can also delete their party via 'delete party'. There is also a button to share the join
code to twitter. If the person on this page is a party member but not a host, they will only see the join code, twitter share, and a 'leave party' button. Finally, the user can listen to music. Pressing play plays the users' current track, rewind plays the previous, fastforward plays the next, sync will sync with a party host (if in a party), and + will open a add song screen to search and select a song.

## UI Flow Chart with Images

![UI Flow Chart](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/uiDiagram.png)

This is the flow of a normal user throughout the website pages. At the start, the user is compelled to either login,
register, or reset their password through the first screens. Then, the user is directed to the homepage which shows tracks.
The homepage allows user to view and vote on the tracks, or to view a spotify leaderboard that has the live top 50 tracks
for spotify loaded. It also has options to view either their profile, their party, or go back to the homepage. The party page 
allows users to create, manage, and use join codes for their party, and they can go back to the homepage or the profile from here. 
The profile page allows users to edit their name, email, and password. They can also enable TFA, connect spotify, logout other 
sessions, and delete their account. Finally, users can always logout, which returns them to the register screen.

## Page / User Story Table

| UI Screen                 |     User Story ID   |
|---------------------------|:-------------------:|
|    Login Page             |     001, 015, 002   |
|  TFA Login Page           |     012             |
|  Forgot Password          |       003, 015      |
|  Reset Password           |      017            |
|  Register Page            |     000, 015, 002   |
|     Home Page             | 008, 009, 010, 013, 023, 024, 026  |
| User Profile Page         | 002, 011, 012, 018  |
| Confirm TFA Popup         |     012             |
| Confirm Sess Logout Popup |    012              |
| Confirm Act Delete Popup  |    012              |
|     Party Page            | 004, 006, 007, 005, 014, 019, 021, 022, 025  |

# Resource Management

The resources needed to host the PHP 8 server are linearly correlated to the number of users that access the website.
For the most part, PHP and NGINX handles RAM and CPU allocations for the requests that are received from the client. Our
PHP framework and the mysqli PHP extension handle database connection pooling to efficiently route requests to database
connections. Currently, only vertical scaling of the web server and database is supported, vertical scaling is not
supported by the infrastructure but can be easily added. Our code will be written to be executed within a reasonable
period of time based on the task based on Big O algorithm analysis so resources are not wasted on a request.

# Security

The Laravel framework provides a very good starting point for code security. It provides the infrastructure for some of
the most important security concepts in web development including form validation, CSRF tokens, encrypted sessions, and
a solid foundation of open source, peer reviewed code for many aspects of a web application such as the request router,
output class, MVC framework concepts, database query builder using eloquent ORM, and much more. User authentication is
handled by the framework as well using Laravel Sanctum with passwords encrypted by the standardized bcrypt algorithm. In
terms of server security, LTS releases are being used for every piece of third party software used including Ubuntu
Server, NGINX, PHP, NPM, NodeJS, among other technologies. TLS is also being used for every request between the server,
and the client with standard recommended ciphers and DH parameters. The SSL/TLS security is independently confirmed by
SSL labs with an A+ overall rating.

# Performance

Web applications are, for the most part, meant to receive data from the client, and then decide what to do with that
data while communicating with a database. When the server receives data, it will usually either store that data in the
database, or decided what information to pull from the database and send back to the client. These operations, in our
case, are going to use very little resources on the server and will be very performant with the infrastructure we have
set up with AWS. The most concerning part of our applications performance will be the latency in-between our clients
group listening sessions, however most of the hard work will be done by Spotify's immense infrastructure, with our job
being to simply connect the users together. In terms of our specific code performance and optimizations, we will be
using a tool called blackfire that allows us to measure the performance of specific functions and operations on the
server in order to find what needs improving, and confirm that there is no performance bottleneck in our application.

# Scalability

As the scope of this project will simply be meant as an application to be graded, used, and tested by a minimal number
of people, scalability is not too much of a concern. However, the way that our AWS infrastructure is set up will allow
for an easy transition of both vertical and horizontal scaling of web servers and databases depending on the current and
estimated future demand of our application. Also, outside the scope of this class is the possibility of using serverless
technologies to allow for virtually unlimited scaling of our applications database and API endpoint. Static assets are
not a concern as we will be using AWS Cloudfront CDN to deliver frontend assets to the client.

# Interoperability

Websites, for the most part, are inherently interoperable between any device with an internet connection and a browser.
Our compatibility with browsers will be the same as the compatibility of our frontend framework, TailwindCSS. Which is
defined as being "designed for and tested on the latest stable versions of Chrome, Firefox, Edge, and Safari." The
backend does not need to be interoperable as it is does not depend on the clients hardware or software. However, in
terms of interoperability of the backend, if AWS is no longer required, our software can be easily moved and built on
any infrastructure the supports PHP and MySQL software.

# Internationalization/Localization

Only english will be supported at this time. Cloudfront CDN will ensure our static assets are available globally with a
quick response time, while our main server is located in North Virginia which might cause some delay for non-US
countries in terms of API response latency.

# Input/Output

VibeCity will be using CRUD operations through Laravel resource controllers. The possible actions of a CRUD resource are
index, create, store, show, edit, update, and destroy. Depending on the action, the frontend will make either a GET,
POST, PUT/PATCH, or DELETE HTTP/2 requests to the server, the server will then receive the data sent by the client and
choose what to send back based on the request. The I/O from the server to the database will be handled by the Laravel
and PHP database connection pooling. The backend will make requests in compliance to the CRUD operations to the database
in order to manage the sites stored data.

# Error Processing

There are two methods of error processing that will need to be taken into account. The first is backend errors, when
something unexpected happens, and the PHP throws an error, we will need to do a couple of things. The first will be
letting the client know that there was an error and inform them of what they need to do, if anything, elegantly. The
second will be to handle the error in the backend. If the error comes after previous methods that changed data, those
changes may need to be reversed in order to keep the system stable. If the error is immediately recoverable, it should
be recovered from in a reasonable amount of time to allow the client to continue with what they were doing. In case of a
fatal error that causes operational issues across multiple clients, the affected clients should all be informed, and it
should either be automatically recovered from as soon as possible, or the developers/creators of the application should
be notified of such issue as soon as possible.

# Fault Tolerance

Similarly to error processing, if there is a fatal error that is non-recoverable, the developers will be notified. The
software will be build to the best of our abilities to automatically recover from errors as soon as possible, if
possible. The web services are also set to automatically restart in case of a critical error that halts the web server
process, or relating processes. In the case of an API that the application is dependent on being down, if it is possible
to continue without it, it will be done. If it is not possible to continue without it, or if the feature will have
limited functionality, the client will be notified, and the feature will be limited or disabled until the dependency
works again.

# Architectural Feasibility

As the project is using AWS, we can scale as far as we want when needed, the architecture is set up to scale at any time
as mentioned in scalability. As more features are added, or different approaches are taken, this can be easily expanded
upon or scaled differently as the flexibility of AWS is true and tested among multiple production workloads.

# Overengineering

VibeCity will initially strive to be the minimal viable product for the timespan given for the project. However, it will
be built in mind of a possible future production grade application. In order to ensure that some portions of the
application are less or more robust than others, we will strive to build the minimal viable code to get the task
completed, but leave room to expand later. This approach will allow for quick and effective testing, expandability, and
a smooth experience for the client. We will also have to take into consideration all the API changes that may need to be
done in the future, and make sure that external dependencies are robust enough to be easily changed in the future using
an interface for them.

# Build-vs-Buy Decisions

The third party libraries we will be using will be the Spotify API for group listening, AWS API for sending emails and
other miscellaneous AWS services we need, the Laravel Framework, and Laravel Jetstream as a starting point for user
authentication and user profiles. Our frontend framework will be TailwindCSS, which is supported and provides a good
place to start with the frontend development.

# Reuse

Other than our frontend and backend frameworks and libraries, our code will not be reusing any pre-existing software.

# Change Strategy

Our strategy for planned or sporadic changes in strategy or code processes will be to consider the consequences of such
a change, refactor as necessary, but also have the code originally built to avoid issues while making such changes. We
will stick to standardized practices as close as possible to avoid needing to change things later, such as encryption
algorithms, object types, code methods, etc.
