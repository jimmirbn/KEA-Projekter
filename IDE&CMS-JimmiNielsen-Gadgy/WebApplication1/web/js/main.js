//GET PARAMETERS FROM URL! Thanks to http://techrevolt.wordpress.com/tag/get-url-parameter/
$.urlParam = function(name) {
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results == null) {
        return null;
    }
    else {
        return results[1] || 0;
    }
};

var ArrayInput = [];
var myInputName = {"name": "username", "placeholder": "Username", "id": "nameInput", "type": "text"};
var myInputEmail = {"name": "email", "placeholder": "Email", "id": "emailInput", "type": "email"};
var myInputFirstname = {"name": "firstname", "placeholder": "Firstname", "id": "firstnameInput", "type": "text"};
var myInputLastname = {"name": "lastname", "placeholder": "Lastname", "id": "lastnameInput", "type": "text"};
var myInputPassword = {"name": "password", "placeholder": "Password", "id": "passwordInput", "type": "password"};

ArrayInput.push(myInputFirstname);
ArrayInput.push(myInputLastname);
ArrayInput.push(myInputEmail);
ArrayInput.push(myInputName);
ArrayInput.push(myInputPassword);
for (var i = 0; i < ArrayInput.length; i++) {
    var sName = ArrayInput[i].name;
    var splace = ArrayInput[i].placeholder;
    var sid = ArrayInput[i].id;
    var sType = ArrayInput[i].type;
    $('#newuserForm').append('<div class="form-group"><label> <input class="form-control" name="' + sName + '" type="' + sType + '" placeholder="' + splace + '" id="' + sid + '"> </label>\n</div>');
}
$('#newuserFormBtn').append("<div class='form-group'><button id='SubmitBtn' class='btn btn-success' type='submit'>Create user</button></div>");

function myXMLhttp() {
    var xmlhttp;
    if (window.XMLHttpRequest) {// code for IE7 , Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    return xmlhttp;
}

$(document).on("click", "#SubmitBtn", function() {
    var params = {};
    username = document.getElementById("nameInput").value;
    password = document.getElementById("passwordInput").value;
    email = document.getElementById("emailInput").value;
    firstname = document.getElementById("firstnameInput").value;
    lastname = document.getElementById("lastnameInput").value;
    access = document.getElementById("access").value;
    //verify that the username and password fields are filled
    if (username == "") {
        alert("Please enter your username.");
        document.getElementById("nameInput").focus();
        return false;
    }
    if (password == "") {
        alert("Please enter your password.");
        document.getElementById("passwordInput").focus();
        return false;
    }

    var params = "command=newUser&username=" + username + "&password=" + password + "&email=" + email + "&firstname=" + firstname + "&lastname=" + lastname + "&access=" + access;

    var xmlhttp = myXMLhttp();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            //var user =  JSON.parse(xmlhttp.responseText);
            document.getElementById("created").innerHTML = xmlhttp.responseText;
        }
    };
    xmlhttp.overrideMimeType("application/json");
    xmlhttp.open("POST", "adminServlet", true);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlhttp.send(params);

});

function getUsers() {
    var params = {};
    var params = "command=getUser";
    var xmlhttp = myXMLhttp();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            //var user =  JSON.parse(xmlhttp.responseText);
            document.getElementById("currentUsers").innerHTML = xmlhttp.responseText;
        }
    };
    xmlhttp.overrideMimeType("application/json");
    xmlhttp.open("POST", "adminServlet", true);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlhttp.send(params);
}
function getUsersAdmin() {
    var params = {};
    var params = "command=getUserAdmin";
    var xmlhttp = myXMLhttp();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            //var user =  JSON.parse(xmlhttp.responseText);
            document.getElementById("currentUsers").innerHTML = xmlhttp.responseText;
        }
    };
    xmlhttp.overrideMimeType("application/json");
    xmlhttp.open("POST", "adminServlet", true);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlhttp.send(params);
}
if ($("body").hasClass("useradmin") || $("body").hasClass("useradmincontent")) {
    getUsers();
}
if ($("body").hasClass("masteradmin")) {
    getUsersAdmin();
}

$(document).on("click", ".deleteU", function() {
    var id = this.id;
    var params = {};
    var params = "command=deleteUser&id=" + id;
    var xmlhttp = myXMLhttp();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
        }
    };
    xmlhttp.overrideMimeType("application/json");
    xmlhttp.open("POST", "adminServlet", true);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlhttp.send(params);
    location.reload();
});

