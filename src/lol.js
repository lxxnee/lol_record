function searchSummoner() {
  var summonerName = document.getElementById("summonerName").value;
  var url =
    "https://kr.api.riotgames.com/lol/summoner/v3/summoners/by-name/" +
    encodeURIComponent(summonerName) +
    "?api_key=RGAPI-26ab054c-a852-4501-b04e-e542f8f0a626";

  fetch(url)
    .then((response) => {
      if (!response.ok) {
        throw new Error("API 요청에 실패했습니다.");
      }
      // JSON 형식으로 응답 처리
      return response.json();
    })
    .then((data) => {
      var summonerInfo = document.getElementById("summonerInfo");
      summonerInfo.innerHTML = ""; // 이전 결과를 지우고 새로운 결과를 표시
      summonerInfo.classList.add("summoner-info"); // 클래스 추가
      if (data.id) {
        summonerInfo.innerHTML += "<p>소환사 이름: " + data.name + "</p>";
        summonerInfo.innerHTML +=
          "<p>소환사 레벨: " + data.summonerLevel + "</p>";
      } else {
        summonerInfo.innerHTML += "<p>소환사 정보를 찾을 수 없습니다.</p>";
        summonerInfo.classList.add("error"); // 클래스 추가
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      var summonerInfo = document.getElementById("summonerInfo");
      summonerInfo.innerHTML =
        "<p>소환사 정보를 가져오는 동안 오류가 발생했습니다.</p>";
      summonerInfo.classList.add("error"); // 클래스 추가
    });
  return false;
}
