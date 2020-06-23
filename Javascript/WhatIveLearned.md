- `block`: set of statements wrapped in curly braces (do not create new scope)

- `label prefix`: The switch, while, for and do statments are allowed to have an optional label prefix that interacts with the break statements

```
let str = '';

loop1:
for (let i = 0; i < 5; i++) {
  if (i === 1) {
    continue loop1;
  }
  str = str + i;
}

console.log(str);
// expected output: "0234"
```

- `6 falsy values`: false/ null/ undefined/ '' (empty string) / 0 (number) / NaN (number)

- `disruptive statements`: statement with break at the end

> Expression page 15

- `operator`: like +/-/%///===/!==/unary operators (delete/new/typeof/+/-/!) --> is how operation is made

- `operand`: is what is operated on in an operation

- `invocation operator`: eg: (), (asd,)

- `refinement`: a refinement is used to specify a property or element of an object or array.

- `function literal`: can have an optional name that it can use to call itself recursively.

- `gurading nested objects`: flight.qeuipment -> undefined, flight.equipment.model -> Throw 'TypeError', flight.equipment && flight.equipment.model -> undefined

- `Using for in statement` there is no guarantee on the order of the names, so be prepared fo the names to appear in 'any' order. Solutions: avoid using for in statement in order sensitive case. Instead, make an array containging the names of the propertives int he corret order. (e.g: Usingfor instead of using for in)

- `Function literals` (cú pháp): A function literal há 4 parts. 1st part is the reserved word function. 2nd is an optional function's name. 3rd is set of parameters wrapped by parenthese. 4th part is a set of statements wrapped by curly braces. An innter function of course has access to its parameters and variables and also enjoy access the the paramenters and variables of the function it is nested in.

- `The invocation operator` is a pair of parentheses that follow any expression that produces a function value.

- `The method Invocation Pattern` when a function is stored as a property of an object, we call it method.

- `The problem of Javascript language design and this/that`: When a function is not the property of an object, then it is invoked as a function. And in this case, the _this_ key word is bound to the _global_ object. Had the language been designed correctly, when the innter function is invoked, this would still be bound to the this variable of the outer function. As a result, A method cannot employ an inner function to help it do its work because the inner function does not share the method's access to the object as this is bound to the global object. Using that = this in an function object property will solve this problem.

```
// Augment myObject with a double method.
myObject.double = function ( ) {
var that = this; // Workaround.
var helper = function ( ) {
that.value = add(that.value, that.value);
};
helper( ); // Invoke helper as a function.
};
// Invoke double as a method.
myObject.double( );
document.writeln(myObject.value);
```

- `prototypal inheritance language`: Javascript is the left. That means that objects can inherit properties directly from other objects. The language is class free. Prototypal inheritance is powerfully expressive

- `classical language`: Most languages today are classical. (using classes)

- `The constructor Invocation Pattern`: Functions that are intened to be used with the new prefix are called constructors.

- `The Apply Invocation Pattern`: Javascript is a _functional object-oriented language_, functions can have methods. The apply method lets us construct an array of arguments to use to invoke a function. It also lets us choose the value of this. The apply method takes two parameters. **The first is the value that should be bound to this. The second is an array of parameters.**

- `Arguments`: A bonus parameter that is available to function when they are invoked is the **arguments** array. Because of a design error, arguments is not really an array. It is an array-like object. arguments has a length property, but it lacks all of the array methods

```
// Make a function that adds a lot of stuff.
// Note that defining the variable sum inside of
// the function does not interfere with the sum
// defined outside of the function. The function
// only sees the inner one.
var sum = function ( ) {
var i, sum = 0;
for (i = 0; i < arguments.length; i += 1) {
sum += arguments[i];
}
return sum;
};
document.writeln(sum(4, 8, 15, 16, 23, 42)); // 108
```

- `Return`: When a function is invoked, it begins execution with the first statement, and ends when it hits the } that closes the function body. That causes the function to return control to the part of the program that invoked the function.

- `Augmenting Types`: JavaScript allows the basic types of the language to be augmented. Adding a method to Object.prototype makes that method available to all objects. This also works for functions, arrays, strings, numbers, regular expressions, and booleans. For example, by augmenting Function.prototype, we can make a method available to all functions. By augmenting the basic types, we can make significant improvements to the expressiveness of the language. The prototypes of the basic types are public structures, so care must be taken when mixing libraries. One defensive technique is to add a method only if the method is known to be missing.Another concern is that the for in statement interacts badly with prototypes.

```
// Add a method conditionally.
Function.prototype.method = function (name, func) {
if (!this.prototype[name]) {
this.prototype[name] = func;
return this;
}
};
```

- `Recursive function`: A recursive function is a function that calls itself, either directly or indirectly. Some languages offer the tail recursion optimization. This means that if a function returns the result of invoking itself recursively. **Functions that recurse very deeply can fail by exhausting the return stack:**

- `Scope`: Scope controls the visibility and lifetimes of variables and parameters. This is important because it reduces naming collisions and provide automative memory management.

- `Block Scope`: Most language with C syntax have block scope. All variables defined in a block ( a list of statements wrapped with curly braces) are not visible from outside of the block. However, Javascript does not have a block scropt even though its block syntax suggests that it does. This confusion can be a source of errors.

- `Function Scope`: Javascript does have function scope. Parameters and variables defined in a function are not visible outside of a function, and that a variable defined anywhere within a function is visible elsewhere within the function.

- `Closure`: I can understand it but not now
