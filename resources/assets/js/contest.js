require('./common');

require('jquery-bracket/dist/jquery.bracket.min.js');

$("#teamsBtn").click(function(){
    $("#teams").toggle();
});


function loadObstaclesResult() {
    $.get(`/contests/${contestId}/obstacles`, function (games) {
        if (!games)
            return;

        const tbody = $("#obstaclesRoundTable").find("tbody");

        let tblBodyHtml = '<tr><th>Team</th><th>Time (sec)</th></tr>';

        let allCompleted = true;

        $.each(games, function(i, game) {
            if (!game.time) {
                allCompleted = false;
            }
            tblBodyHtml += `<tr><th>${game.team.name}</th><td>${game.time ? game.time : ''}</td></tr>`;
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

function powerOf2(n) {
    return n && (n & (n - 1)) === 0;
}

function loadSumoResult() {
    $.get(`/contests/${contestId}/sumo`, function (games) {
        if (!games)
            return;

        let teams = [];
        let results = [];

        $.each(games, function(i, game) {
            if (game.round_index === 0) {
                teams.push([game.team1.name, game.team2 ? game.team2.name : null]);
            }

            if (!results[game.round_index]) {
                results[game.round_index] = [];
            }

            if (game.winner) {
                if (game.winner.name === game.team1.name) {
                    results[game.round_index].push([1, 0]);
                } else {
                    results[game.round_index].push([0, 1]);
                }
            } else {
                results[game.round_index].push([null, null]);
            }
        });

        while (!powerOf2(teams.length)) {
            teams.push([null, null]);
        }

        for (let i = 0; i < results.length; i++) {
            let round = results[i];

            while (!powerOf2(round.length)) {
                round.push([null, null]);
            }
        }

        $("#sumoTree").bracket({
            init: {'teams': teams, 'results': results},
            decorator: {
                render: function (container, data, score, state) {
                    switch (state) {
                        case "empty-bye":
                            container.append("No team");
                            return;
                        case "empty-tbd":
                            container.append("Upcoming");
                            return;
                        case "entry-no-score":
                        case "entry-default-win":
                        case "entry-complete":
                            container.append(data);
                            return;
                    }
                },
                edit: function (){}
            }
        });

        // TODO: ...
        $('div.score:contains("1")').text('+');
        $('div.score:contains("0")').text('−');
    });
}

loadObstaclesResult();
loadSumoResult();

module.exports = {
    loadObstaclesResult: loadObstaclesResult,
    loadSumoResult: loadSumoResult,
};
