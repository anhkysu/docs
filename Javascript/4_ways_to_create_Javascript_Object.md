## Four ways to create a Javascript object

- ### **Object Literals**

```
var car = {
  model: 'Vinfast',
  color: 'Steelblue',
  price: 70000
}
```

- ### **New Operator or Constructor**

**If you call a function `using a new operator, the function acts as a constructor` and returns an object**

```
function Car(model, color){
    this.model = model;
    this.color = color;
}

var car1 = new Car('BMW', 'red');
```

- ### **Object.create Method**

```
var Car = {
    model: 'BMW',
    color: 'red'
}
var ElectricCar = Object.create(Car);
var ElectricCar02 = Object.create(Car, {
  type: {
    value: 'Electric',
    writable: true,
    configurable: false,
    enumerable: true
  }
})
```

- ### **Class**

```
class Car {
  constructor(maker, price){
    this.maker = maker;
    this.price = price;
  }

  getInfo(){
    console.log(this.maker + " costs : " + this.price);
  }
}
```
