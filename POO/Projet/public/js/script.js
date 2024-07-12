//-------------------------------Connexion--------------------------------------------
const wrapper = document.querySelector(".wrapper");
const loginLink = document.querySelector(".login-link");
const registerLink = document.querySelector(".register-link");
const btnPopup = document.querySelector(".btnLogin-popup");
const iconeClose = document.querySelector(".icon-close");
const small1 = document.querySelector("#t1");
const small2 = document.querySelector("#t2");
const small3 = document.querySelector("#t3");


registerLink.addEventListener("click", () => {
  wrapper.classList.add("active");
});

loginLink.addEventListener("click", () => {
  wrapper.classList.remove("active");
});

btnPopup.addEventListener("click", () => {
  wrapper.classList.add("active-popup");
});

iconeClose.addEventListener("click", () => {
  wrapper.classList.remove("active-popup");
});



function showFormLogin(){
  console.log([small1.innerText, small2.innerText, small3.innerText]);

  if (small1.innerText != ""){
    wrapper.classList.add("active-popup");
  }else if(small2.innerText != ""){
    wrapper.classList.add("active-popup");
  } else if (small3.innerText != ""){
    wrapper.classList.add("active-popup");
  }
}

showFormLogin();

//--------------------------------------------------------------------------------------