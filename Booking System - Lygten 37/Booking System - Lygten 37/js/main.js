$('.userTd').hover(function() {
    $(this).css('color', 'black');
}, function() {
    $('.userTd').css('color', 'white');
});


//Check if any change on live booking form, and sends the value to the function showRoom
$("#bookingForm").change(function() {
    $persons = $("#persons").val();
    $date = $("#datetimepicker").val();
    $st = $("#datetimepicker3").val();
    $et = $("#datetimepicker2").val();

    showRoom($persons, $date, $st, $et);
});

//Live check if room is available, sends data with JSON and back as a string you parse and run through a loop to get data.
function showRoom(persons, date, starttime, endtime) {
    $.post("getRoom.php", {"persons": persons, "date": date, "starttime": starttime, "endtime": endtime}, function(data) {
        var result = JSON.parse(data);
        $("#txtRoom").empty();
        for (var i = 0; i < result.length; i++) {
            var roomname = result[i].roomname;
            var amountofPeople = result[i].persons;
            var imgURL = result[i].imgRoom;
            var resultID = result[i].id;

            if (result[i].projector == 1) {
                var isThereProjector = "<span class=\"glyphicon glyphicon-facetime-video glyph-custom pull-left\"></span >";
            }
            if (result[i].projector == 0) {
                var isThereProjector = "";
            }
            if (result[i].roomstatus == 0) {
                var RoomStatus = "Status: Unavailable at the moment";
                var btnDisabled = "disabled";
            }
            if (result[i].roomstatus == 1) {
                var RoomStatus = "Status: Under construction";
                var btnDisabled = "disabled";
            }
            if (result[i].roomstatus == 2) {
                var RoomStatus = "";
                var btnDisabled = "";
            }
            $("#txtRoom").append('<div class="roomStyle"><div class="pull-left black-ops"><div class="imgClass pull-left"><img src=' + imgURL + '></div><div class="pull-left w50"><p class="white">' + roomname + '</p><span class="white">' + RoomStatus + '</span><span class="abbottom"><span class="glyphicon glyphicon-user glyph-custom pull-left"></span><span class="white pull-left">' + amountofPeople + '</span>' + isThereProjector + '<button id=' + resultID + ' name="submitbutton" class="customBtnTwo btn btn-success pull-left custom-bookbtn bookRoom" '+btnDisabled+'>Book now</button></span></div></div></div>');
        }
    });
}

//Change size on input box when getting result if user is already there or not.
$(".usernameInput").blur(function() {
    $(".usernameInput").css('width', '80%');
    $("#txtHint").delay("400").fadeIn();
});

//Date datepicker
$('#datetimepicker').datetimepicker({
    lang: 'en',
    i18n: {
        en: {
            months: [
                'Januar', 'February', 'Marts', 'April',
                'May', 'June', 'July', 'August',
                'September', 'October', 'November', 'December',
            ],
            dayOfWeek: [
                "Sun", "Mon", "Thu", "Wed",
                "Thur", "Fri", "Sat",
            ]
        }
    },
    timepicker: false,
    format: 'd.m.Y'
});

//First timepicker
$('#datetimepicker2').datetimepicker({
    allowTimes: [
        '08:00', '09:00', '10:00',
        '11:00', '12:00', '13:00', '14:00', '15:00'
    ],
    datepicker: false,
    format: 'H:i'
});

//Second timepicker
$('#datetimepicker3').datetimepicker({
    allowTimes: [
        '08:00', '09:00', '10:00',
        '11:00', '12:00', '13:00', '14:00', '15:00'
    ],
    datepicker: false,
    format: 'H:i'
});

//Click on button .bookRoom, which is created at line 44 - get info with ajax and JSON and open a modal with that info. 
$(document).on("click", ".bookRoom", function() {
    $ID = $(this).attr('id');
    $date = $('#datetimepicker').val();
    $start_time = $('#datetimepicker3').val();
    $end_time = $('#datetimepicker2').val();

    $.post("confirmationBooking.php", {"id": $ID, "start_time": $start_time, "end_time": $end_time, "date": $date}, function(data) {
        console.log(data);
        var result = JSON.parse(data);
        $('#confirmation').modal('show');
        for (var i = 0; i < result.length; i++) {
            var roomname = result[i].roomname;
            $(".confirmationClass").append('<p class="marginbottom20"><b>Room Name:</b> ' + roomname + '</p><p class="marginbottom20"><b>The:</b> ' + $date + '</p><p class="marginbottom20"><b> From: </b>' + $start_time + ' <b>To</b> ' + $end_time + '</p><button id='+ $ID +' class="marginbottom20 bookMenNow btn btn-success">Book room</button>');
        }
    });
});

//.bookMenNow is created at line 108 and submits the form with all the booking data.
$(document).on("click", ".bookMenNow", function() {
    $('#roomID').val($('.bookMenNow').attr('id'));
    $('#bookingForm').submit();
});

//Empties the confirmation modal everytime you close and open.
$(document).on("click", ".empty", function() {
$('.confirmationClass').empty();
});

//Fetch the ID to the delete modal
$(document).on("click", ".deleteButton", function() {
    $("#btnDelete").prop("href", "?action=deleteRoom&id=" + $(this).attr("id"));
});

