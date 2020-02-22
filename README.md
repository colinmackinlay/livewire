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

##### 4. Install tenancy/multitenant
1.  Remove old livewire database and user
2.  Setup new livewire database and mysql user with grant privileges:
```
CREATE DATABASE IF NOT EXISTS livewire;
CREATE USER IF NOT EXISTS livewire@localhost IDENTIFIED BY 'livewire';
GRANT ALL PRIVILEGES ON *.* TO livewire@localhost WITH GRANT OPTION;
```
3.  php artisan migrate
4.  php artisan tinker
```
 App\Tenant::registerTenant('tenant');
```
5.  This registers a tenant and sets up a user
6.  Lots of files here to make the tenancy work. The main difference is that users of the tenant are recorded and authenticated from a "STaff" eloquent model which authenticate through an "employee" guard.The "User" model is reserved for logging in to the host system. I haven't brought in all the code for that as its nnot necessary to demonstrate the issue.

##### 5. Try to use the route
1. Visit tenant.livewire.test
2. Login with credentials "tenant@livewire.test" and "password"
3. Use the link to visit "/country"
4. Go to UK entry "/country/4"
5. Attempt to delete an airport - it won't work
6. Check the log for the info messages
-   It shows only the first one from the Livewire controller showing that the deleteAirport method has been called
-   It doesn't show the authorize call hitting the policy as it fails as if not logged in
##### Show that auth behaves differently in Livewire component in mount and deleteAirport method
I've added logging of auth()->user()->name in two places. It only works when the component is mounted, not in the procedure call. It is there and logged in the render method too. 

PS Although tests worked at the end of section 2, checking out that commit no longer passse the last test. This is due to storing the country as a public variable in the component. Deletions to its airports don't seem to flow through any more (they did) and the component re-renders in tests and browser with the deleted airport showing. Fixed this by calling ->fresh() on the country in render.
