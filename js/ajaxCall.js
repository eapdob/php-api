document.addEventListener('DOMContentLoaded', function () {
    // Post request
    $('#postMessage').click(function (e) {
        e.preventDefault();

        // serialize form data
        let url = $('form').serialize();

        // function to turn url to an object
        function getUrlVars(url) {
            let hash;
            let myJson = {};
            let hashes = url.slice(url.indexOf('?') + 1).split('&');
            for (let i = 0; i < hashes.length; i++) {
                hash = hashes[i].split('=');
                myJson[hash[0]] = hash[1];
            }
            return JSON.stringify(myJson);
        }

        // pass serialized data to function
        let data = getUrlVars(url);

        //post with ajax
        $.ajax({
            type: "POST",
            url: "/api/post/create.php",
            data: data,
            ContentType: "application/json",
            success: function () {
                alert('successfully posted');
            },
            error: function () {
                alert('Could not be posted');
            }
        });
    });

    // Get request
    document.getElementById('getMessage').onclick = function () {
        let req;
        req = new XMLHttpRequest();
        req.open("GET", '/api/post/read.php', true);
        req.send();

        req.onload = function () {
            let json = JSON.parse(req.responseText);

            // limit data called
            let data = json.filter(function (val) {
                return (val.id >= 4);
            });

            let html = "";

            //loop and display data
            data.forEach(function (val) {
                let keys = Object.keys(val);

                html += "<div class = 'cat'>";
                keys.forEach(function (key) {
                    html += "<strong>" + key + "</strong>: " + val[key] + "<br>";
                });
                html += "</div><br>";
            });

            //append in message class
            document.getElementsByClassName('message')[0].innerHTML = html;
        };
    };
});
  
