$(document).ready(function () {
    
    $(document).on("click", "#logOut", function () {
        event.preventDefault();
        $(".logOut").submit();
    });

    $(document).on("click", ".backBtn", function () {
        window.history.back();
    });
    if ($('body').hasClass('index')) {
        checkLog = "checkLog";
        $.post("checklogin.php", {type: checkLog}, function (data) {
            var result = JSON.parse(data);
            if (result != 'noData' && result != 'safe') {
                $('.loginForm').empty();
                $('#loginForm').html('Too many login attempts, please try again in 5 minutes<br>The page will refresh itself.<br>' + result);
                setTimeout(function () {
                    location.reload();
                }, 300100);
//                alert(result);
            }
            else{
                                $('#loginForm').empty();
                                $('#loginForm').css('margin','0');
                                $('#loginForm').css('padding','0');

            }
        });
        loggedIn = $.cookie('loggedIn'); // => 'the_value'
        cookie = $.cookie('userInfo'); // => 'the_value'

        if (loggedIn == 'true' && cookie != '') { // if empty
            window.location = 'main_page.php';
        }
        ;
    }

    $(".loginForm").validate({
        ignore: ":hidden",
        rules: {
            email: {
                required: true
            },
            password: {
                required: true
            }
        },
        submitHandler: function (form) {
            login = "login";
            sName = $("#email").val();
            sPass = $("#password").val();

            $.post("checklogin.php", {type: login, "email": sName, "password": sPass}, function (data) {
                var result = JSON.parse(data);
                if (result == 'error') {
                    alert('error');
                }
                else {
                    window.location = 'main_page.php'; //load new page
                }
            });
            return false; // required to block normal submit since you used ajax
        }
    });

    $(".createUserForm").validate({
        ignore: ":hidden",
        rules: {
            first_name: {
                required: true
            },
            new_email: {
                required: true
            },
            new_password: {
                required: true
            },
            last_name: {
                required: true
            }
        }

    });

    var files = [];
    $(function () {
        $(".attachmentUser").change(function (event) {
            $.each(event.target.files, function (index, file) {
                var reader = new FileReader();
                reader.onload = function (event) {
                    object = {};
                    object.filename = file.name;
                    object.data = event.target.result;
                    files.push(object);
                };
                reader.readAsDataURL(file);
            });
        });
        $("#submitFormUser").submit(function (form) {
            createUser = "createUser";
            sFirstName = $("#first_name").val();
            sLastname = $("#last_name").val();
            sNewEmail = $("#new_email").val();
            sNewPass = $("#new_password").val();

            $.each(files, function (index, file) {
                $.post("create_user.php", {"type": createUser, "new_mail": sNewEmail, "first_name": sFirstName, "last_name": sLastname, "new_password": sNewPass, "filename": file.filename, "data": file.data}, function (data) {
//                var result = JSON.parse(data);
//                if (result == 'success') {
//                    $('#createUserSuccess').fadeIn('slow');
//                    $("#first_name").val('');
//                    $("#last_name").val('');
//                    $("#new_email").val('');
//                    $("#new_password").val('');
//                }
//                if (result == 'error') {
//                    alert('error');
//                }
                    if (data) {
                        var result = JSON.parse(data);

                        if (result == 'noscripts') {
                        alert('No scripts allowed');
                         }
                    else {
                          $('#createUserSuccess').fadeIn('slow');
                        // alert('New user created');
                    }
                      

                    }
                   
                });
            });
            files = [];
            form.preventDefault();
        });
    });







//            $.ajax({
//                type: "POST",
//                url: "create_user.php",
//                data: {"type": createUser, "new_mail": sNewEmail, "first_name": sFirstName, "last_name": sLastname, "new_password": sNewPass},
//                success: function (data) {
//                    var result = JSON.parse(data);
//                    if (result == 'success') {
//                        $('#createUserSuccess').fadeIn('slow');
//                        $("#first_name").val('');
//                        $("#last_name").val('');
//                        $("#new_email").val('');
//                        $("#new_password").val('');
//                    }
//                    if (result == 'error') {
//                        alert('error');
//                    }

//                }
//            });
//            return false; 



    var files = [];
    $(function () {
        $(".attachment").change(function (event) {
            $.each(event.target.files, function (index, file) {
                var reader = new FileReader();
                reader.onload = function (event) {
                    object = {};
                    object.filename = file.name;
                    object.data = event.target.result;
                    files.push(object);
                };
                reader.readAsDataURL(file);
            });
        });
        $("#submitFormNews").submit(function (form) {
            createNews = "createNews";
            sTextInput = $("#text_input_test").val();
            $.each(files, function (index, file) {
                $.post("checklogin.php", {type: createNews, filename: file.filename, data: file.data, "text_input": sTextInput}, function (data) {
                    if (data) {
                        var result = JSON.parse(data);
                        $('#createNewsSuccess').fadeIn('slow');
                        // alert('New user created');
                    }
                });
            });
            files = [];
            form.preventDefault();
        });
    });

    if ($('body').hasClass('main')) {

        $(document).on("click", "#addComment", function () {

            if ($.trim($("div.nicEdit-main").html()) == '') {
                alert('HEY! Its empty');
            }
            else {
                comment = $("div.nicEdit-main").html();
                commentType = "comment";
                contentnr = $('.commentArea').attr('id');
                userID = $('.commentArea').attr('name');

                $.post("checklogin.php", {"type": commentType, "comment": comment, "contentnr": contentnr, "userID": userID}, function (data) {
                    if (data) {
                        location.reload();
                    }
                    if (!data) {
                        alert('error');
                    }
                });
            }
        });

        typeGetNews = "typeGetNews";
        $.post("checklogin.php", {"type": typeGetNews}, function (data) {
            var result = JSON.parse(data);
            if (result == '') {
                $("#appendNews").append("<h2 class='text-center'>Unfortunately no secret images has been uploaded yet</h2>");
            }
            else {
                for (var i = 0; i < result.length; i++) {
                    var text = result[i].text_input;
                    var image = result[i].image;
                    var randomnr = result[i].randomnr;
                    $("#appendNews").append("<div class='jumbotron' style='background:url(" + image + ");'><div class='jumbotron_text'><h1>Hello, world!</h1><p>" + text + "</p><p><a class='btn btn-primary btn-lg' href='comment.php?comment=" + randomnr + "' role='button'>Learn more</a></p></div></div>");

                }
            }
        });

        getInfo = "getInfo";
        cookie = $.cookie('userInfo'); // => 'the_value'
        $.post("checklogin.php", {"type": getInfo, "cookie": cookie}, function (data) {
            var result = JSON.parse(data);
            for (var i = 0; i < result.length; i++) {
                var validation = result[0];
                var name = result[1];
            }
            $('#pName').html(name + " Profile page");
            if (validation == "2") {
                $('#pName').html(name + " Profile page");
                $('#Info').empty();
            }
        });


        $(document).on("click", "#pName", function () {
            cookie = $.cookie('userInfo'); // => 'the_value'
            $.post("checklogin.php", {"type": 'getInfoProfile', "cookie": cookie}, function (data) {
                var result = JSON.parse(data);
                for (var i = 0; i < result.length; i++) {
                    var first_name = result[0];
                    var last_name = result[1];
                    var email = result[2];
                    var img = result[3];
                    $('#profileName').html("Hello " + first_name);
                    $('#update_first_name').val(first_name);
                    $('#update_last_name').val(last_name);
                    $('#update_email').val(email);
                    $('.profileImg').attr('src', img);
                }
            });
        });

        $(".updateUserForm").validate({
            ignore: ":hidden",
            rules: {
                update_first_name: {
                    required: true
                },
                update_email: {
                    required: true
                },
                update_last_name: {
                    required: true
                }
            },
            submitHandler: function (form) {
                updateUser = "updateUser";
                cookie = $.cookie('userInfo'); // => 'the_value'
                sFirstName = $("#update_first_name").val();
                sLastname = $("#update_last_name").val();
                sNewEmail = $("#update_email").val();

                $.post("create_user.php", {"type": updateUser, "new_mail": sNewEmail, "first_name": sFirstName, "last_name": sLastname, "cookie": cookie}, function (data) {
                    var result = JSON.parse(data);
                    if (result == 'success') {
                        location.reload();
                    }
                    if (result == 'error') {
                        alert('Something stupid happened');
                    }
                      if (result == 'noscripts') {
                        alert('No scripts allowed');
                    }
                });
            }
        });


  $(".changePassword").validate({
            ignore: ":hidden",
            rules: {
                old_password: {
                    required: true
                },
                new_password: {
                    required: true
                },
                new_password2: {
                    required: true
                }
            },
            submitHandler: function (form) {
                changePassword = "changePassword";
                cookie = $.cookie('userInfo'); // => 'the_value'
                sOldPassword = $("#old_password").val();
                sNewPassword = $("#new_password").val();
                sNewPassword2 = $("#new_password2").val();

                $.post("create_user.php", {"type": changePassword, "old_password": sOldPassword, "new_password": sNewPassword, "new_password2": sNewPassword2, "cookie": cookie}, function (data) {
                    var result = JSON.parse(data);
                    if (result == 'success') {
                        $('#updatePasswordSuccess').fadeIn('slow');
                        $("#old_password").val("");
                        $("#new_password").val("");
                        $("#new_password2").val("");
                        
                    }
                    if (result == 'error') {
                    $('#updatePasswordError').fadeIn('slow');
                    $("#old_password").val("");
                    $("#new_password").val("");
                    $("#new_password2").val("");
                    $( "#old_password" ).focus(function() {
                    $('#updatePasswordError').fadeOut('1000');
                    });
                    }
                     if (result == 'noscripts') {
                        alert('No scripts allowed');
                    }
                });
            }
        });



    }
    if ($('body').hasClass('comment')) {
        typeGetNewsComment = "typeGetNewsComment";

        contentnr = $('.commentArea').attr('id');
        $.post("checklogin.php", {"type": typeGetNewsComment, "contentnr": contentnr}, function (data) {
            var result = JSON.parse(data);
            for (var i = 0; i < result.length; i++) {
                var text = result[i].text_input;
                var image = result[i].image;
                $("#appendNews2").append("<div class='jumbotron' style='background:url(" + image + ");'><div class='jumbotron_text'><h1>Hello, world!</h1><p>" + text + "</p></div></div>");
            }
        });
    }
});