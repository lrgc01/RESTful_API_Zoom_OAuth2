* Vanhackathon 2019 - Vanhack only

- Theme: Surprise Us

*** A management system for the Premium Interview English classes. (the one I have chosen)

Nowadays, we rely on Google Calendar to show candidates the times, dates and content of our classes, and on Slack to share a Google Sheets link where they can write down their name and email to sign up and find the Zoom meeting link for that class. 

Please see this diagram to understand how it works: [https://drive.google.com/file/d/1_8F00iKeohH43jAnvwETO_dgHCDIfBcZ/view?usp=sharing](https://drive.google.com/file/d/1_8F00iKeohH43jAnvwETO_dgHCDIfBcZ/view?usp=sharing)

**** What to expect:

 - We would like this process to happen inside the platform, without relying on Google Calendar, Google Sheets, and Slack.

** Solution

*** Model

  - event (English class or any (Zoom) meeting?)
    - id
    - title
    - room link [ zoom, google hangouts, skype, blue jeans, discord, ... ]
    - type of event [ class, speech, workshop, pep talk, ...]
    - premium only? [ yes, no ]
    - verification needed list [ English, code, skills, country, ... ]
    - teacher / presenter list 
    - student / attendant list (blocked/allowed, active/passive, list of verified stuff)
  
  - Student / attendant list
    - id
    - name
    - premium
    - verified list [ English, code, skills, country, ... ]

  - Teacher / presenter list
    - id
    - name
    - company
    - contact

  - types of event (needed ???)
    - id
    - type [ class, speach, workshop, pep talk, ...]

*** Pre-requisites
  - Authorization
    - OAuth authentication

  - Zoom account (develop marketplace as well)
    - User regular account (not pro) - one user only
    - OAuth app created and installed in the Zoom Marketplace
    - Create local URL to be redirected to 
    - User API manuals: https://marketplace.zoom.us/docs/api-reference/
    
  - Data
    - Candidates (students to a class)
    - Teachers or other staff at VanHack
    - Event

*** ToDo List
  - List of person at the beginning - ok
  - Form to list meetings and select one to attend - list ok, form not ok
    - Check for Premium and English - ok
  - Create meeting - ok
  - Delete meeting - ok
  - List meetings - ok
  - Form to proceed with each type of user: 
    - teacher: can create / change zoom meeting
    - candidate: cannot create meeting. Can attend to classes - ok
  - Form to fulfill for a meeting once a meeting is chosen
  - Form to record the OAuth credentials to create meetings in Zoom
  - Design of the data flow (functions) - ok
