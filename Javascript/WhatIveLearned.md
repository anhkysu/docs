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
