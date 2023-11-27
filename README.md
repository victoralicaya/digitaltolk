# digitaltolk

# My thoughts about the code
# What makes it an amazing code or an ok code
- `I like that it is using a repository pattern which is good because if keeps your controller clean. It prevents you code to look cramped in the long run if you add more logic into it. It is also good for code reusability.`
- `The logic and code structure is fine.`

`I refactored the code based on what I think what I will do to make it look better, easy to read, or easy to maintain. I didn't make the optional task.`

# What makes it a terrible code
- There's no request validation being made. Laravel has a built-in request validation which you can customize based on your needs. Using Laravel's request validation lets you use the `$request->validated()`, compare to `$request->all()`, the `$request->validated()` is way more secure since it will only get the data that is being validated and not all the data being passed through the request.
- The variable `$repository` is I think not named properly, it's better to named the repository based on what repository you are going to use, instead of using a generalized word like `$repository` we should instead use `$bookingRepository` since this is the name of the repository being injected into the `BookingController`.
- The use of `$request->__authenticatedUser` may be good but I prefer using something like `Auth::user()` or `auth()->user()` which returns the authenticated user. The `$request->__authenticatedUser` may cause a problem if you use a custom request validation which is a built-in feature in Laravel.
- The use of `response()` is good but utilizing Laravel's built-in resource will make it better as it let's you customize what data you just want to return instead of manually coding the response it in the repository.
- The use if `$id` is good when getting specific data but a model route binding approach could make it look better.
- This is optional but using of Http codes makes the response looks proper and accurate.
- There's no condition in the repository that let's you know if there's a response not none when looking for a specific data.
- Some line of codes are being put into one line like some queries where functions are being chained which is not easy to read, putting them in the next line will make it more easy to read and understand.
- No proper formatting or spacing of code which makes it not easy to read. Some examples of these are conditional statements that looks like it is being chained because it only has one next line.
- Using of the `Request` class as parameters in both the controller and repository making it repetitive.
- Some conditional statements are being used in it's normal way instead of just using a ternary operator.
- Some variables that have the same value are being declared many times instead of just declaring one and use it again.
- `return $response` is being used many times even on conditional statements instead of just returning it at the end of the function as intended.
- Some conditional statements contain almost the same block of code which is also repetitive.
- Some `if()` statements that only has one conditional block are being written like this `if(someCondotionsHere) return something` and some conditional blocks are in the next line which makes the code not consistent.
- Some functions have conditional statements that contains a long line of code instead of breaking them into small pieces like putting it in a private function.
- Some variables with an initial value of an empty array is being written this way `array()` which still works but using `[]` makes the code better and easy to type.
- A specific function in the controller contains business logic which is still correct but since we are using repository pattern, we should keep our controller clean.
- A return from some functions does not contain a clear message.
- A specific function in the repository is using a `curl` when trying to call an external API which is still correct but Laravel has a built-in `Http` class that we can use.







