- `Array`: is a linear allocation of memory in which elements are accessed by integers that are used to compute offsets. However, Javascript does not have this kind of array. Instead, JS provides an object that has some array-like chracteristics.

```
var empty = [];
var numbers = [
              'zero', 'one', 'two', 'three', 'four',
              'five', 'six', 'seven', 'eight', 'nine'
              ];
empty[1] // undefined
numbers[1] // 'one'
empty.length // 0
numbers.length // 10
Length | 59

The object literal:
var numbers_object = {
'0': 'zero', '1': 'one', '2': 'two',
'3': 'three', '4': 'four', '5': 'five',
'6': 'six', '7': 'seven', '8': 'eight',
'9': 'nine'
};
```

_numbers inherits from Array.prototype, whereas numbers_object inherits from Object.prototype, so numbers inherits a larger set of useful methods. Also, numbers gets the mysterious length property, while numbers_object does not._

_In most languages, the elements of an array must be the same type. But Javascript allows an array to contain a mixture of values._

- `Javascript Array Length`: Unlike most other languages, Javascript's array length is not an upper bound. If you store an element with a subscript that is greater than or equal to the current length, the length will increase to contain the new element. The length property is the largest interger property name in the array plus one. The length can be set explicitly. Making the length larger does not allocate more space for the array. Making the length smaller will cause all properties with a subscript that is greater or equal to the new length to be deleted. There are two ways to append an item to the end of an array:

```
numbers[numbers.length] = 'shi';
// numbers is ['zero', 'one', 'two', 'shi']
///
numbers.push('go');
// numbers is ['zero', 'one', 'two', 'shi', 'go']
Delete
```

- `Javascript Delete Method`: Since JS'array are really objects, the delete operator can be used to remove elements from an array. Unfortunately, that leaves a hole in the array. This is because the element to the right of the deleted element retains their original names. Javascript does provide a method called 'splice' to delete the item and decrease the property name.

```
delete numbers[2];
// numbers is ['zero', 'one', undefined, 'shi', 'go']
```

```
numbers.splice(2, 1);
// numbers is ['zero', 'one', 'shi', 'go']
```

- `Javascript for in method`: Since Js' arrays are really objects, the **for in statement** can be used to interate over all of the properties of an array. Unfortunately, for in makes no guarantee about the order of the properties, and most array applications expect the elements to be produces in numerial order.

- `Confusion about JS arrays and objects`: The rule is simple: when the property names are small sequential integers, your should use an array. Otherwise, use an object.

- `Methods in JS's Array`: The methods acting on JS's array are stored in Array.prototype. Array.prototype can be augmented as well. For example,

- `Add method to a JS array - WTF`: Because an array is really an object, we can add methods directly to an individual array.

- `Javascript Dimensions`: Javascript does not have arrays of more than one dimension, but like most C languages, it can have arrays of arrays. Javascript arrays usually are not initialized.

> Vocab:

- **subscripts**: a word, letter, symbol or number writtern just below another word, letter, number or symbol usually in a smaller size.

- **literals**: its origin

- **explicitly**: in a way that is clear and exact
