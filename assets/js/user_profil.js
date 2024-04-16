const myThreadsContainer = document.querySelector("#my-threads-container");

const myResponsesContainer = document.querySelector("#my-responses-container");
const btnAllThreads = document.querySelector("#btn-all-threads");
btnAllThreads.addEventListener("click", () => {
  myResponsesContainer.style.display = "none";
  myThreadsContainer.style.display = "flex";
});

const btnAllResponses = document.querySelector("#btn-all-responses");
btnAllResponses.addEventListener("click", () => {
  myThreadsContainer.style.display = "none";
  myResponsesContainer.style.display = "flex";
});
