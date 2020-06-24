## 1 When a function is invoked with the constructor invocation pattern using the new prefix, this modifies the way in which the function is executed. If the new operator were a method instead of an operator, it could have been implemented like this:

```
Function.method('new', function ( ) {
// Create a new object that inherits from the
// constructor's prototype.
var that = Object.create(this.prototype);
// Invoke the constructor, binding –this- to
// the new object.
var other = this.apply(that, arguments);
// If its return value isn't an object,
// substitute the new object.
return (typeof other === 'object' && other) || that;
});
```

<hr/>

## 2 Sometimes is it useful for data structures to inherit from other data structures. Here is an example: Suppose we are parsing a language such as JavaScript or TEX in which a pair of curly braces indicates a scope. Items defined in a scope are not visible outside of the scope. In a sense, an inner scope inherits from its outer scope. JavaScript objects are very good at representing this relationship. The block function is called when a left curly brace is encountered. The parse function will look up symbols from scope, and augment scope when it defines new symbols:

```
var block = function ( ) {
// Remember the current scope. Make a new scope that
// includes everything from the current one.
var oldScope = scope;
scope = Object.create(scope);
// Advance past the left curly brace.
advance('{');
// Parse using the new scope.
parse(scope);
// Advance past the right curly brace and discard the
// new scope, restoring the old one.
advance('}');
scope = oldScope;
};
```
