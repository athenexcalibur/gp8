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
There are currently no food sharing sites based in the UK. However there is one site based in [Germany](https://foodsharing.de/). As such most of the users are within Germany, since the site itself is in German.
There are also a couple of mobile-only food sharing platforms:

* [Olio](https://olioex.com/): Mobile app with strong UK prescence. A key distinguishing feature is "Drop Boxes". These are local stores/cafes where users can drop off food they'd like to be shared
* [SharingFood](https://itunes.apple.com/us/app/sharing-food/id992111062?mt=8): Mobile app based in Italy. Seems to be fairly new and so has a very small user base.

An interesting feature shared by all three apps is that their search functions and catalogs are strongly based on location. Our current design includes search filters for types of food, Allergy Information e.t.c., yet these three apps/sites seem to have none of those. Instead, they all place a lot of emphasis on the Interactive Map, making it the easiest to find feature.This may indicate that users may be more concerned about how far away the food is rather than what is actually on offer.

Additionally, all three sites seem to have a private messaging functionality: a feature we thought was unnecessary. Therefore we may have to reassess the need for a privaate messaging feature.

##Proposed Deliverables

##Identified risks, assumptions, dependencies and constraints
* User Location: How much information about the user's location can we make publicly available without putting their security ar risk?

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
*Items will be stored in only one location and so will be consistent.
*Animations and transitions will be simple and fluent in order to keep the interface responsive.
*No functionalities will be exclusive to the desktop interface and vice versa.

##Development Approach
####Key Summary
We've decided to use PHPStorm as the main IDE. Ultimately we hope to host the Database (and possibly website) on AWS. We will mainly collaborate using Github and Slack (and occasionally email).

Though we'll all inevitably contribute to both sides of the site, we've decided to split the work as follows:
* __Design and Frontend:__ Clare, Ucizi and Luke
* __Database and Backend:__ Soumya and Abdul

####Development  Stack
* PHP (Database and other backend features)
* HTML/CSS 
* SQL
* Javascript (Client-side features)
* Bootstrap (Simplifies mobile compatibility)
* Git
##Definition of terms and references
