# Trait CodeSection
 
 You can use trait in your models with "code" field (string)
 
# Usage

```php
    
    class MyModel extend Model {
    
        use App\Scopes\CodeSection;
    
        ...
    
    }
    
    $bycode = MyModel::getByCode('Andrey')->first();
    $likecode = MyModel::likeByCode('And')->first();
    $nullcode = MyModel::nullCode()->get();
    $notnullcode = MyModel::notNullCode()->get();
    
```