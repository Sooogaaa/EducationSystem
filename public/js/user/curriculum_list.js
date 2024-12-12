// const { Button } = require("bootstrap");

let currentMonth = new Date();
let allExpired = true;
let gradeId = 1;

let gradeNames = {
    1: "小学校1年生",
    2: "小学校2年生",
    3: "小学校3年生",
    4: "小学校4年生",
    5: "小学校5年生",
    6: "小学校6年生",
    7: "中学校1年生",
    8: "中学校2年生",
    9: "中学校3年生",
    10: "高校1年生",
    11: "高校2年生",
    12: "高校3年生",
};

function goToPrevMonth() {
    currentMonth.setMonth(currentMonth.getMonth() - 1);
    updateDisplay();
}

function goToNextMonth() {
    currentMonth.setMonth(currentMonth.getMonth() + 1);
    updateDisplay();
}

function updateDisplay() {
    let monthDisplay = document.getElementById("monthDisplay");
    let year = currentMonth.getFullYear();
    let month = String(currentMonth.getMonth() + 1).padStart(2, "0");
    let monthKey = `${year}-${month}`;

    monthDisplay.innerText = `${year}年${month}月スケジュール`;

    fetchSchedule(monthKey, gradeId);
}

// 月・学年の取得
function fetchSchedule(month, grade) {
    console.log(`Requesting schedule for: ${month} for grade: ${grade}`); // ブラウザコンソールに出力
    fetch(`/EducationSystem/public/user/schedules/${month}/${grade}`) // 指定されたURLへ時間割情報取得
        .then((response) => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            return response.json();
        })
        // 取得した時間割情報を受け取る
        .then((data) => {
            displaySchedule(data);
        })
        .catch((error) => {
            console.error("Fetch error:", error);
        });
}

// 選択中の学年を表示する
document.addEventListener("DOMContentLoaded", function () {
    let gradeId = 1;
    updateDisplay();
    document.getElementById("currentGradeDisplay").innerText =
        gradeNames[gradeId];
    selectGrade(gradeId);
});

function selectGrade(selectGradeId) {
    gradeId = selectGradeId;
    let currentGradeDisplay = document.getElementById("currentGradeDisplay");
    currentGradeDisplay.innerText = gradeNames[gradeId];

    let buttons = document.querySelectorAll(".grade button");
    buttons.forEach((button) => {
        button.classList.remove("selected");
    });

    const selectedButton = [...buttons].find((button) =>
        button.innerText.includes(gradeNames[gradeId])
    );
    if (selectedButton) {
        selectedButton.classList.add("selected"); // 該当ボタンにselectedクラスを追加し、選択状態を表す
    }

    // YYYY-MM形式で現在の年月を取得
    let month =
        currentMonth.getFullYear() +
        "-" +
        String(currentMonth.getMonth() + 1).padStart(2, "0");
    fetchSchedule(month, gradeId);
}

function displaySchedule(schedules) {
    let scheduleContent = getElementById("scheduleContent");
    scheduleContent.innerHTML = ""; // 既存内容をクリアにする

    if (!Array.isArray(schedules)) {
        if (schedules.message) {
            scheduleContent.innerHTML = `<p>${schedules.message}</p>`;
        } else {
            scheduleContent.innerHTML = "<p>不明なエラーが発生しました。</p>";
        }
        return;
    }

    if (schedules.length === 0) {
        scheduleContent.innerHTML = "<p>スケジュールがありません。</p>";
        return;
    }

    // スケジュールのグループ化
    let groupedSchedules = schedules.reduce((acc, item) => {
        if (!acc[item.date]) {
            acc[item.date] = []; // 初期値は空のオブジェクトを与える
        }
        acc[item.date].push(item);
        return acc;
    }, {});

    //サムネイルとタイトルを作成
    for (let date in groupedSchedules) {
        let schedule = document.createElement("div");
        schedule.className = "video";
        schedule.innerHTML = `<img src="${groupedSchedules[date][0].thumbnail}" alt="動画サムネイル">`;

        let title = document.createElement("a");
        title.className = "curriculum_title";
        title.innerText = groupedSchedules[date][0].title;
        title.href = "#";
        title.onclick = (e) => {
            e.preventDefault();
        };

        schedule.appendChild(title);

        // 時間ごとのリストを作成
        let list = document.createElement("ul");
        let hasValidSchedule = false;
        allExpired = true;

        groupedSchedules[date].forEach((item) => {
            let listItem = document.createElement("li");
            listItem.innerHTML = `${item.date} ${item.time}`;

            if (item.alway_delivery_flg === 0 && item.isExpired) {
                listItem.innerHTML +=
                    '<span class="expired">配信期限が過ぎました</span>';
            } else {
                hasValidSchedule = true;
            }
            list.appendChild(listItem);
        });

        if (
            hasValidSchedule ||
            groupedSchedules[date].some((item) => item.alway_delivery_flg === 1)
        ) {
            allExpired = false;
        }

        schedule.appendChild(list); //作成したスケジュールリストをschedule要素に追加
        scheduleContent.appendChild(schedule); //完成したschedule要素をscheduleContentに追加
    }

    // 全て期限切れの場合
    if (allExpired) {
        let expiredMessage = document.createElement("p");
        expiredMessage.innerText = "配信期限が過ぎました。";
        scheduleContent.innerHTML = "";
        scheduleContent.appendChild(expiredMessage);
    }
}
