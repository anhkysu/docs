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