$(document).on("click", ".getInputs", function() {
    var id = this.id;
    var params = {};
    var params = "command=getInputs&id=" + id;
    var xmlhttp = myXMLhttp();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            document.getElementById("inputs").innerHTML = xmlhttp.responseText;
        }
    };
    xmlhttp.overrideMimeType("application/json");
    xmlhttp.open("POST", "adminServlet", true);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlhttp.send(params);
});

$(document).on("click", ".updateUsers", function() {
    var params = {};
    var id = this.id;

    email = document.getElementById("email+" + id).value;
    firstname = document.getElementById("firstname+" + id).value;
    lastname = document.getElementById("lastname+" + id).value;

    var params = "command=editUser&id=" + id + "&email=" + email + "&firstname=" + firstname + "&lastname=" + lastname;

    var xmlhttp = myXMLhttp();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            document.getElementById("inputstext").innerHTML = 'ok';
        }
    };
    xmlhttp.overrideMimeType("application/json");
    xmlhttp.open("POST", "adminServlet", true);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlhttp.send(params);
    location.reload();
});


$(document).on("click", "#loginBtn", function() {

    var params = {};
    username = document.getElementById("username").value;
    password = document.getElementById("password").value;
    //verify that the username and password fields are filled
    if (username == "") {
        alert("Please enter your username.");
        document.getElementById("username").focus();
        return false;
    }
    if (password == "") {
        alert("Please enter your password.");
        document.getElementById("password").focus();
        return false;
    }
    var params = "type=login&username=" + username + "&password=" + password;
    var xmlhttp = myXMLhttp();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            if (xmlhttp.responseText == 1) {
                $('#headline').html('Det er forkert fister!');
                $('#LoginUser').modal('toggle');
            }
            else {
                window.location.assign(xmlhttp.responseText);
            }
            $('#loginForm').fadeOut('slow');
        }
    };
    xmlhttp.overrideMimeType("application/json");
    xmlhttp.open("POST", "Servlet", true);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlhttp.send(params);
});

if ($("body").hasClass("subjectsIndex")) {
    type = 'getCategories';
    categoryType = $.urlParam('type');
    $.post("SubServlet", {"type": type, "categoryType": categoryType}, function(data) {
        var result = JSON.parse(data);
        console.log(result);
        $('#subjectName').append(categoryType);
        for (var i = 0; i < result.length; i++) {
            var subjectID = result[i].id;
            var subjectOverskrift = result[i].hovedemne;
            var subjectName = result[i].user;
            var countComment = result[i].count;
            var subjectDate = result[i].subjectdate;
            $("#subjects").append("<tr class='subject' id='" + subjectID + "'><td>" + subjectDate + "</td><td>" + subjectOverskrift + "</td><td>" + subjectName + "</td><td>" + countComment + "</td></tr>");
        }
    });
    $(document).on("click", ".subject", function() {
        id = this.id;
        $('#getComment').attr('action', 'commentSection.html?type=getComment&id=' + id);
        $("#getComment").submit();
    });
}

