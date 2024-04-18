const btnVote = document.querySelector("#btn-vote");
btnVote.addEventListener("click", () => {
  const responseId = btnVote.getAttribute("data-id");
  const url = "/like/" + responseId;
  fetch(url)
    .then((response) => {
      if (!response.ok) {
        throw new Error("Erreur de réseau : " + response.status);
      }
      return response.json();
    })
    .then((data) => {
      console.log(data);
    })
    .catch((error) => {
      console.error("Erreur lors de la requête :", error);
    });
});
