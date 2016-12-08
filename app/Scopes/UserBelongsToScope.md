 
 > Usage:
 
 **this is a work in progress**
 ```
 class MyModel extend Model {

        use App\Scopes\UserBelongsTo;
 

    }

    $locations = Location::getByUser(10)->first();
     
 ```