if ($("body").hasClass("cameraComment")) {
    type = $.urlParam('type');
    id = $.urlParam('id');// name
    $.post("SubServlet", {"type": type, id: id}, function(data) {
        var result = JSON.parse(data);
        console.log(result);
        for (var i = 0; i < result.length; i++) {
            var commentID = result[i].id;
            var comment = result[i].comment;
            var user = result[i].user;
            var subjectID = result[i].subject_id;
            var commentTime = result[i].commentTime;
            $("#comment").append("<tr class='comment' id='" + commentID + "'><td>" + commentTime + "</td><td>" + comment + "</td><td>" + user + "</td><td class='commentdelete none'><a id='" + commentID + "' class='deleteCommentBtn'>Delete</a></td></tr>");
        }
    });

    type2 = 'getSubject';
    $.post("SubServlet", {"type": type2, id: id}, function(data) {
        var result = JSON.parse(data);
        for (var i = 0; i < result.length; i++) {
            var subjectID = result[i].id;
            var subjectOverskrift = result[i].hovedemne;
            var subjectName = result[i].user;

            $("#subjectTopic").append("Subject: " + subjectOverskrift);
            $("#subjectUser").append("Asked by: " + subjectName);
        }
    });
}
type3 = "checkSession";
$.post("Servlet", {"type": type3}, function(data) {
    if (!data) {
        $('#createSubject').empty();
        $(document).ready(function() {
            var pathname = window.location.pathname;
            if (pathname.indexOf('masterAdmin') > -1 || pathname.indexOf('useradmin') > -1 || pathname.indexOf('usercontent') > -1 || pathname.indexOf('useradmincontent') > -1) {
                window.location.assign('index.html');
                $('body.masteradmin').empty();
                $('body.useradmin').empty();
                $('body.usercontent').empty();
                $('body.useradmincontent').empty();
            }
        });
        setInterval(function() {
            $('#thDelete').empty();
            $('.commentdelete').empty();
        }, 10);
        $("#commentArea").prop('disabled', true);
        $("#createComment").prop('disabled', true);
    }
    else if (data) {
        $('#createSubjectwrapper').html('<button class="btn btn-info" data-toggle="modal" data-target="#createSubjectModal">Create Subject</button>');
        $('#userAccount').html('<a id="seeUserInfo" class="" data-toggle="modal" data-target="#userAccountModal">Account</a>');
        $('#loginformInner').css('display', 'none');
        $('#logoutBtn').fadeIn('slow');

        var result = JSON.parse(data);
        console.log(result);
        for (var i = 0; i < result.length; i++) {
            var level = "";
            var levelIcon = "";
            var userName = result[i].username;
            var firstName = result[i].firstName;
            var lastName = result[i].lastName;
            var userEmail = result[i].email;
            var username = result[i].username;
            var points = result[i].points;
            var access = result[i].access;
            var id = result[i].id;
            var img = result[i].img;
            $('#userImg').attr('src', img)
            $('#editFirstname').val(firstName);
            $('#editLastname').val(lastName);
            $('#editEmail').val(userEmail);
            $('.editUserBtn').attr("id", id);
            $('#createUserLi').empty();
            if (points <= 10) {
                var level = "Padawan";
                var levelIcon = "padawan";
            }
            if (points > 10 && points < 20) {
                var level = "Jedi";
                var levelIcon = "luke";
            }
            if (points >= 30) {
                var level = "Sith";
                var levelIcon = "vader";
            }
            if (points >= 50) {
                var level = "Master Jedi";
                var levelIcon = "yoda";
            }
            $('.media-heading').append(firstName + " " + lastName);
            $('#myModalLabel2').append("Lets hear more about " + firstName);
            $('#userInfo').append("<div class='pull-left'><p>Username: " + username + "</p><p>E-mail: " + userEmail + "</p><p>Points: " + points + "</p><p>Level: " + level + "</p></div> <img class='pull-right' src='img/" + levelIcon + ".png' alt='Level'><div class='clearfix'></div>");
            $("#userName").append("Welcome: <strong>" + userName + "</strong>");
            if (access == 4 || access == 3 || access == 1) {
                setInterval(function() {
                    $('#thDelete').removeClass('none');
                    $('.commentdelete').removeClass('none');
                }, 10);
            }
            else {
                setInterval(function() {
                    $('#thDelete').empty();
                    $('.commentdelete').empty();
                }, 10);
            }
            if (access == 3) {
                $('#adminButton').append("<a class='' href='masterAdmin.html'>Admin page</a>");
            }
            if (access == 4) {
                $('#adminButton').append("<a class='' href='useradmincontent.html'>Admin page</a>");
            }
            if (access == 2) {
                $('#adminButton').append("<a class='' href='useradmin.html'>Admin page</a>");
            }
            if (access == 1) {
                $('#adminButton').append("<a class='' href='usercontent.html'>Admin page</a>");
            }
        }
        if ($("body").hasClass("masteradmin")) {
            if (access != 3) {
                $('body.masteradmin').empty();
                window.location.assign('index.html');
            }
        }
        if ($("body").hasClass("useradmin")) {
            if (access != 2) {
                $('body.useradmin').empty();
                window.location.assign('index.html');
            }
        }
        if ($("body").hasClass("usercontent")) {
            if (access != 1) {
                $('body.usercontent').empty();
                window.location.assign('index.html');
            }
        }
        if ($("body").hasClass("useradmincontent")) {
            if (access != 4) {
                $('body.useradmincontent').empty();
                window.location.assign('index.html');
            }
        }
    }
});
type4 = "deleteSession";
$(document).on("click", "#logoutBtn", function() {
    $.post("Servlet", {"type": type4}, function(data) {
        if (data) {
            window.location.assign('index.html');
        }
    });
});

$(document).on("click", "#createSubjectBtn", function() {
    type5 = "createSubject";
    typeGadget = $.urlParam('type');
    subject = $('#inputSubject').val();
    $.post("SubServlet", {"type": type5, "typeGadget": typeGadget, "subject": subject}, function(data) {
        if (data) {
            $('#createSubjectModal').modal('hide');
            $('#success').modal('toggle');
        }
        if (!data) {
            alert('Error Try again');
        }
    });
});
$(document).on("click", "#refresh", function() {
    location.reload();
});

