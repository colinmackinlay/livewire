###### 1. Install Laravel with Auth Framework

ALL OK

###### 2.Install Livewire and Sushi
1.  Setup two Sushi models for Countries and Airports (truncated data)
2.   Setup view for country list with url '/countries'
3.   Setup Livewire component for individual country with list of airports
4.   Delete link fires livewire method to delete an airport (now replaced with logging to record it rather than do it)
5.  ALL OK whether logged in or not i.e. user or guest can 'delete' an airport
6.  Add a policy to control updates - set to authorise anyone but to record it has been called
7.  LOGGED IN users can 'delete' OK and deletion is recorded as is the call to the policy
8.  GUESTS get a 403 unauthorised with nothing deleted or logged. This is EXPECTED as the authorise method fails before even asking the policy since there is no logged in user to check against

ALL OK SO FAR

###### 3. Write Unit Tests to prove the above
1.  NB Requires addition of resetStatics() and setSushiConnection($connection) as Sushi doesn't support 'use DatabaseTransactions'
2.  ALL TESTS PASS

ALL OK SO FAR
