(()=>{"use strict";var e={};e.g=function(){if("object"==typeof globalThis)return globalThis;try{return this||new Function("return this")()}catch(e){if("object"==typeof window)return window}}(),e.g.toggleFoldContent=function(e){let t=document.querySelector(e);t.classList.contains("active")?t.classList.remove("active"):t.classList.add("active")},"serviceWorker"in navigator&&window.addEventListener("load",(function(){navigator.serviceWorker.register("/ServiceWorker.js").then((function(e){console.log("ServiceWorker registration successful with scope: ",e.scope)}),(function(e){console.log("ServiceWorker registration failed: ",e)}))})),e.g.addLoadingIcon=function(e){e.innerHTML+="<div class='loader-wrapper'><div class='loader'></div></div>"},e.g.removeLoadingIcon=function(e){e.querySelector(".loader-wrapper").remove()},e.g.reindex=function(){const e=new XMLHttpRequest;e.open("GET","/search"),e.send(),e.onreadystatechange=function(){if(4===e.readyState&&200===e.status){let t={};try{t=JSON.parse(e.responseText)}catch(e){return void console.log(e)}alert(t.message)}}}})();