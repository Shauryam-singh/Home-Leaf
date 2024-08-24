//console.log('Hello');
//console.log('I like pizza!');

//window.alert('This is an alert!');
//window.alert('I like pizza');

//document.getElementById("myA1").textContent = 'Hello';
//document.getElementById("myP").textContent = 'I like pizza!';


/*let firstname = "Bro";
console.log(typeof firstname);
console.log(firstname);
console.log(`Your name is ${firstname}`);*/

/*let fullname = "Bro Code";
let age = 25;
let isStudent = false;
 document.getElementById("p1").textContent = `Your name is ${fullname}`;
 document.getElementById("p2").textContent = `You are ${age} years old`;
 document.getElementById("p3").textContent = `Enrolled: ${isStudent}`;*/

 /*let username;
 username = window.prompt("What's your username?");
 console.log(username)*/

/*let username;
 document.getElementById("mySubmit").onclick = function(){
  username = document.getElementById("myText").value;
  document.getElementById("myH1").textContent = `Hello ${username}`;
}*/

/*let age = window.prompt("How old are you");
age = Number(age);
age+=1;
console.log(age, typeof age);*/

/*const PI = 3.14159;
let radius;
let circumference;

document.getElementById("mySubmit").onclick = function(){
  radius = document.getElementById("myText").value;
  radius = Number(radius);
  circumference = 2* PI * radius;
  document.getElementById("myH3").textContent = circumference + "cm";
}*/

//Counter Program

/*const decreaseBtn = document.getElementById("decreaseBtn");
const resetBtn = document.getElementById("resetBtn");
const increaseBtn = document.getElementById("increaseBtn");
const countLabel = document.getElementById("countLabel");
let count = 0;

increaseBtn.onclick = function(){
  count++;
  countLabel.textContent = count;
}

decreaseBtn.onclick = function(){
  count--;
  countLabel.textContent = count;
}

resetBtn.onclick = function(){
  count = 0;
  countLabel.textContent = count;
}*/

/*const myButton = document.getElementById("myButton");
const label1 = document.getElementById("label1");
const label2 = document.getElementById("label2");
const label3 = document.getElementById("label3");
const min=1;
const max=6;
let randomNum1;
let randomNum2;
let randomNum3;

myButton.onclick = function(){
  randomNum1 = Math.floor(Math.random() * max) + min;
  randomNum2 = Math.floor(Math.random() * max) + min;
  randomNum3 = Math.floor(Math.random() * max) + min;
  label1.textContent = randomNum1;
  label2.textContent = randomNum2;
  label3.textContent = randomNum3;*/


/*myButton.onclick = function(){
    myButton = document.getElementById("myButton");
}*/

setTimeout(function(){
	document.querySelector('.notify-alert-box').style.top='0';
},1000)

document.querySelector('#notify-button').onclick = async () => {
	localStorage.setItem('notify','true')
	notifyTrue()
	//notifyOption()
}
function notifyTrue(){
	if(localStorage.getItem('notify','true')){
		document.querySelector('.notify-alert-box').style.display='none';
	}
}
notifyTrue()

document.querySelector('#notify-cancel-button').onclick = async () => {
	localStorage.setItem('notify','false')
	notifyFalse()	
}
function notifyFalse(){
	if(localStorage.getItem('notify','false')){
		document.querySelector('.notify-alert-box').style.display='none';
	}
}
notifyFalse()


function showNotification(){
	var notificationBody = new Notification('New Message from IT',{
		body:'Hi Google',
		//icon:'images/notify-logo.png',
	});
	notificationBody.onclick = (e) =>{
		window.location.href = 'https://google.com'
	}
}
function showNotification2(){
	var notificationBody = new Notification('New Message2 from IT',{
		body:'Hi Invention Tricks'
	});
	notificationBody.onclick = (e) =>{
		window.location.href = 'https://youtube.com'
	}  
}

//console.log(Notification.permission);
function notifyOption(){
	if(localStorage.notify == 'true'){
		const timestamp = new Date().getTime() + 5 * 1000;
		if(Notification.permission == "granted"){
			showNotification()
			if(localStorage.notifyMessage === undefined){
				localStorage.setItem('notifyMessage', timestamp)
				showNotification()
			}
			if(localStorage.notifyMessage2 === undefined){
				localStorage.setItem('notifyMessage2', timestamp)
				showNotification2()
			}
		}else if(Notification.permission !== "denied"){
			Notification.requestPermission().then(permission =>{
				//console.log(permisshion)
				if(permission == "granted"){
					showNotification()
					if(localStorage.notifyMessage === undefined){
						localStorage.setItem('notifyMessage', timestamp)
						showNotification()
					}
				}
			})
		}
  }
}
notifyOption()




