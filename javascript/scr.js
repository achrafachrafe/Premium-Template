/*====================
LOADER
====================*/

window.addEventListener("load",()=>{

setTimeout(()=>{

document.getElementById("loader").style.display="none";

},1000);

});

/*====================
CURSOR
====================*/

const cursor=document.querySelector(".cursor");

document.addEventListener("mousemove",(e)=>{

cursor.style.left=e.clientX+"px";
cursor.style.top=e.clientY+"px";

});

/*====================
TYPING
====================*/



/*====================
REVEAL
====================*/

const reveals=document.querySelectorAll(".reveal");

window.addEventListener("scroll",()=>{

reveals.forEach(el=>{

let top=el.getBoundingClientRect().top;

if(top<window.innerHeight-100){

el.classList.add("active");

}

});

});
/*====================
PARTICLES
====================*/

tsParticles.load("tsparticles",{

particles:{

number:{
value:70
},

size:{
value:2
},

move:{
enable:true,
speed:1
},

links:{
enable:true,
distance:150,
opacity:.3
}

}

});

/*====================
VANILLA TILT
====================*/

VanillaTilt.init(

document.querySelectorAll(".glass"),

{

max:10,

speed:400,

glare:true,

"max-glare":0.3

}

);

/*====================
BUTTON EFFECT
====================*/

const btn=document.querySelector(".btn");

if(btn){

btn.addEventListener("mousemove",(e)=>{

const rect=btn.getBoundingClientRect();

const x=e.clientX-rect.left-rect.width/2;

const y=e.clientY-rect.top-rect.height/2;

btn.style.transform=

`translate(${x*0.15}px,${y*0.15}px)`;

});

btn.addEventListener("mouseleave",()=>{

btn.style.transform="translate(0,0)";

});

}

/*====================
SCROLL TO TOP
====================*/

const scrollTopBtn=document.getElementById("scrollTop");

window.addEventListener("scroll",()=>{

if(scrollTopBtn){

if(window.scrollY>400){

scrollTopBtn.style.display="block";

}else{

scrollTopBtn.style.display="none";

}

}

});

if(scrollTopBtn){

scrollTopBtn.addEventListener("click",()=>{

window.scrollTo({

top:0,

behavior:"smooth"

});

});

}

/*====================
TOAST
====================*/

function showToast(){

const toast=document.getElementById("toast");

if(!toast) return;

toast.classList.add("show");

setTimeout(()=>{

toast.classList.remove("show");

},3000);

}

/*====================
IMAGE HOVER
====================*/

document.querySelectorAll(".gallery-item img").forEach(img=>{

img.addEventListener("mouseenter",()=>{

img.style.transform="scale(1.1)";

});

img.addEventListener("mouseleave",()=>{

img.style.transform="scale(1)";

});

});

