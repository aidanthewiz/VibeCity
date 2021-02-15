# Program Organization

## System Context Diagram

![System Context Diagram](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/SystemContextDiag.PNG)

This diagram shows the VibeCity System in scope of the interactions between it, internal processes, and external users
as well as software.

|     Context       |     User Story ID   |
|-------------------|:-------------------:|
|   VibeCity User   |      000 - 015      |
|  VibeCity Party   | 005, 006, 007, 014  |
|  VibeCity System  |      000 - 015      |
|  Spotify Webapp   |       002, 013      |

## Container Diagram

![Container Diagram](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/ContainerDiag.PNG)

This diagram shows the VibeCity System in more depth, showing how it functions internally to retrieve music and relevant
data as well as how it displays such music/data to the user through the Web Application and connects to Spotify through
the relevant API.

|     Container       |     User Story ID   |
|-------------------|:-------------------:|
|   VibeCity User   |      000 - 015      |
|  Web Application  | 004, 005 - 011, 013 |
|     Database      | 000 - 003, 008 - 013 |
|  Spotify System   |       002, 013      |
|    API System     |    002, 008, 013    |

## Component Diagram

![Component Diagram](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/ComponentDiag.PNG)

This diagram shows how the VibeCity API uses various components to accomplish sign-in and account summary actions
between the Web Application and the database, as well as connect to the database and Spotify's system for the music
management actions.

|     Context       |     User Story ID   |
|-------------------|:-------------------:|
|  Web Application  |      000 - 015      |
| Sign-In Controller | 000, 001, 002, 011 |
| Reset Password Controller |     003     |
| Account Summary Controller |  011, 012  |
| Security Component | 000, 001, 002, 003 |
|  Email Component  | 000, 001, 002, 003  |
|     Database      |      000 - 014      |

# Code Design UML Diagram

## Class Diagram

![Code Design UML Diagram](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/UMLDiagram.png)

The user in the class diagram should hold the users ID, the users Password, the users Email, and the users spotify
account link. The user shall be able to modify there information. The users should be able to create private parties
that have a party ID, party passcode, party members, and assign a party leader. In the party class the user can create,
close, share the party information, and set the song to listen to. Users can vote on tracks that they like. The tracks
are listed on a leaderboard. The comment class allows the users to comment on certain tracks that they have listened. In
the comment class the user can write content, give a rating, list who made the comment, and show what song these
comments were applied to.

| Classes           |     User Story ID       |
|-------------------|:-----------------------:|
| Users             | 000, 001, 002, 003      |
| Parties           | 004, 005, 006, 007, 014 |
| Comment           | 010                     |
| LeaderBoard       | 008, 009, 013           |
| Track       | 008, 009, 013           |

## Activity Diagram

![Activity Diagram](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/activitydiagramdone.png)

This diagram shows the flow of activities for a given user in the system. It shows the user login and authentication
section, then all the actions the user can perform once logged into the site. These include viewing the party page,
party actions, viewing the profile page, profile actions, and viewing the leaderboard page, as well as leaderboard
actions. Finally, the system ends with the user logging out.

# Data Design

![Database ER Diagram](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/Database%20ER%20Diagram.png)

The user should be able to join a party and add comments to tracks. Partys should be able to listen to tracks. Tracks
should be able to have comments on them and have rankings on the leaderboards.

# Business Rules

In the present, the architecture does not depend on any business logic, however in the future, we will ensure GDPR, and
other compliance of the like which will need to be taken into consideration when designing the architecture to ensure
proper compliance to anything we deem necessary.

# User Interface Design

## Sign-In Page

![Sign-In Page](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/UiPages/signInPage.png)

This is the sign on page and the first page the user would see on visiting the site. It allows existing users to login.
On login, it leads to the home page. The register button leads to the register page for new users. The forgot password
link leads to the forgot password page.

## Forgot Password Page

![Forgot Password Page](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/UiPages/forgotPasswordPage.png)

This is the forgot password page for existing users who forgot their password. If the user exists, a forgot password
link will be sent to their email, and the page will redirect to sign in.

## Register Page

![Register Page](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/UiPages/registerPage.png)

This page allows new users to register. On clicking register, if all fields are valid, an account will be created for
the user and they will be redirected to the homepage. If the user already has an account, they can go back to the login
page by clicking login.

## Home Page

![Home Page](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/UiPages/homePage.png)

This is the homepage after logging in as an existing user. This page includes the rankings of tracks by VibeCity users.
Users can press the rating buttons to rate up and down the tracks. They can go to the party page to host and join
parties through the party button. They can view their profile through the profile button.

## Profile Page

![Profile Page](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/UiPages/userProfilePage.png)

This is the user profile page. It has all the user's information. It also has the user's linked spotify account. This
page can go to the home page through the home button. It can also go to the party page through the party button.

## Party Page

![Party Page](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/UiPages/partyPage.png)

The party page contains the song the party is listening to and a join code to join/invite to the party. The home page
button goes to the home page. The profile button goes to the user's profile. Finally, the join code button allows for
joining and inviting to a party through a popup.

## Join Code Popup

![Join Code Popup](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/UiPages/joinCodePage.png)

The join code popup can be used to enter or retrieve the party join code. The join code popup has an exit button to
close the popup.

## UI Flow Chart

![UI Flow Chart](https://raw.githubusercontent.com/aidanthewiz/VibeCity/master/artifacts/uiDiagram.png)

This is the flow of a normal user throughout the website pages. At the start, the user is compelled to either login,
register, or reset their password through the first screens. Then, the user is directed to the homepage, and has options
to view either their profile, their party, or go back to the homepage.

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