$(document).on("click", "#createComment", function() {
    SubID = $.urlParam('id');// name
    type6 = "createComment";
    comment = $('#commentArea').val();

    $.post("SubServlet", {"type": type6, "comment": comment, "subID": SubID}, function(data) {
        if (data) {
            location.reload();
        }
        if (!data) {
            alert('error');
        }
    });
});

$(document).on("click", ".deleteCommentBtn", function() {
    type7 = "deleteComment";
    id = this.id;
    $.post("SubServlet", {"type": type7, "id": id}, function(data) {
        if (data) {
            location.reload();
        }
        if (!data) {
            alert('error');
        }
    });
});

$(document).on("click", "#loginUser", function() {
    type9 = "login";
    $.post("Servlet", {"type": type9, "username": username, "password": password}, function(data) {
        if (data) {
            location.reload();
        }
        if (!data) {
            alert('error');
        }
    });
});

$(document).on('change', '.permissionSelect', function() {
    type10 = "changePermission";
    permissionID = $(this).val();
    id = this.id;
    $.post("adminServlet", {"command": type10, "id": id, "permissionID": permissionID}, function(data) {
        if (data) {
            location.reload();
        }
        if (!data) {
            alert('error');
        }
    });
});

if ($("body").hasClass("index") || $("body").hasClass("masteradmin") || $("body").hasClass("useradmincontent")) {
    type12 = 'getCategory';
    $.post("SubServlet", {"type": type12}, function(data) {
        var result = JSON.parse(data);
        for (var i = 0; i < result.length; i++) {
            var categoryName = result[i].category;
            var categoryIcon = result[i].icon;
            $('#categories').append("<form method='post' class='categoryForm'><div class='col-sm-6 col-md-3 portfolio-item'><a id='" + categoryName + "' class='categoryGet'><i class='fa " + categoryIcon + " fa-5x'></i><p>" + categoryName + "</p></a></div></form>");
        }
    });
    $(document).on("click", ".categoryGet", function() {
        event.preventDefault();
        id = this.id;
        $('.categoryForm').attr('action', 'subjectSection.html?type=' + id + '');
        $(".categoryForm").submit();
    });
}

$(document).on("click", "#createCategory", function() {
    categoryName = $('#category').val();
    categoryIcon = $('#categoryIcon').val();
    type13 = 'createCategory';
    $.post("SubServlet", {"type": type13, "categoryName": categoryName, "categoryIcon": categoryIcon}, function(data) {
        if (data) {
            location.reload();
        }
        if (!data) {
            alert('error');
        }
    });
});

$(document).on("click", "#backBtn", function() {
    window.history.back();
});

$(document).on("click", ".editUserBtn", function() {
    id = this.id;
    commandEditUser = "editUserInfo";
    Firstname = $('#editFirstname').val();
    Lastname = $('#editLastname').val();
    Email = $('#editEmail').val();
    $.post("adminServlet", {"command": commandEditUser, "id": id, "Firstname": Firstname, "Lastname": Lastname, "Email": Email}, function(data) {
        if (data) {
            location.reload();
        }
        if (!data) {
            alert('error');
        }
    });
});

//Base64 encoding - Thanks to http://www.nickdesteffen.com/blog/file-uploading-over-ajax-using-html5

var files = [];
$(function() {
    $("#attachment").change(function(event) {
        $.each(event.target.files, function(index, file) {
            var reader = new FileReader();
            reader.onload = function(event) {
                object = {};
                object.filename = file.name;
                object.data = event.target.result;
                files.push(object);
            };
            reader.readAsDataURL(file);
        });
    });

    $("#ajax-attachment-upload-form").submit(function(form) {
        type8 = "createUser";
        firstname = $('#firstnameUser').val();
        lastname = $('#lastnameUser').val();
        username = $('#usernameUser').val();
        password = $('#passwordUser').val();
        email = $('#emailUser').val();
        access = $('#accessUser').val();
        $.each(files, function(index, file) {
            $.post("adminServlet", {command: type8, filename: file.filename, data: file.data, "firstname": firstname, "lastname": lastname, "username": username, "password": password, "email": email, "access": access}, function(data) {
                if (data == 1) {
                    $('#successUser').modal('toggle');
                }
                if (data == 2) {
                    $('#errorUser').modal('toggle');
                }
            });
        });
        files = [];
        form.preventDefault();
    });
});

