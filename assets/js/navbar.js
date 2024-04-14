export function createBurgerMenu() {
  const headerTarget = document.querySelector("#header");

  const divMenuBurgerContainer = document.createElement("div");
  divMenuBurgerContainer.classList.add("menu-burger-container");

  const XIcon = document.createElement("i");
  XIcon.classList.add("fa-solid", "fa-xmark", "fa-2xl");
  XIcon.addEventListener("click", () => {
    divMenuBurgerContainer.remove();
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

  ulCreate.append(liHome, liThread);
  menuMobileContainer.append(ulCreate);
  divMenuBurgerContainer.append(XIcon, menuMobileContainer);

  const btnBurger = document.querySelector("#burger-menu");
  btnBurger.addEventListener("click", () => {
    headerTarget.prepend(divMenuBurgerContainer);
  });
}

export function profilContainer() {
  const profilContainer = document.querySelector("#profil-container");
  const allBtnProfil = document.querySelectorAll(".fa-user");
  let arrayBtnProfil = [];
  arrayBtnProfil = [...allBtnProfil];
  arrayBtnProfil.forEach((btnProfil) => {
    btnProfil.addEventListener("click", () => {
      const display = window.getComputedStyle(profilContainer).display;
      if (display === "none") {
        profilContainer.style.display = "block";
      } else if (display === "block") {
        profilContainer.style.display = "none";
      }
    });
  });
}
