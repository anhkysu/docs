# The evil twins: != & ==

> If two operands are not of the same type, the little twins will produce problems

# with Statement

> Fucking hard to understand when it's not worth

```
The statement:
with (obj) {
a = b;
}
does the same thing as:
if (obj.a === undefined) {
a = obj.b === undefined ? b : obj.b;
} else {
obj.a = obj.b === undefined ? b : obj.b;
}
So, it is the same as one of these statements:
a = b;
a = obj.b;
obj.a = b;
obj.a = obj.b;
```

# eval Function

> The eval form is much harder to read. This form will be significantly slower because it needs to run the compiler just to execute a trivial assignment statement

# continue Statement

> The continue statement jumps to the top of the loop.

# swith Fall Through

# Block-less Statements

# ++ --

# Bitwise Operators

# Function Statement VS Function Expression

> Official grammar assumes that a statement that starts with the word function is a function statement.

```
The statement : function foo(){}  --> function statement
means about the same thing as : var foo = function (){} --> function expression
```

# Typed Wrappers

> Unecessary. Avoid using new Boolean(false), new Number, new String, new Oject, new Array. use {} and [] instead.

# new

> Javascripts' new operator creates a new obbject that inherits from the operand's prototype member, and then calls the operand, binding the new object to this.

> If you forget to use the new operator, you instead get an ordinary function call and this is bound to the global object instead of to the new object.

> By convention, functiosn that are intended to be used with new should be given names with initial capital letters, and names with initial capital letters should be used only with constructor functions that take the new prefix.

# void

> In many languages, void is a type that has no values. In javascript, void is an operator that takes an operand and returns undefined.
