console.log("JavaScript works.......");const o=document.getElementById("login-modal"),i=document.getElementById("register-form"),c=document.getElementById("login-link"),d=document.getElementById("close-modal"),m=document.getElementById("close-register-modal"),u=document.getElementById("login-button"),p=document.getElementById("sign-up-link"),y=document.getElementById("already-have-account-link");function a(e,s){for(const[l,n]of Object.entries(e)){const t=s.querySelector(`[name="${l}"]`);if(t){let r=t.nextElementSibling;(!r||!r.classList.contains("error-login"))&&(r=document.createElement("p"),r.className="error-login",t.insertAdjacentElement("afterend",r)),r.textContent=n}}}c.addEventListener("click",function(e){e.preventDefault(),this.classList.contains("loginSucces")?window.location.href="index.php?action=logout":o.style.display="block"});p.addEventListener("click",function(e){e.preventDefault(),o.style.display="none",i.style.display="block"});d.addEventListener("click",function(){o.style.display="none"});m.addEventListener("click",function(){i.style.display="none"});window.addEventListener("click",function(e){e.target===o?o.style.display="none":e.target===i&&(i.style.display="none")});u.addEventListener("click",function(e){e.preventDefault();const s=document.getElementById("inputmail").value.trim(),l=document.getElementById("inputpass").value.trim();if(!s||!l){alert("Please fill in both email and password.");return}fetch("index.php?action=login",{method:"POST",headers:{"Content-Type":"application/x-www-form-urlencoded"},credentials:"same-origin",body:`inputmail=${encodeURIComponent(s)}&inputpass=${encodeURIComponent(l)}`}).then(n=>n.json()).then(n=>{n.success?(o.style.display="none",c.classList.replace("login","loginSucces"),c.textContent="Logout",window.location.reload()):a(n.errors,o.querySelector("form"))}).catch(n=>{console.error("Login failed:",n),alert("An error occurred. Please try again.")})});i.querySelector("form").addEventListener("submit",function(e){e.preventDefault();const s=document.getElementById("inputmail-register").value.trim(),l=document.getElementById("inputpass-register").value.trim(),n=document.getElementById("inputpass-confirm-register").value.trim();if(!s||!l||!n){alert("Please fill in all fields.");return}if(l!==n){alert("Passwords do not match.");return}fetch("index.php?action=register",{method:"POST",headers:{"Content-Type":"application/x-www-form-urlencoded"},credentials:"same-origin",body:`inputmail=${encodeURIComponent(s)}&inputpass=${encodeURIComponent(l)}`}).then(t=>t.json()).then(t=>{t.success?(i.style.display="none",o.style.display="block"):a(t.errors,i.querySelector("form"))}).catch(t=>{console.error("Registration failed:",t),alert("An error occurred. Please try again.")})});y.addEventListener("click",function(e){e.preventDefault(),i.style.display="none",o.style.display="block"});
