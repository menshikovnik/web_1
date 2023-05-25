const lastVisit = getCookie("lastVisit");
if (lastVisit) {
    // Декодируем значение lastVisit
    const lastVisitDecoded = decodeURIComponent(lastVisit);
    // Выводим на экран
    document.write("Последний раз вы посещали эту страницу: " + lastVisitDecoded);
} else {
    // Если нет, устанавливаем новую cookie
    const currentDateTime = new Date().toString();
    setCookie("lastVisit", currentDateTime, 365);
}

function like() {
    let count = parseInt(document.getElementById("like-count").textContent);
    count++;
    document.getElementById("like-count").textContent = count.toString();
    saveLikeCount(count);
    setCookie('likes', count, 1);
}

window.onload = function () {
    let likes = getCookie("likes");
    if (likes) {
        document.getElementById("like-count").textContent = likes;
    }
};

function zoom() {
    const img = document.getElementById("myImage");
    if (img.style.width === "100%") {
        img.style.width = "initial";
    } else {
        img.style.width = "100%";
    }
}