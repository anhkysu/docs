# Global Variables:

- A global variable is a variable that is visible in every scope.
- Global variables can be a convenience is very small programs, but they quickly become unwieldy as programs get larger.
- Because a global variable can be changed by any part of the program at anytime, they can significantly complicate the behavior of the program.
- Use of global variables degrades the reliability of the programs.
- There are 3 ways to create a global variable:

```
//first way - define this outside of every function: var foo = value;
//second way - window.foo = value;
//third way - foo = value;
```

# Scope:

- Javascripts use block syntax, but does not provide block scope: a variable declared in a block is visible everywhere in the function containing the block.
- In Javascript, it's best to declare variables at the top of each function.

# Semicolon Insertion:

- Javascript has a mechanism that tries to correct faultt programs by automatically inserting semicolons.
- It sometimes inserts semicolons in places where they are not welcome:

```
return
{
status: true
};

```

# Reserved Words:

- Reserved words in javascript cannot be used to name variables or parameters.

# Unicode:

# typeof:

- typeof `null` returns object.
- typeof cannot distinguish between null and objects, but you can because null is falsy and all objects are truthy.
- if(my_value && typeof my_value === 'object'){
  // my_value is an object or an array
  }

# parseInt:

- a function converting a string to an integer, it stops when it sees a nondigit.
- if the first chracter of the string is 0, then the string is evaluated in base 8 instead of base 10. In base 8, 8 and 9 are not digits, so parseInt("08") and parseInt("09") produce 0 as their result.

# Floating Point:

- Binary floating-point numbers are inept at hanlding decimal fractions, so 0.1 + 0.2 is not equal to 0.3. THIS IS THE MOST FREQUENTLY REPORTED BUG IN JAVASCRIPT.
- This failure is an intentional consequence of having adopted the IEEE standard for Binary Floating Point Arithmethic (IEEE 754). This standard is well-suited for many applications, but it violates most of the things you learned about numbesr in middle school.

# NaN:

- The value NaN is a special quantity defined by IEEE 754. It stands for not a number, even though: `typeof NaN === 'number'`
- One way to make NaN is to convert a string to a number but the string cannot be a number.
- NaN is not equal to itself

```
NaN === NaN  // false
NaN !== NaN  // true
```

- Javascript provides an isNaN function that can distinguish between numbers and NaN.

```
isNaN(NaN) // true
isNaN(0) // false
isNaN('oops') //true
```

# Phony Arrays:

- To determine that a value is an array, you also need to consult its constructor property:

```
if(my_value && typeof my_value === 'object' && my_value.constructor === Array) {
  // my_value is an array
}
```

# Falsy Values:

// ---value----------type
// ----0-------------Number
// ----NaN-----------Number
// ----''------------String
// ----false---------Boolean
// ----null----------Object
// ----undefined-----Undefined

# hasOwnProperty:

- hasOwnProperty is a method, not an operator, so in any object it could be replaced with a different function or even a value that is not a function.

# Object:

- Javascripts's objects are never truly empty because they can pick up members from the prototype chain.

------------------------- Vocabulary -------------------------

- unwieldy: an unweildy system is slow and not efftive.
- inept: not effective and not skilled.
