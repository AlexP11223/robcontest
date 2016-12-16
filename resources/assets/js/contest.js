require('./common');

$("#teamsBtn").click(function(){
    $("#teams").toggle();
});


function loadObstaclesResult() {
    $.get(`/contests/${contestId}/obstacles`, function (games) {
        const tbody = $("#obstaclesRoundTable").find("tbody");

        let tblBodyHtml = '<tr><th>Team</th><th>Time (sec)</th></tr>';

        let allCompleted = true;

        $.each(games, function(i, game) {
            if (!game.time) {
                allCompleted = false;
            }
            tblBodyHtml += `<tr><th>${game.team.name}</th><td>${game.time}</td></tr>`;
        });
        tbody.html(tblBodyHtml);

        if (allCompleted) {
            games.sort(function (a, b) {
                return a.time - b.time;
            });

            var winner1Tr = tbody.find('tr:contains(' + games[0].team.name + ')');

            winner1Tr.addClass('winner1-row');
            winner1Tr.find('th').append(' (1st)');

            var winner2Tr = tbody.find('tr:contains(' + games[1].team.name + ')');

            winner2Tr.addClass('winner2-row');
            winner2Tr.find('th').append(' (2nd)');

            var winner3Tr = tbody.find('tr:contains(' + games[2].team.name + ')');

            winner3Tr.addClass('winner3-row');
            winner3Tr.find('th').append(' (3rd)');
        }
    });
}

loadObstaclesResult();