"use strict";

function fillThreads()
{
    $.get("php/messages.php", function(data)
    {
        var threadsdiv = document.getElementById("allthreads");
        var html = "";
        var threads = data; //maybe this needs parsing on uni computers?
        console.log(threads);
        if(threads.length == 0) html = "No messages to display!";
        else
        {
            for(var i = 0; i < threads.length; i++)
            {
                var thread = threads[i];
                html += '<div class="card" onclick="openMessage(\''
                    + thread["fromname"]
                    + '\')"><div class="card-block"><div class="col-sm-3"><img src="avatar/test.png"/><p class="threadname">'
                    + thread["fromname"]
                    + '</p></div><div class="col-sm-9"><div class="card card-block"><p class="messagepreview">'
                    + thread["text"]
                    + '<p class = "messagetime">'
                    + thread["time"]
                    + '</p></div></div>';

                html += '<div class="card"><div class="card-block"><h2>'
                    + thread["fromname"]
                    + '</h2></div></div>';
            }
        }
        threadsdiv.innerHTML = html;
    });
}

function openMessage(threadname)
{
    console.log(threadname);
    document.location.href = "messagethread.php?threadname=" + threadname;
}

function testData()
{
    var threadsdiv = document.getElementById("allthreads");
    var html = '<div class="card" onclick="openMessage(\'FoodieDave\')"><div class="card-block"><div class="col-sm-3"><img src="avatar/test.png"/><p class="threadname">'
            + "FoodieDave"
            + '</p></div><div class="col-sm-9"><div class="card"><div class="card-block"><p class = "messagepreview">'
            + "hello its foodiedave"
            + '<p class = "messagetime">'
            + "12:34"
            + '</p></div></div></div>'
        ;
    threadsdiv.innerHTML = html;
}