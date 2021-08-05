$(document).ready(function() {

    var open = false;

    //only want to toggle if search box is empty
    // code is copied for thise two functions because I gave up trying to figure out how to make my own named functions in jquery
    $('.search-button').click(function() {

        var sInput = $("#videoSearch").val();

        if (sInput.length > 0) {
            processSearch(sInput);

        } else if (!open) {
            $(this).parent().toggleClass('open');
            open = true;
        } else if (open) {
            $(this).parent().toggleClass('open');
            open = false;
        }

    });

    //handle enter press
    $("#videoSearch").keyup(function(event) {
        if (event.which == 13) {

            var sInput = $("#videoSearch").val();

            if (sInput.length > 0) {
                processSearch(sInput);

            } else if (!open) {
                $(this).parent().toggleClass('open');
                open = true;
            } else if (open) {
                $(this).parent().toggleClass('open');
                open = false;
            }

        }
    });

});






// Handles logic for what in inputted in seach bar
function processSearch(searchInput) {

    var searchInput = document.getElementById('videoSearch').value;
    document.getElementById('videoSearch').value = "";
    document.location = 'search.php?SearchPhrase=' + searchInput;
    //  displayResults(searchInput);

}

function displayResults(SearchPhrase) {

    document.getElementById('vidResultsTitle').innerHTML = "Showing Results For " + SearchPhrase;
    document.getElementById('vidResultsTitle').style.borderBottom = "2px solid rgba(15, 15, 15, 0.2)";
}

function Video(vName, vTime, vThumbnail, vAuthor, vSource, VCategory) {

    this.name = vName;
    this.runtime = vTime;
    this.thumbnail = vThumbnail;
    this.author = vAuthor;
    this.source = vSource;
    this.category = VCategory;

}

//sets the html attributes for the li, passed the test value, and the html element

function setAttributes(innerVal, element, attributes) {

    var text = document.createTextNode(innerVal);
    element.appendChild(text);

    for (var key in attributes) {
        element.setAttribute(key, attributes[key]);
    }

}

// creates the list dynamically

function createResults(numResults) {
    // each video will probably be passed a some sort of json object so would need to parse it that way
    var titles = ["Art 201 Tutorial", "Art 300 Review", "Art 200 Chaper 1 Questions"];
    var authors = ["Created by John Doe", "Created by Jane Doe", "Created by John Jane"];
    var ratings = ["4.4", "3.7", "2.5"];

    var ul = document.getElementById("videoResults");

    for (let i = 0; i < numResults; i++) {

        var listItem = document.createElement("li");
        var vidTitle = document.createElement("h3");
        var vidDesc = document.createElement("p");
        var vidRating = document.createElement("div");

        setAttributes(titles[i], vidTitle, { "class": "videoTitle" });
        setAttributes(authors[i], vidDesc, { "class": "vidDescription" });
        setAttributes("", vidRating, { "class": "Stars", "style": "--rating: " + ratings[i] });


        listItem.appendChild(vidTitle);
        listItem.appendChild(vidDesc);
        listItem.appendChild(vidRating);
        ul.appendChild(listItem);

    }

}