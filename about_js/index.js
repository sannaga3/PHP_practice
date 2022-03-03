array1 = ['a', 'b', 'c', '0', 0, 1];

// in はインデックス番号, of は要素の値が変数に格納される
for(let i in array1) {
  console.log(i);
}

for(let i of array1) {
  console.log(i);
}

// 配列の要素にfalsyがあるとループを抜けてしまう
let a, i = 0
while(a = array1[i++]){
  console.log(a);
}

// 無名関数   名前をつけずに呼び出す関数のこと。オブジェクトや引数として用いられ、その１箇所のみでしか使わない関数には名前が必要ない。左記に使われる場合でも、他の箇所で再利用する場合は関数に名前をつけて部品化する。
// https://hatoblog.net/anonymous-function/

const Bob = {
  name: 'Bob',
  age: 20,
  selfIntroduction: function() {
    console.log(`I'm ${this.name}, ${this.age}`);
  }
};

Bob.selfIntroduction();

const Alice = {
  name: 'Bob',
  age: 20,
  selfIntroduction: function() {
    console.log(`I'm ${this.name}, ${this.age}`);
  }
};

// アロー関数の引数がない場合 () ではなく _ とすることもある
const greet = _ => 'hello';
console.log(greet());

function hello(callback) {
  console.log(callback);
}
hello(() => 'hello');


// callback関数
function calculate(a, b, callback) {
  const result = callback(a, b);
  console.log(result);
}

function plus(a, b) {
  return a + b;
}

function multiply(a, b) {
  return a * b;
}

calculate('a', 'b', plus);
calculate(2, 3, multiply);

console.log(document.querySelector('#element1').innerText);
console.log(document.querySelector('div'));
console.log(document.querySelectorAll('div'));
console.log(document.querySelectorAll('div')[2].innerText);