##Introduction
7 million tonnes of food goes to waste in the UK, more than half of which is edible (https://www.lovefoodhatewaste.com/node/2472). Meanwhile,  many people throughout the country struggle to put together enough money for food, with food banks becoming busier every year (https://www.trusselltrust.org/2015/11/18/uk-foodbank-use-still-at-record-levels-as-hunger-remains-major-concern-for-low-income-families/)

Cupboard aims to be a system that allows users to painlessly find and share food that would otherwise go to waste. It should be quick and easy to use as it is too easy to just throw away food. 
It will also allow users to arrange collection in a manner that does not force them to disclose their house address or any other details they wish to keep private.

##Project Scope
Cupboard will facilitate the sharing of food between users. It will do so in a manner that is as simple as possible, as we want to discourage people from taking the easy route of simply binning food they wont eat.
There will be a simple points-based system and a ranking system in order to encourage sharing of food and reassure other users that the quality of food is likely to be good. When some food has been ‘successfully exchanged’ both parties will get points and will be able to rate each other. If users wish to participate, there will be a simple public leaderboard.
Users can set their dietary requirements (allergies, religious etc.) and have results automatically filtered. 
There will be a messaging system (in order to arrange collection) and a comments system (in order to view interest in the item and ask questions).
##Domain Analysis

##Proposed Deliverables

##Identified risks, assumptions, dependencies and constraints

##Functional requirements
###FR1:  User sign up
Users can sign up via email and eventually via social media. As a minimum they will first enter a username, email and password – then be taken to a page where they can optionally set a profile picture, location,  and any dietary requirements.

###FR2:  Listing of items
Users will be able to list an item of food. The minimum amount of information will be a title. Optionally, they may add a picture, location, description, expiry date, and set the dietary requirement flags.  If the user has set their location, it will be automatically added. 

###FR3: Messaging, comments, and collection of food
Messaging (private communication, to exchange exact addresses etc.) and comments (questions that others may be interested in, expressing interest) will be implemented. After food is collected, both parties will have their scores and ratings affected appropriately and the item will be moved to a separate ‘history’ database. (Items can also be deleted, and not moved to a users history)

###FR4: Search
Searching will be implemented in a dynamic fashion using AJAX. By default, items will be listed by location.

###FR5: Points and ratings
A simple points/ratings system will be implemented. When some food has been shared, the donor receives three points and the collector gets a single point. Each party can then rate their experience with the other out of 5. If the user wishes, they may be displayed on a public leaderboard.

##Non-functional requirements

##Development Approach

##Definition of terms and references