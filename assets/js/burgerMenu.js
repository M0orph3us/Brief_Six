export function burgerMenu() {
  const headerTarget = document.querySelector("#header");

  const divMenuBurgerContainer = document.createElement("div");
  divMenuBurgerContainer.classList.add("menu-burger-container");

  const XIcon = document.createElement("i");
  XIcon.classList.add("fa-solid", "fa-xmark", "fa-2xl");
  XIcon.addEventListener("click", () => {
    divMenuBurgerContainer.remove();
    // divMenuBurgerContainer.style.animationName = "RightToLeft";
    // divMenuBurgerContainer.style.animationDuration = "0.5s";
    // divMenuBurgerContainer.style.animationTimingFunction = "ease-in";
    // setTimeout(() => {
    //   headerTarget.removeChild(divMenuBurgerContainer);
    // }, 499);
  });

  const menuMobileContainer = document.createElement("div");
  menuMobileContainer.classList.add("menu-mobile-container");

  const ulCreate = document.createElement("ul");

  const urlHome = document.querySelector("#url-home").getAttribute("data-url");
  const liHome = document.createElement("li");
  const aHome = document.createElement("a");
  aHome.href = urlHome;
  aHome.textContent = "home";
  liHome.append(aHome);

  const urlCreateThread = document
    .querySelector("#url-createdThread")
    .getAttribute("data-url");
  const liThread = document.createElement("li");
  const aThread = document.createElement("a");
  // aThread.href = urlCreateThread;
  aThread.textContent = "create thread";
  liThread.append(aThread);

  // const liProfil = document.createElement("li");
  // const aProfil = document.createElement("a");
  // aProfil.href = "";
  // aProfil.textContent = "profil";
  // liProfil.append(aProfil);

  // const liLogout = document.createElement("li");
  // const aLogout = document.createElement("a");
  // aLogout.href = "";
  // aLogout.textContent = "logout";
  // liLogout.append(aLogout);

  ulCreate.append(liHome, liThread);
  menuMobileContainer.append(ulCreate);
  divMenuBurgerContainer.append(XIcon, menuMobileContainer);

  const btnBurger = document.querySelector("#burger-menu");
  btnBurger.addEventListener("click", () => {
    headerTarget.prepend(divMenuBurgerContainer);
  });
}