//Gets all the info of the room through XML.
$(document).on("click", ".btnInfo", function() {
    var idInfo = $(this).attr("id");
    $.post("getInfo.php", {"id": idInfo}, function(data) {
        $(".infoHere").empty();
        $(".editInfo").empty();
        id = $(data).find('id').text();
        roomname = $(data).find('roomname').text();
        persons = $(data).find('persons').text();
        projector = $(data).find('projector').text();
        imgRoom = $(data).find('imgRoom').text();
        roomstatus = $(data).find('roomstatus').text();

        if (projector == 1) {
            $showprojector = "Projector: Yes";
        }
        if (projector == 0) {
            $showprojector = "Projector: No";
        }
        if (roomstatus == 1) {
            $statusName = 'Under construction';
        }
        if (roomstatus == 0) {
            $statusName = 'Unavailable at the moment';
        }
        if (roomstatus == 2) {
            $statusName = "";
        }
        $('#hiddenID').val(id);
        $('.infoHere').append('<div class="gotInfo"><div class="pull-left infoImgClass marginbottom20"><img src=' + imgRoom + '></div><div class="row"><h4>' + roomname + '</h4><span>The room can contain<pan> ' + persons + ' persons <div>' + $showprojector + '</div><div>' + $statusName + '</div><button class="btn btn-info" data-toggle="modal" data-target="#editRoom">Edit room info</button></div></div>');
        $('.editInfo').append('<form action="?action=editRoomInfo" method="post"><input name="ID" type="hidden" value="'+id+'"></span>Room Name</span><input name="editName" class="form-control marginbottom20" type="text" value="'+roomname+'"><span>Persons</span><select class="form-control marginbottom20" name="editPersons"><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option></select><span>Projector?</span><select class="form-control marginbottom20" name="editProjector"><option value="1">Yes</option><option value="0">No</option></select><span>Room status</span><select class="form-control marginbottom20" name="editStatus"><option value="2">Ready</option><option value="1">Under construction</option><option value="0">Unavailable at the moment</option></select><button class="btn btn-success">Done</button></form>');
    });
});

//Gets all the comments trough ajax and JSON
$(document).on("click", ".btnInfo", function() {
    var idInfo = $(this).attr("id");

    $.post("getComments.php", {"id": idInfo}, function(data) {
        var showComments = JSON.parse(data);
        //console.log(showComments);
        $("#placeComments").empty();
        for (var i = 0; i < showComments.length; i++) {
            var allComments = showComments[i].comment;
            var commentsId = showComments[i].id;
            $('#placeComments').append('<tr class="styleComments"><td><a href="?action=deleteComment&id=' + commentsId + '" type="submit" class="deleteBtn">X</a></td><td>' + allComments + '</td></tr>');
        }
    });
});

//Same as line 130
$(document).on("click", ".btnInfoUser", function() {
    var idInfo = $(this).attr("id");
    $.post("getInfo.php", {"id": idInfo}, function(data) {
        $(".infoHereUser").empty();

        id = $(data).find('id').text();
        roomname = $(data).find('roomname').text();
        persons = $(data).find('persons').text();
        projector = $(data).find('projector').text();
        imgRoom = $(data).find('imgRoom').text();
        roomstatus = $(data).find('roomstatus').text();

        if (projector == 1) {
            $showprojector = "Projector: Yes";
        }
        if (projector == 0) {
            $showprojector = "Projector: No";
        }
        if (roomstatus == 0) {
            $statusName = "Unavailable at the moment";
        }
        if (roomstatus == 1) {
            $statusName = "Under construction";
        }
        if (roomstatus == 2) {
            $statusName = "";
        }
        $('#hiddenID').val(id);
        $('.infoHereUser').append('<div class="gotInfo"><div class="pull-left infoImgClass marginbottom20"><img src=' + imgRoom + '></div><div class="row"><h4>' + roomname + '</h4><p>The room can contain ' + persons + ' persons<br>' + $showprojector + '<br>' + $statusName + '<br><br></p></div></div>');
    });
});

//same as line 162
$(document).on("click", ".btnInfoUser", function() {
    var idInfo = $(this).attr("id");

    $.post("getComments.php", {"id": idInfo}, function(data) {
        var showComments = JSON.parse(data);
        //console.log(showComments);
        $("#placeCommentsUser").empty();
        for (var i = 0; i < showComments.length; i++) {
            var allComments = showComments[i].comment;
            $('#placeCommentsUser').append('<div class="styleComments">' + allComments + '</div>');
        }
    });
});

//Shows all bookings from a view
$(document).on("click", ".allBookings", function() {
    $.post("getAllBookings.php", function(data) {
        var showAllBookings = JSON.parse(data);
        $("#placeAllBookings").empty();
        for (var i = 0; i < showAllBookings.length; i++) {
            var roomname = showAllBookings[i].roomname;
            var useremail = showAllBookings[i].email;
            var start = showAllBookings[i].start_time;
            var end = showAllBookings[i].end_time;
            var date = showAllBookings[i].date;
            $("#placeAllBookings").append('<tr class="black"><td>' + useremail + '</td><td>' + roomname + '</td><td>' + start + '</td><td>' + end + '</td><td>' + date + '</td></tr>');
        }
    });
});



