$(document).ready(function () {
	// Live Clock
	var clockElement = $("#currentDate")[0];

	function clock() {
		clockElement.innerHTML = new Date().toLocaleString("en-US");
	}

	setInterval(clock, 1000);

	// Setting SideBar to have same height as content
	var contentHeight = $(".content").height();
	$("#navAccordion").height(contentHeight);

	// Changing page theme
	document.getElementById("redColor").onclick = function () {
		document.documentElement.style.setProperty("--pageColor", "#e2461f");
	};

	document.getElementById("blueColor").onclick = function () {
		document.documentElement.style.setProperty("--pageColor", "#1d4ec1");
	};

	document.getElementById("greenColor").onclick = function () {
		document.documentElement.style.setProperty("--pageColor", "green");
	};

	// Navigating to home page
	document.getElementById("homeButton").onclick = function () {
		location.href = "../../index.php";
		document.getElementById("homeButton").style.setProperty("display", "none");
	};

	if (
		location.pathname != "/index.php" &&
		location.pathname != "/~ics325sp2409/index.php"
	) {
		console.log(location.pathname);
		var urlSplit = location.pathname.split("/");
		var newPage = urlSplit[urlSplit.length - 2];
		document.getElementById("homeButton").style.setProperty("display", "block");
		document.getElementsByTagName("title")[0].innerHTML =
			"Ayodele Olufemi - " + newPage;
		document.getElementsByClassName("subtitle")[0].innerHTML = newPage;
		if (document.getElementById("folderName") != null) {
			document.getElementById("folderName").innerHTML = newPage;
		}
	}
});
